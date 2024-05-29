@extends('admin.layouts.app')

@section('content')

<div class="row g-5 g-xl-8">
  <div class="col-xl-12 mb-8">
    <div class="card border-transparent bgi-no-repeat bgi-position-x-end bgi-size-cover " data-bs-theme="light" style="background-size: auto 100%; background-image: url({{ asset('admin-assets/media/illustrations/bg.png') }})">
      <div class="card-body d-flex ps-xl-15">          
          <div class="m-0">
              <div class="position-relative fs-2x z-index-2 fw-bold my-7">
                  <span class="me-2">
                      Halo, <br>
                      <span class="position-relative d-inline-block text-danger">
                          <span class="text-danger opacity-75-hover">Fajar</span>    
                      </span>                     
                  </span>                                             
              </div>
          </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

@endsection