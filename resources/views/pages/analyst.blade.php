@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
  .centered-cell {
    vertical-align: middle;
    text-align: center; /* Optional: To center text horizontally as well */
  }
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
                  <span class="fw-semibold fs-6 me-2">License Plate</span>                   
                  <span class="fs-7">{{ $route->garbageTruck->license_plate }}</span>                   
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
                  <span class="fw-semibold fs-6 me-2">Type</span>                   
                  <span class="fs-7">{{ $route->garbageTruck->type }}</span>                   
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
                      <th class="min-w-50px">Latitude</th>
                      <th class="min-w-50px">Longitude</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($route->location as $index => $item)
                      <tr>
                        <td>{{ $item->dumpingPlace->name }}</td>
                        <td>{{ $item->dumpingPlace->latitude }}</td>
                        <td>{{ $item->dumpingPlace->longitude }}</td>
                      </tr>
                    @endforeach
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
                                  {{ $index }} - 
                              @else
                                  {{ $index }}
                              @endif
                          @endforeach
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
                <th class="min-w-150px">Route</th>
                <th class="min-w-50px">Cost</th>
                <th class="min-w-50px">Distance</th>
                <th class="min-w-50px">TIme</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  @foreach ($bestSolution as $index)
                    @if (!$loop->last)
                        {{ $index }} - 
                    @else
                        {{ $index }}
                    @endif
                @endforeach
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
    "scrollX": false
  });
</script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  var map = L.map('map').setView([5.1843, 97.1451], 12);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  @foreach ($dumpingPlace as $item) 
      var marker = L.marker([{{ $item->dumpingPlace->latitude }}, {{ $item->dumpingPlace->longitude }}]).addTo(map);
      marker.bindPopup("<b>{{ $item->dumpingPlace->name }}</b><br>{{ $item->dumpingPlace->address }}")
  @endforeach
</script>
@endsection