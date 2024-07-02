@extends('layouts.app')

@section('content')

  <div class="row g-5 g-xl-8">
    <div class="col-xl-12 mb-8">
      <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
          <div class="card-title">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">Truck</span>
              <span class="text-muted fw-semibold fs-7">Garbage Truck</span>              
            </h3>
          </div>
          <div class="card-toolbar">
            <button data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary d-flex align-items-center"><i class="ki-duotone ki-plus fs-2"></i>
              Add
            </button>
            <div class="modal fade" tabindex="-1" id="add">
              <div class="modal-dialog">
                  <form method="POST" action="{{ route('garbage-truck.store') }}" class="modal-content">
                    @csrf
                      <div class="modal-header">
                          <h3 class="modal-title">Add new truck</h3>
                          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                              <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                          </div>
                      </div>
                      <div class="modal-body">
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">Type</label>
                          <select class="form-select form-select-solid  @error('type') is-invalid @enderror" name="type" aria-label="Select example">
                              <option value="">Choose type</option>
                              <option value="Dump Truck (Besar)" @if (old('type') == 'Dump Truck (Besar)') selected @endif>Dump Truck (Besar)</option>
                              <option value="Dump Truck (Kecil)" @if (old('type') == 'Dump Truck (Kecil)') selected @endif>Dump Truck (Kecil)</option>
                          </select>
                          @error('type')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">License Plate</label>
                          <input type="text" name="plate" class="form-control form-control-solid @error('plate') is-invalid @enderror"  value="{{ old('plate') }}" placeholder="License Plate" required/>
                          @error('plate')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">Driver Name</label>
                          <input type="text" name="driver" class="form-control form-control-solid @error('driver') is-invalid @enderror"  value="{{ old('driver') }}" placeholder="Driver Name" required/>
                          @error('driver')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="form-label">Fuel Price</label>
                          <div class="input-group">
                            <span class="input-group-text border-0" id="basic-addon2">Rp.</span>
                            <input type="number" step="any" name="price" class="form-control form-control-solid @error('price') is-invalid @enderror"  value="{{ old('price') }}" placeholder="0"/>
                            <span class="input-group-text border-0" id="basic-addon2">/km</span>
                          </div>
                          @error('price')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="form-label">Volume</label>
                          <div class="input-group">
                            <input type="number" step="any" name="volume" class="form-control form-control-solid @error('volume') is-invalid @enderror"  value="{{ old('volume') }}" placeholder="0"/>
                            <span class="input-group-text border-0" id="basic-addon2">m<sup>3</sup> </span>
                          </div>
                          @error('volume')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                  </form>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="table-responsive">
            <table id="kt_datatable_horizontal_scroll" class="table table-row-dashed gy-5 fs-6">
              <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                  <th class="min-w-150px">License Plate</th>
                  <th class="min-w-150px">Driver Name</th>
                  <th class="min-w-150px">Fuel Price</th>
                  <th class="min-w-150px">Volume</th>
                  <th class="min-w-150px">Type</th>
                  <th class="min-w-50px text-end">action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>{{ $item->license_plate }}</td>
                    <td>{{ $item->driver_name }}</td>
                    <td>Rp.{{ number_format($item->fuel_price) }}/km</td>
                    <td>{{ $item->volume }} m<sup>3</sup> </td>
                    <td>{{ $item->type }}</td>
                    <td class="text-end">
                      <a href="#" class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        Actions
                        <span class="svg-icon fs-5 m-0 ps-2">
                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <polygon points="0 0 24 0 24 24 0 24"></polygon>
                              <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                            </g>
                          </svg>
                        </span>
                      </a>
                      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                          <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{$item->id}}" class="menu-link px-3">Edit</a>
                        </div>
                        <div class="menu-item px-3">
                          <a id="{{ route('garbage-truck.destroy', $item->id) }}" class="menu-link px-3 btn-del">Delete</a>
                        </div>
                      </div>
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

  @foreach ($data as $item)     
  <div class="modal fade" tabindex="-1" id="edit{{$item->id}}">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('garbage-truck.update', $item->id) }}" class="modal-content">
          @csrf
            <div class="modal-header">
                <h3 class="modal-title">Edit truck</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="required form-label">Type</label>
                <select class="form-select form-select-solid  @error('type') is-invalid @enderror" name="type" aria-label="Select example">
                    <option value="">Choose type</option>
                    <option value="Dump Truck (Besar)" @if ($item->type == 'Dump Truck (Besar)') selected @endif>Dump Truck (Besar)</option>
                    <option value="Dump Truck (Kecil)" @if ($item->type == 'Dump Truck (Kecil)') selected @endif>Dump Truck (Kecil)</option>
                </select>
                @error('type')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="required form-label">License Plate</label>
                <input type="text" name="plate" class="form-control form-control-solid @error('plate') is-invalid @enderror"  value="{{ old('plate') ?? $item->license_plate }}" placeholder="License Plate" required/>
                @error('plate')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="required form-label">Driver Name</label>
                <input type="text" name="driver" class="form-control form-control-solid @error('driver') is-invalid @enderror"  value="{{ old('driver') ?? $item->driver_name }}" placeholder="Driver Name" required/>
                @error('driver')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="form-label">Fuel Price</label>
                <div class="input-group">
                  <span class="input-group-text border-0" id="basic-addon2">Rp.</span>
                  <input type="number" step="any" name="price" class="form-control form-control-solid @error('price') is-invalid @enderror"  value="{{ old('price') ?? $item->fuel_price }}" placeholder="0"/>
                  <span class="input-group-text border-0" id="basic-addon2">/km</span>
                </div>
                @error('price')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="form-label">Volume</label>
                <div class="input-group">
                  <input type="number" step="any" name="volume" class="form-control form-control-solid @error('volume') is-invalid @enderror"  value="{{ old('volume') ?? $item->volume }}" placeholder="0"/>
                  <span class="input-group-text border-0" id="basic-addon2">m<sup>3</sup> </span>
                </div>
                @error('volume')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
  </div>
  @endforeach

@endsection

@section('script')
<script>
  $("#kt_datatable_horizontal_scroll").DataTable({
    "scrollX": false
  });
</script>
@endsection