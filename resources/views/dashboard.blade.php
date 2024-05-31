@extends('layouts.app')

@section('content')

<div class="row g-5 g-xl-8">
  <div class="col-xl-12 mb-8">
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
  </div>
</div>

@endsection

@section('script')
@endsection