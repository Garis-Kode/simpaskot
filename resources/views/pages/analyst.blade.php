@extends('layouts.app')

@section('style')
<style>
  #map { height: 400px; }
</style>

@endsection

@section('content')

<div class="row g-5 g-xl-8">
  <div class="col-xl-12 mb-2">
    <div class="card card-flush">
      <div class="card-body">
        <div class="row">
          <div class="col-xl-6">
            <span class="card-label fw-bold fs-4">Value</span>
            <div class="mt-5">
                <div class="d-flex flex-stack">
                  <span class="fw-semibold fs-6 me-2">T0</span>                   
                  <span class="fs-7">{{ $t0 }}</span>                   
                </div>
              <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                  <span class="fw-semibold fs-6 me-2">T1</span>                   
                  <span class="fs-7">{{ $t1 }}</span>                   
                </div>
              <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                  <span class="fw-semibold fs-6 me-2">&alpha;</span>                   
                  <span class="fs-7">{{ $alpha }}</span>                   
                </div>
              <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                  <span class="fw-semibold fs-6 me-2">Max Iteration</span>                   
                  <span class="fs-7">{{ $iteration }}</span>                   
                </div>
            </div>
          </div>
          <div class="col-xl-6">
            <span class="card-label fw-bold fs-4">Truck</span>
            <div class="mt-5">
                <div class="d-flex flex-stack">
                  <span class="fw-semibold fs-6 me-2">License Plate - type</span>                   
                  <span class="fs-7">{{ $route->garbageTruck->license_plate }} - {{ $route->garbageTruck->type }}</span>                   
                </div>
              <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                  <span class="fw-semibold fs-6 me-2">Driver Name</span>                   
                  <span class="fs-7">{{ $route->garbageTruck->driver_name }}</span>                   
                </div>
              <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                  <span class="fw-semibold fs-6 me-2">Fuel Price</span>                   
                  <span class="fs-7">Rp.{{ number_format($route->garbageTruck->fuel_price) }}/km</span>                   
                </div>
              <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                  <span class="fw-semibold fs-6 me-2">Volume</span>                   
                  <span class="fs-7">{{ $route->garbageTruck->volume }}m<sup>3</sup> </span>                   
                </div>
            </div>
          </div>
          <div class="col-xl-12 mt-10">
            <span class="card-label fw-bold fs-4">Location</span>
            <div class="mt-5">
              <div class="table-responsive">
                <table class="table table-bordered fs-7">
                  <thead>
                    <tr class="text-start fw-bold fs-7 gs-0">
                      <th class="min-w-50px">Name</th>
                      <th class="min-w-50px">Address</th>
                      <th class="min-w-50px">Latitude</th>
                      <th class="min-w-50px">Longitude</th>
                      <th class="min-w-50px">Volume</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{$route->pool->name}}</td>
                      <td>{{$route->pool->address}}</td>
                      <td>{{$route->pool->longitude}}</td>
                      <td>{{$route->pool->latitude}}</td>
                      <td>-</td>
                    </tr>
                    @foreach ($route->location as $index => $item)
                      <tr>
                        <td>{{ $item->dumpingPlace->name }}</td>
                        <td>{{ $item->dumpingPlace->address }}</td>
                        <td>{{ $item->dumpingPlace->latitude }}</td>
                        <td>{{ $item->dumpingPlace->longitude }}</td>
                        <td>{{ $item->dumpingPlace->volume }}m<sup>3</sup></td>
                      </tr>
                    @endforeach
                    <tr>
                      <td>{{$route->landfill->name}}</td>
                      <td>{{$route->landfill->address}}</td>
                      <td>{{$route->landfill->longitude}}</td>
                      <td>{{$route->landfill->latitude}}</td>
                      <td>-</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-12 mb-2">
    <div class="card card-flush">
      <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-4 mb-1">Route Iteration</span>
          </h3>
        </div>
      </div>
      <div class="card-body pt-5">                 
        <div class="table-responsive">
          <table id="kt_datatable_horizontal_scroll" class="table table-bordered fs-7">
            <thead>
              <tr class="text-start fw-bold fs-7 gs-0">
                <th class="min-w-50px">Iteration</th>
                <th class="min-w-50px">Temperature</th>
                <th class="min-w-150px">Route</th>
                <th class="min-w-50px">Cost (Rp.)</th>
                <th class="min-w-50px">Distance (km)</th>
                <th class="min-w-50px">Time (Minute)</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($iterations as $item)
                  <tr>
                      <td>{{ $item['iteration'] }}</td>
                      <td>{{ $item['temperature'] }}</td>
                      <td>
                          @foreach ($item['solution'] as $index)
                              @if (!$loop->last)
                                  {{ $index['name'] }} - 
                              @else
                                  {{ $index['name'] }}
                              @endif
                          @endforeach
                          <br>
                          ( @foreach ($item['solution'] as $index)
                          @if (!$loop->last)
                              {{ $index['address'] }} - 
                          @else
                              {{ $index['address'] }}
                          @endif
                      @endforeach )
                      </td>
                      <td>{{ $item['cost'] }}</td>
                      <td>{{ $item['distance'] }}</td>
                      <td>{{ $item['truckTime'] }}</td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-12 mb-2">
    <div class="card card-flush">
      <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-4 mb-1">Best Solution</span>
          </h3>
        </div>
      </div>
      <div class="card-body pt-5">                 
        <div class="table-responsive">
          <table class="table table-bordered fs-7">
            <thead>
              <tr class="text-start fw-bold fs-7 gs-0">
                <th class="min-w-50px">Iteration</th>
                <th class="min-w-50px">Temperature</th>
                <th class="min-w-150px">Route</th>
                <th class="min-w-50px">Cost</th>
                <th class="min-w-50px">Distance</th>
                <th class="min-w-50px">TIme</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $bestIteration }}</td>
                <td>{{ $bestTemperature }}</td>
                <td>
                  @foreach ($bestSolution as $index)
                    @if (!$loop->last)
                        {{ $index['name'] }} - 
                    @else
                        {{ $index['name'] }}
                    @endif
                @endforeach
                <br>
                (@foreach ($bestSolution as $index)
                    @if (!$loop->last)
                        {{ $index['address'] }} - 
                    @else
                        {{ $index['address'] }}
                    @endif
                @endforeach)
                </td>
                <td>Rp. {{ $bestCost }}</td>
                <td>{{ $totalDistance }} km</td>
                <td>{{ $totalTime }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div id="map"></div>
      </div>
    </div>
  </div>

</div>
{{-- {{dd($dumpingPlace)}} --}}
@endsection

@section('script')
<script>
  $("#kt_datatable_horizontal_scroll").DataTable({
    "scrollX": false,
    pageLength : 25,
  });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places"></script>
<script>
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 5.1843, lng: 97.1451},
        zoom: 12
    });

    var directionsService = new google.maps.DirectionsService();
    var directionsRenderer = new google.maps.DirectionsRenderer();

    directionsRenderer.setMap(map);

    var waypts = [
      @foreach ($bestSolution as $index => $solution)
          @if ($index != 0 && $index != count($bestSolution) - 1)
              {
                  location: {lat: {{$solution['latitude']}}, lng: {{$solution['longitude']}}},
                  stopover: true
              },
          @endif
      @endforeach
    ];

    var origin = {lat: {{$route->pool->latitude}}, lng: {{$route->pool->longitude}}}; // Titik awal (Jakarta)
    var destination = {lat: {{$route->landfill->latitude}}, lng: {{$route->landfill->longitude}}}; // Titik akhir (Denpasar)

    directionsService.route({
        origin: origin,
        destination: destination,
        waypoints: waypts,
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.DRIVING
    }, function(response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsRenderer.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}

google.maps.event.addDomListener(window, 'load', initMap);

</script>
@endsection