@extends('layouts.app')

@section('style')

@endsection
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map { height: 400px; }
</style>
@section('content')

<div class="row g-5 g-xl-8">
  {{-- <div class="col-xl-12 mb-2">
    <div class="card border-transparent bgi-no-repeat bgi-position-x-end bgi-size-cover " style="background-size: auto 100%; background-image: url(https://preview.keenthemes.com/metronic8/demo4/assets/media/misc/taieri.svg)">
      <div class="card-body d-flex ps-xl-15">          
          <div class="m-0">
              <div class="position-relative fs-2x z-index-2 fw-bold my-7">
                  <span class="me-2">
                      Halo, <br>
                      <span class="position-relative d-inline-block text-danger">
                          <span class="text-danger opacity-75-hover">{{ Auth::user()->name }}</span>    
                      </span>                     
                  </span>                                             
              </div>
          </div>
      </div>
    </div>
  </div> --}}

  <div class="col-xl-12 mb-2">
    <div class="card">
      <div class="card-body p-1">          
        <div id="map"></div>
      </div>
    </div>
  </div>

  <div class="col-xl-12 mb-8">
    <div class="card card-flush">
      <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <div class="card-title">
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">Route</span>
            <span class="text-muted fw-semibold fs-7">Route Location</span>              
          </h3>
        </div>
      </div>
      <div class="card-body pt-0">
        <div class="table-responsive">
          <table class="table table-row-dashed gy-5 fs-6">
            <thead>
              <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px">Name</th>
                <th class="min-w-150px">Truck</th>
                <th class="min-w-200px">Location</th>
                <th class="min-w-50px text-end">action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($route as $item)
                <tr>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->garbageTruck->license_plate }}</td>
                  <td>
                    @foreach ($item->location as $location)
                      {{ $location->dumpingPlace->name }},
                    @endforeach
                  </td>
                  <td class="text-end">
                    <a href="#" class="btn btn-sm btn-danger btn-flex btn-center" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                      Analysis
                      <span class="svg-icon fs-5 m-0 ps-2">
                        <i class="ki-outline ki-graph-up text-white"></i>
                      </span>
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([5.1843, 97.1451], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    @foreach ($dumpingPlace as $item) 
        var marker = L.marker([{{ $item->latitude }}, {{ $item->longitude }}]).addTo(map);
        marker.bindPopup("<b>{{ $item->name }}</b><br>{{ $item->address }}").openPopup();
    @endforeach
</script>
@endsection