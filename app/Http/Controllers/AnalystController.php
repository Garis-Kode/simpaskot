<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class AnalystController extends Controller
{
    protected $truckSpeed = 50; // Kecepatan truk dalam km/jam

    public function calculateDistance($point1, $point2, $points)
    {
        $lat1 = $points[$point1][0];
        $lon1 = $points[$point1][1];
        $lat2 = $points[$point2][0];
        $lon2 = $points[$point2][1];
        return sqrt(pow($lat2 - $lat1, 2) + pow($lon2 - $lon1, 2)) * 111;
    }

    public function calculateTotalCost($route, $points, $fuelPricePerKm, &$totalDistance)
    {
        $totalCost = 0;
        $totalDistance = 0;
        for ($i = 0; $i < count($route) - 1; $i++) {
            $distance = $this->calculateDistance($route[$i], $route[$i + 1], $points);
            $totalDistance += $distance;
            $totalCost += $distance * $fuelPricePerKm;
        }
        return $totalCost;
    }

    public function getNeighbor($solution)
    {
        $newSolution = $solution;
        $i = rand(1, count($newSolution) - 2); // Random index excluding first and last
        $j = rand(1, count($newSolution) - 2); // Random index excluding first and last
        $temp = $newSolution[$i];
        $newSolution[$i] = $newSolution[$j];
        $newSolution[$j] = $temp;
        return $newSolution;
    }

    public function acceptanceProbability($oldCost, $newCost, $temperature)
    {
        if ($newCost < $oldCost) {
            return 1.0;
        }
        return exp(($oldCost - $newCost) / $temperature);
    }

    public function generateRouteWithVolumeConstraints($solution, $points, $volume, $truckVolume)
    {
        $routeWithConstraints = ['start'];
        $currentVolume = 0;

        foreach ($solution as $point) {
            if ($point == 'start' || $point == 'end') {
                continue;
            }

            if ($currentVolume + $volume[$point][0] > $truckVolume) {
                $routeWithConstraints[] = 'end';
                $currentVolume = 0;
            }

            $routeWithConstraints[] = $point;
            $currentVolume += $volume[$point][0];
        }

        $routeWithConstraints[] = 'end';
        return $routeWithConstraints;
    }

    public function index(Request $request, $id)
    {
        $route = Route::findOrFail($id);
        $points = [];
        $volume = [];
        $locations = [];

        // Add initial fixed point
        $start = $route->pool;
        $points['start'] = [$start->latitude, $start->longitude];
        $locations['start'] = [
            'name' => $start->name,
            'address' => $start->address,
            'longitude' => $start->longitude,
            'latitude' => $start->latitude
        ];

        foreach ($route->location as $location) {
            $dumpingPlace = $location->dumpingPlace;
            $latitude = $dumpingPlace->latitude;
            $longitude = $dumpingPlace->longitude;
            $volumePoint = $dumpingPlace->volume;
            $key = $dumpingPlace->name;
            $points[$key] = [$latitude, $longitude];
            $volume[$key] = [$volumePoint];
            $locations[$key] = [
                'name' => $dumpingPlace->name,
                'address' => $dumpingPlace->address,
                'longitude' => $longitude,
                'latitude' => $latitude
            ];
        }

        // Add final fixed point
        $end = $route->landFill;
        $points['end'] = [$end->latitude, $end->longitude];
        $locations['end'] = [
            'name' => $end->name,
            'address' => $end->address,
            'longitude' => $end->longitude,
            'latitude' => $end->latitude
        ];

        $fuelPricePerKm = $route->garbageTruck->fuel_price;
        $truckVolume = $route->garbageTruck->volume;

        $T0 = $request->query('t0');
        $T1 = $request->query('t1');
        $alpha = $request->query('alpha');
        $maxIterations = $request->query('iteration');

        $currentSolution = array_keys($points);

        // Ensure start and end points are fixed
        $start = array_shift($currentSolution);
        $end = array_pop($currentSolution);
        shuffle($currentSolution);
        array_unshift($currentSolution, 'start');
        array_push($currentSolution, 'end');

        // Generate initial route with volume constraints
        $currentSolution = $this->generateRouteWithVolumeConstraints($currentSolution, $points, $volume, $truckVolume);

        $totalDistance = 0;
        $currentCost = $this->calculateTotalCost($currentSolution, $points, $fuelPricePerKm, $totalDistance);

        $temperature = $T0;
        $iterationsData = [];

        $bestSolution = $currentSolution;
        $bestCost = $currentCost;
        $bestIteration = 0;
        $bestTemperature = $temperature;

        while ($temperature > $T1) {
            for ($i = 0; $i < $maxIterations; $i++) {
                $startTime = microtime(true); // Start time
                
                $neighborSolution = $this->getNeighbor($currentSolution);
                $neighborSolution = $this->generateRouteWithVolumeConstraints($neighborSolution, $points, $volume, $truckVolume);
                $neighborCost = $this->calculateTotalCost($neighborSolution, $points, $fuelPricePerKm, $neighborDistance);

                if ($this->acceptanceProbability($currentCost, $neighborCost, $temperature) > mt_rand() / mt_getrandmax()) {
                    $currentSolution = $neighborSolution;
                    $currentCost = $neighborCost;
                    $totalDistance = $neighborDistance;

                    if ($currentCost < $bestCost) {
                        $bestSolution = $currentSolution;
                        $bestCost = $currentCost;
                        $bestIteration = $i;
                        $bestTemperature = $temperature;
                    }
                }

                $endTime = microtime(true); // End time
                $iterationTime = $endTime - $startTime; // Iteration time in seconds
                $iterationTimeInMinutes = $iterationTime / 60; // Convert iteration time to minutes
                
                // Calculate truck time for the same distance
                $truckTimeHours = $totalDistance / $this->truckSpeed; // Time in hours
                $truckTimeMinutes = $truckTimeHours * 60; // Time in minutes

                $solutionDetails = array_map(function($point) use ($locations) {
                    return $locations[$point];
                }, $currentSolution);

                $iterationsData[] = [
                    'iteration' => $i,
                    'temperature' => $temperature,
                    'solution' => $solutionDetails,
                    'cost' => number_format($currentCost, 2),
                    'distance' => number_format($totalDistance, 2),
                    'iterationTime' => number_format($iterationTimeInMinutes, 6), // Added iteration time in minutes
                    'truckTime' => number_format($truckTimeMinutes, 2) // Added truck time in minutes
                ];
            }
            $temperature *= $alpha;
        }

        $totalTimeHours = $totalDistance / $this->truckSpeed; // waktu dalam jam
        $totalTimeMinutes = $totalTimeHours * 60;
        $minutes = floor($totalTimeMinutes);
        $seconds = floor(($totalTimeMinutes - $minutes) * 60);
        $formattedTime = sprintf('%d mins %d sec', $minutes, $seconds);

        // Extract detailed information for the best solution
        $bestSolutionDetails = array_map(function($point) use ($locations) {
            return $locations[$point];
        }, $bestSolution);

        $data = [
            'title' => 'Analysis',
            'subTitle' => $route->name,
            'route' => $route,
            't0' => $T0,
            't1' => $T1,
            'alpha' => $alpha,
            'iteration' => $maxIterations,
            'bestSolution' => $bestSolutionDetails,
            'bestCost' => number_format($bestCost, 2),
            'bestIteration' => $bestIteration,
            'bestTemperature' => $bestTemperature,
            'totalDistance' => number_format($totalDistance, 2),    
            'totalTime' => $formattedTime,
            'iterations' => $iterationsData,
        ];  
        // return response()->json($data);
        return view('pages.analyst', $data);
    }   
}
