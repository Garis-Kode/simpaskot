<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Route;
use Illuminate\Http\Request;

class AnalystController extends Controller
{
    public function index(Request $request, $id)
    {
        $route = Route::where('id', $id)->first();
        $start_point = $this->startPoint($id);
        $end_point = $this->endPoint($id);
        $locations = $this->getLocations($id);
        $vehicles = $this->getVehicles($id);
        $T = $request->query('t0', 5000);
        $T_min = $request->query('t1', 1);
        $alpha = $request->query('alpha', 0.55);
        $max_iter = $request->query('iteration', 1000);
        $max_volume = 6; // Maksimal volume kendaraan dalam m3
        $vehicle_speed = 50; // km/h
        $stop_time = 15; // waktu berhenti di setiap titik dalam menit
        $start_time = '08:00'; // waktu mulai

        $results = [];
        $visited_locations = [];
        $current_start_time = $start_time;

        foreach ($vehicles as $vehicle) {
            $fuel_price_per_km = $vehicle['fuel_price'];
            $remaining_locations = array_filter($locations, function($location) use ($visited_locations) {
                return !in_array($location['name'], $visited_locations);
            });

            // Jika tidak ada lokasi tersisa untuk dikunjungi, hentikan proses
            if (empty($remaining_locations)) {
                break;
            }

            $initial_route = array_keys($remaining_locations);
            shuffle($initial_route);

            // Pastikan start_point berada di awal dan end_point berada di akhir rute
            array_unshift($initial_route, 'start'); // Start point key
            array_push($initial_route, 'end'); // End point key

            $result = $this->simulatedAnnealing($remaining_locations, $initial_route, $start_point, $end_point, $max_volume, $fuel_price_per_km, $T, $T_min, $alpha, $max_iter, $vehicle_speed, $stop_time, $current_start_time);

            if (!empty($result['iterations'])) {
                $results[] = [
                    'vehicle' => $vehicle,
                    'best_route' => $result['best_route'],
                    'best_distance' => $result['best_distance'],
                    'best_distance_km' => $result['best_distance_km'],
                    'best_time' => $result['best_time'],
                    'best_time_formatted' => $result['best_time_formatted'],
                    'best_time_range' => $result['best_time_range'],
                    'best_fuel_price' => $result['best_fuel_price'],
                    'best_iteration' => $result['best_iteration'],
                    'best_temperature' => $result['best_temperature'],
                    'iterations' => $result['iterations'],
                ];

                // Tambahkan lokasi yang dikunjungi oleh kendaraan ini ke dalam daftar visited_locations
                foreach ($result['best_route'] as $point) {
                    if ($point['name'] !== 'POOL' && $point['name'] !== 'TPAS') {
                        $visited_locations[] = $point['name'];
                    }
                }

                // Update waktu mulai untuk kendaraan berikutnya berdasarkan waktu akhir kendaraan saat ini
                $current_start_time = $this->calculateEndTime($current_start_time, $result['best_time']);
            }
        }

        $data = [
            'title' => 'Analysis',
            'subTitle' => $route->name,
            'route' => $route,
            'result' => $results,
            't0' => $T,
            't1' => $T_min,
            'alpha' => $alpha,
            'iteration' => $max_iter
        ];  

        // return $data['result'];
        return view('pages.analyst', $data);
    }

    private function startPoint($id)
    {
        $point = Route::where('id', $id)->first();
        return $point->pool;
    }

    private function endPoint($id)
    {
        $point = Route::where('id', $id)->first();
        return $point->landfill;
    }

    private function getLocations($id)
    {
        $point = Route::where('id', $id)->first();
        $result = [];
        foreach ($point->location as $location) {
            $result[$location->dumpingPlace->name] = $location->dumpingPlace;
        };
        return $result;
    }

    private function getVehicles($id)
    {
        $point = Route::where('id', $id)->first();
        $result = [];
        foreach ($point->trucks as $trucks) {
            $result[] = $trucks->garbageTruck;
        };
        return $result;
    }

