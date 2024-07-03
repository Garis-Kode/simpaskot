@extends('layouts.app')

@section('content')

  <div class="row g-5 g-xl-8">
    <div class="col-xl-12 mb-8">
      <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
          <div class="card-title">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bold fs-3 mb-1">Route</span>
              <span class="text-muted fw-semibold fs-7">Route Location</span>              
            </h3>
          </div>
          <div class="card-toolbar">
            <button data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary d-flex align-items-center"><i class="ki-duotone ki-plus fs-2"></i>
              Add
            </button>
            <div class="modal fade" tabindex="-1" id="add">
              <div class="modal-dialog">
                  <form method="POST" action="{{ route('route.store') }}" class="modal-content">
                    @csrf
                      <div class="modal-header">
                          <h3 class="modal-title">Add new route</h3>
                          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                              <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                          </div>
                      </div>
                      <div class="modal-body">
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">Route Name</label>
                          <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror"  value="{{ old('name') }}" placeholder="Route Name" required/>
                          @error('name')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">Garbage Truck</label>
                          <select class="form-select form-select-solid  @error('truck') is-invalid @enderror" name="truck" aria-label="Select example" required>
                              <option value="">Choose Truck</option>
                              @foreach ($garbageTruck as $item)
                                <option option value="{{ $item->id }}" @if (old('truck') == $item->id) selected @endif>{{ $item->driver_name }} ({{ $item->license_plate }})</option>
                              @endforeach
                          </select>
                          @error('truck')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">Start Route</label>
                          <select class="form-select form-select-solid  @error('pool') is-invalid @enderror" name="pool" aria-label="Select example" required>
                              <option value="">Choose Pool</option>
                              @foreach ($pool as $item)
                                <option option value="{{ $item->id }}" @if (old('pool') == $item->id) selected @endif>{{ $item->name }} ({{ $item->address }})</option>
                              @endforeach
                          </select>
                          @error('pool')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">Location</label>
                          <select class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" name="location[]" required>
                              @foreach ($dumpingPlace as $item)
                                  <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->address }})</option>
                              @endforeach
                          </select>
                          @error('location')
                              <div class="invalid-feedback">
                                  {{ $message }}
                              </div>
                          @enderror
                        </div>
                        <div class="mb-5">
                          <label for="exampleFormControlInput1" class="required form-label">End Route</label>
                          <select class="form-select form-select-solid  @error('landfill') is-invalid @enderror" name="landfill" aria-label="Select example" required>
                              <option value="">Choose Landfill</option>
                              @foreach ($landfill as $item)
                                <option option value="{{ $item->id }}" @if (old('landfill') == $item->id) selected @endif>{{ $item->name }} ({{ $item->address }})</option>
                              @endforeach
                          </select>
                          @error('landfill')
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
                  <th class="min-w-100px">Name</th>
                  <th class="min-w-150px">Truck</th>
                  <th class="min-w-50px"> Start Route</th>
                  <th class="min-w-200px">Location</th>
                  <th class="min-w-50px">End Route</th>
                  <th class="min-w-50px text-end">action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                  <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->garbageTruck->license_plate }} - {{ $item->garbageTruck->type }}</td>
                    <td>{{ $item->pool->name }} <br>({{ $item->pool->address }}) </td>
                    <td>
                      @foreach ($item->location as $location)
                        {{ $location->dumpingPlace->name }},
                      @endforeach
                      <br>
                      (@foreach ($item->location as $location)
                        {{ $location->dumpingPlace->address }},
                      @endforeach)
                    </td>
                    <td>{{ $item->landfill->name }}<br>({{ $item->landfill->address }})</td>
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
                          <a id="{{ route('route.destroy', $item->id) }}" class="menu-link px-3 btn-del">Delete</a>
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
        <form method="POST" action="{{ route('route.update', $item->id) }}" class="modal-content">
          @csrf
            <div class="modal-header">
                <h3 class="modal-title">Edit Route</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="required form-label">Route Name</label>
                <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror"  value="{{ old('name') ?? $item->name }}" placeholder="Route Name" required/>
                @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="required form-label">Garbage Truck</label>
                <select class="form-select form-select-solid  @error('truck') is-invalid @enderror" name="truck" aria-label="Select example">
                  <option option value="{{ $item->garbageTruck->id }}" @if ( old('truck') == $item->garbageTruck->id) selected @endif>{{ $item->garbageTruck->driver_name }} ({{ $item->garbageTruck->license_plate }})</option>
                  @foreach ($garbageTruck as $truck)
                    <option option value="{{ $truck->id }}" @if ( old('truck') == $truck->id) selected @endif>{{ $truck->driver_name }} ({{ $truck->license_plate }})</option>
                  @endforeach
                </select>
                @error('truck')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="required form-label">Start Route</label>
                <select class="form-select form-select-solid  @error('pool') is-invalid @enderror" name="pool" aria-label="Select example">
                  <option value="">Choose Pool</option>
                  @foreach ($pool as $index)
                    <option option value="{{ $index->id }}" @if ( old('pool') ?? $item->pool_id == $index->id) selected @endif>{{ $index->name }} ({{ $index->address }})</option>
                  @endforeach
                </select>
                @error('pool')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="required form-label">Location</label>
                <select class="form-select form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" name="location[]" required>
                    @foreach ($item->location as $place)
                        <option value="{{ $place->dumpingPlace->id }}" selected>{{ $place->dumpingPlace->name }} ({{ $place->dumpingPlace->address }})</option>
                    @endforeach
                    @foreach ($dumpingPlace as $place)
                        <option value="{{ $place->id }}">{{ $place->name }} ({{ $place->address }})</option>
                    @endforeach
                </select>
                @error('location')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div>
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="required form-label">Start Route</label>
                <select class="form-select form-select-solid  @error('landfill') is-invalid @enderror" name="landfill" aria-label="Select example">
                  <option value="">Choose Landfill</option>
                  @foreach ($landfill as $index)
                    <option option value="{{ $index->id }}" @if ( old('landfill') ?? $item->landfill_id == $index->id) selected @endif>{{ $index->name }} ({{ $index->address }})</option>
                  @endforeach
                </select>
                @error('landfill')
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