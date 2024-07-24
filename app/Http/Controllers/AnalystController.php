<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalystController extends Controller
{
    public function index()
    {
        $start_point = $this->startPoint();
        $end_point = $this->endPoint();
        $locations = $this->getLocations();
        $vehicles = $this->getVehicles();
        $max_volume = 3; // Maksimal volume kendaraan dalam m3
        $T = 5000;
        $T_min = 1;
        $alpha = 0.55;
        $max_iter = 1000;
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

        return response()->json($results);
    }

    private function startPoint()
    {
        return [
            'name' => 'POOL',
            'address' => 'Kantor DLH Kota Lhoksemawe',
            'latitude' => 5.1848613681201,
            'longitude' => 97.142155634123,
        ];
    }

    private function endPoint()
    {
        return [
            'name' => 'TPAS',
            'address' => 'TPAS Alue Lim',
            'latitude' => 5.1295233611464,
            'longitude' => 97.119761785693,
        ];
    }

    private function getLocations()
    {
        return [
            'TP-01' => [
                'name' => 'TP-01',
                'address' => 'Pasar Ikan Kota',
                'latitude' => 5.1743300465385,
                'longitude' => 97.151824604081,
                'volume' => 1
            ],
            'TP-02' => [
                'name' => 'TP-02',
                'address' => 'Jembatan Cunda',
                'latitude' => 5.177609224689,
                'longitude' => 97.130966438378,
                'volume' => 1
            ],
            'TP-03' => [
                'name' => 'TP-03',
                'address' => 'Lapas',
                'latitude' => 5.1797211948054,
                'longitude' => 97.149192296048,
                'volume' => 1
            ],
            'TP-04' => [
                'name' => 'TP-04',
                'address' => 'Pasar Impress',
                'latitude' => 5.1836980248889,
                'longitude' => 97.142149096048,
                'volume' => 1
            ],
            'TP-05' => [
                'name' => 'TP-05',
                'address' => 'Cunda',
                'latitude' => 5.1750212578548,
                'longitude' => 97.130529418679,
                'volume' => 1
            ],
            'TP-06' => [
                'name' => 'TP-06',
                'address' => 'Kompi Brimob',
                'latitude' => 5.1360689732979,
                'longitude' => 97.107415589353,
                'volume' => 1
            ],
            'TP-07' => [
                'name' => 'TP-07',
                'address' => 'Pesantren Lhok Mon Puteh',
                'latitude' => 5.1612177166281,
                'longitude' => 97.129517397292,
                'volume' => 1
            ],
            'TP-08' => [
                'name' => 'TP-08',
                'address' => 'Politeknik',
                'latitude' => 5.120614308847,
                'longitude' => 97.158366296048,
                'volume' => 1
            ],
            'TP-09' => [
                'name' => 'TP-09',
                'address' => 'Rumah Sakit Umum',
                'latitude' => 5.1221308850208,
                'longitude' => 97.156367699476,
                'volume' => 1
            ],
            'TP-10' => [
                'name' => 'TP-10',
                'address' => 'Dayah Paloh',
                'latitude' => 5.2101562314618,
                'longitude' => 97.084714788057,
                'volume' => 1
            ],
            'TP-11' => [
                'name' => 'TP-11',
                'address' => 'Punteut',
                'latitude' => 5.1160453588676,
                'longitude' => 97.168242087696,
                'volume' => 1
            ],
            'TP-12' => [
                'name' => 'TP-12',
                'address' => 'Blang Rayeuk',
                'latitude' => 5.1945017596566,
                'longitude' => 97.13469391932,
                'volume' => 3
            ],
            'TP-13' => [
                'name' => 'TP-13',
                'address' => 'Dayah Abu Bakar',
                'latitude' => 5.1153571741178,
                'longitude' => 97.172158280235,
                'volume' => 3
            ],
            'TP-14' => [
                'name' => 'TP-14',
                'address' => 'Kesrem',
                'latitude' => 5.1824297190881,
                'longitude' => 97.150219540007,
                'volume' => 1
            ],
            'TP-15' => [
                'name' => 'TP-15',
                'address' => 'Lapangan BI',
                'latitude' => 5.2062485514116,
                'longitude' => 97.073040111749,
                'volume' => 3
            ],
        ];
    }

    private function getVehicles()
    {
        return [
            [
                'license_plate' => 'BL 123 ABC',
                'driver_name' => 'John Doe',
                'fuel_price' => 1430,
            ],
            [
                'license_plate' => 'BL 1271 OL',
                'driver_name' => 'Jane',
                'fuel_price' => 1200,
            ],
            [
                'license_plate' => 'BL 1222 OL',
                'driver_name' => 'Jack',
                'fuel_price' => 1200,
            ],
            [
                'license_plate' => 'BL 7899 DBC',
                'driver_name' => 'Michael',
                'fuel_price' => 1500,
            ],
        ];
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