    private function haversineDistance($loc1, $loc2)
    {
        $earth_radius = 6371; // Radius bumi dalam kilometer

        $lat1 = deg2rad($loc1['latitude']);
        $lon1 = deg2rad($loc1['longitude']);
        $lat2 = deg2rad($loc2['latitude']);
        $lon2 = deg2rad($loc2['longitude']);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) * sin($dlat / 2) +
             cos($lat1) * cos($lat2) *
             sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earth_radius * $c;
    }

    private function totalDistance($route, $locations, $start_point, $end_point)
    {
        $distance = 0;
        $points = array_merge(['start' => $start_point], $locations, ['end' => $end_point]);

        for ($i = 0; $i < count($route) - 1; $i++) {
            $distance += $this->haversineDistance($points[$route[$i]], $points[$route[$i + 1]]);
        }
        return $distance;
    }

    private function formatTime($minutes)
    {
        $min = floor($minutes);
        $sec = round(($minutes - $min) * 60);
        return sprintf("%d minutes %d seconds", $min, $sec);
    }

    private function formatDistance($distance)
    {
        return sprintf("%.2f kilometers", $distance);
    }

    private function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 2, ',', '.');
    }

    private function totalTime($distance, $speed = 50, $stop_time = 30, $stops = 0)
    {
        $travel_time = ($distance / $speed) * 60; // waktu dalam menit
        $total_time = $travel_time + ($stops * $stop_time); // waktu total termasuk berhenti
        return $total_time;
    }

    private function calculateEndTime($start_time, $duration_minutes)
    {
        $start_time = strtotime($start_time);
        $end_time = $start_time + ($duration_minutes * 60);
        return date('H:i', $end_time);
    }

    private function simulatedAnnealing($locations, $route, $start_point, $end_point, $max_volume, $fuel_price_per_km, $T, $T_min, $alpha, $max_iter, $vehicle_speed, $stop_time, $start_time)
    {
        $current_route = $this->generateRoute($route, $start_point, $end_point, $locations, $max_volume);
        $stops = count($current_route) - 2; // menghitung jumlah titik berhenti, tidak termasuk start dan end
        $current_distance = $this->totalDistance($current_route, $locations, $start_point, $end_point);
        $current_time = $this->totalTime($current_distance, $vehicle_speed, $stop_time, $stops);
        $current_fuel_price = $current_distance * $fuel_price_per_km;
        $best_route = $current_route;
        $best_distance = $current_distance;
        $best_time = $current_time;
        $best_fuel_price = $current_fuel_price;
        $best_iteration = 0;
        $best_temperature = $T;

        $best_end_time = $this->calculateEndTime($start_time, $best_time);

        $iterations = [];

        for ($i = 0; $i < $max_iter; $i++) {
            if ($T <= $T_min) {
                break;
            }

            $new_route = $this->generateRoute(array_merge(['start'], array_keys($locations), ['end']), $start_point, $end_point, $locations, $max_volume);
            $new_stops = count($new_route) - 2; // menghitung jumlah titik berhenti, tidak termasuk start dan end
            $new_distance = $this->totalDistance($new_route, $locations, $start_point, $end_point);
            $new_time = $this->totalTime($new_distance, $vehicle_speed, $stop_time, $new_stops);
            $new_fuel_price = $new_distance * $fuel_price_per_km;
            $delta_distance = $new_distance - $current_distance;

            if ($delta_distance < 0 || exp(-$delta_distance / $T) > rand() / getrandmax()) {
                $current_route = $new_route;
                $current_distance = $new_distance;
                $current_time = $new_time;
                $current_fuel_price = $new_fuel_price;
                if ($new_distance < $best_distance) {
                    $best_route = $new_route;
                    $best_distance = $new_distance;
                    $best_time = $new_time;
                    $best_fuel_price = $new_fuel_price;
                    $best_iteration = $i;
                    $best_temperature = $T;
                    $best_end_time = $this->calculateEndTime($start_time, $best_time);
                }
            }

            // Simpan data iterasi
            $iterations[] = [
                'iteration' => $i,
                'temperature' => $T,
                'distance' => $current_distance,
                'distance_km' => $this->formatDistance($current_distance),
                'time' => $current_time,
                'time_formatted' => $this->formatTime($current_time),
                'fuel_price' => $this->formatRupiah($current_fuel_price),
                'route' => $this->formatRoute($current_route, $locations, $start_point, $end_point),
            ];

            $T *= $alpha;
        }

        $best_time_range = $start_time . ' - ' . $best_end_time;

        return [
            'best_route' => $this->formatRoute($best_route, $locations, $start_point, $end_point),
            'best_distance' => $best_distance,
            'best_distance_km' => $this->formatDistance($best_distance),
            'best_time' => $best_time,
            'best_time_formatted' => $this->formatTime($best_time),
            'best_time_range' => $best_time_range,
            'best_fuel_price' => $this->formatRupiah($best_fuel_price),
            'best_iteration' => $best_iteration,
            'best_temperature' => $best_temperature,
            'iterations' => $iterations,
        ];
    }

    private function generateRoute($route, $start_point, $end_point, $locations, $max_volume)
    {
        $new_route = ['start']; // Start point key
        $current_volume = 0;
        $end_point_visits = 0; // Jumlah kunjungan ke endpoint
        $points = array_merge(['start' => $start_point], $locations, ['end' => $end_point]);

        foreach ($route as $index) {
            if ($index === 'start') {
                continue;
            }

            if ($index === 'end') {
                if ($end_point_visits >= 1) {
                    break;
                }
                $end_point_visits++;
                $new_route[] = 'end';
            } else {
                $current_volume += $points[$index]['volume'];

                if ($current_volume > $max_volume) {
                    if ($end_point_visits >= 1) {
                        break;
                    }
                    $new_route[] = 'end'; // End point key
                    $current_volume = $points[$index]['volume'];
                    $end_point_visits++;
                }
                $new_route[] = $index;
            }
        }

        if ($end_point_visits < 2) {
            $new_route[] = 'end'; // Ensure the route ends at the end point only once more if needed
        }

        return $new_route;
    }

    private function formatRoute($route, $locations, $start_point, $end_point)
    {
        $points = array_merge(['start' => $start_point], $locations, ['end' => $end_point]);

        return array_map(function($key) use ($points) {
            return $points[$key];
        }, $route);
    }
}
