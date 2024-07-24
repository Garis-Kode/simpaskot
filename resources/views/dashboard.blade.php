@extends('layouts.app')

@section('style')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
      #map { height: 400px; }
  </style>
@endsection

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
            <span class="card-label fw-bold fs-3 mb-1">Schedule</span>
            <span class="text-muted fw-semibold fs-7">Route Schedule</span>              
          </h3>
        </div>
      </div>
      <div class="card-body pt-0">
        <div class="table-responsive">
          <table class="table table-row-dashed gy-5 fs-6">
            <thead>
              <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-100px">Route Name</th>
                <th class="min-w-150px">Truck</th>
                <th class="min-w-200px">Location</th>
                <th class="min-w-50px text-end">action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($route as $item)
                <tr>
                  <td>{{ $item->name }}</td>
                  <td>
                    @foreach ($item->trucks as $location)
                      {{ $location->garbageTruck->license_plate }},
                    @endforeach
                  </td>
                  <td>
                    {{ $item->pool->name }},
                    @foreach ($item->location as $location)
                      {{ $location->dumpingPlace->name }},
                    @endforeach
                    {{ $item->landfill->name }}
                  </td>
                  <td class="text-end">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#analyst{{ $item->id }}" class="btn btn-sm btn-danger btn-flex btn-center" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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

@foreach ($route as $item)
  <div class="modal fade" tabindex="-1" id="analyst{{ $item->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Analisis {{$item->name }}</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <form action="{{ route('analyst', $item->id) }}" method="GET">
              <div class="modal-body">
                <div class="row">
                  <div class="col mb-5">
                    <label for="exampleFormControlInput1" class="required form-label">T0</label>
                    <input type="number" step="any" name="t0" class="form-control form-control-solid @error('t0') is-invalid @enderror"  value="5000" placeholder="0" required/>
                    @error('t0')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="col mb-5">
                    <label for="exampleFormControlInput1" class="required form-label">T1</label>
                    <input type="number" step="any" name="t1" class="form-control form-control-solid @error('t1') is-invalid @enderror"  value="1" placeholder="0" required/>
                    @error('t1')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col mb-5">
                    <label for="exampleFormControlInput1" class="required form-label">Alpha</label>
                    <input type="number" step="any" name="alpha" class="form-control form-control-solid @error('alpha') is-invalid @enderror"  value="0.55" placeholder="0" required/>
                    @error('alpha')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="col mb-5">
                    <label for="exampleFormControlInput1" class="required form-label">Max Iteration</label>
                    <input type="number" step="any" name="iteration" class="form-control form-control-solid @error('iteration') is-invalid @enderror"  value="1000" placeholder="0" required/>
                    @error('iteration')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>

        </div>
    </div>
  </div>
@endforeach

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