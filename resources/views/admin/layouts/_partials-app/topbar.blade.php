<div id="kt_header" style="" class="header align-items-stretch">
  <div class="header-brand">
    <a href="#">
      <img alt="Logo" src="{{ asset('front-assets/img/logo_sipar.png') }}" class="h-35px h-lg-50px " />
    </a>
    <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-minimize" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
      <i class="ki-duotone ki-entrance-right fs-1 me-n1 minimize-default">
        <span class="path2"></span>
      </i>
      <i class="ki-duotone ki-entrance-left fs-1 minimize-active">
        <span class="path1"></span>
      </i>
    </div>
    <div class="d-flex align-items-center d-lg-none me-n2" title="Show aside menu">
      <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
        <i class="ki-duotone ki-abstract-14 fs-1">
          <span class="path1"></span>
          <span class="path2"></span>
        </i>
      </div>
    </div>
  </div>
  
  <div class="toolbar d-flex align-items-stretch">
    <div class="container-xxl py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
      <div class="page-title d-flex justify-content-center flex-column me-5">
        <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">{{ $title }}</h1>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
          <li class="breadcrumb-item text-muted">
            <i class="ki-duotone ki-home text-gray-400"></i>
          </li>
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-muted">
            <span class="text-muted">{{ $title }}</span>
          </li>
          @if ($subTitle)
          <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
          </li>
          <li class="breadcrumb-item text-dark">{{ $subTitle }}</li>
          @endif
        </ul>
      </div>

      <div class="d-flex justify-content-between  pt-3 pt-lg-0">

        <div class="d-flex align-items-center">
          {{-- <div class="d-flex align-items-center">
            <div class="d-flex">
              <div class="d-flex align-items-center">
                <a href="#" class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom">
                  <i class="ki-duotone ki-notification-bing fs-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                  </i>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
                  <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{ asset('admin-assets/media/misc/menu-header-bg.jpg') }}')">
                    <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifikasi <br>
                    <span class="fs-8 opacity-75">2 pemberitahuan</span></h3>
                  </div>
                  <div class="scroll-y mh-325px my-5 px-8">
                    <div class="d-flex flex-stack py-4">
                      <div class="d-flex align-items-center">
                        <div class="symbol symbol-35px me-4">
                          <span class="symbol-label bg-light-info">
                            <i class="ki-outline ki-picture fs-2 text-info"></i>
                          </span>
                        </div>
                        <div class="mb-0 me-2">
                          <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Banner Assets</a>
                          <div class="text-gray-400 fs-7">Collection of banner images</div>
                        </div>
                      </div>
                      <span class="badge badge-light fs-8">21 Jan</span>
                    </div>
                    <div class="d-flex flex-stack py-4">
                      <div class="d-flex align-items-center">
                        <div class="symbol symbol-35px me-4">
                          <span class="symbol-label bg-light-warning">
                            <i class="ki-outline ki-color-swatch fs-2 text-warning"></i>
                          </span>
                        </div>
                        <div class="mb-0 me-2">
                          <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Icon Assets</a>
                          <div class="text-gray-400 fs-7">Collection of SVG icons</div>
                        </div>
                      </div>
                      <span class="badge badge-light fs-8">20 March</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> --}}

          <div class="d-flex align-items-center">
            <a href="#" class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
              <i class="ki-duotone ki-night-day theme-light-show fs-1">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
                <span class="path5"></span>
                <span class="path6"></span>
                <span class="path7"></span>
                <span class="path8"></span>
                <span class="path9"></span>
                <span class="path10"></span>
              </i>
              <i class="ki-duotone ki-moon theme-dark-show fs-1">
                <span class="path1"></span>
                <span class="path2"></span>
              </i>
            </a>
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
              <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                  <span class="menu-icon" data-kt-element="icon">
                    <i class="ki-duotone ki-night-day fs-2">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                      <span class="path4"></span>
                      <span class="path5"></span>
                      <span class="path6"></span>
                      <span class="path7"></span>
                      <span class="path8"></span>
                      <span class="path9"></span>
                      <span class="path10"></span>
                    </i>
                  </span>
                  <span class="menu-title">Light</span>
                </a>
              </div>
              <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                  <span class="menu-icon" data-kt-element="icon">
                    <i class="ki-duotone ki-moon fs-2">
                      <span class="path1"></span>
                      <span class="path2"></span>
                    </i>
                  </span>
                  <span class="menu-title">Dark</span>
                </a>
              </div>
              <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                  <span class="menu-icon" data-kt-element="icon">
                    <i class="ki-duotone ki-screen fs-2">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                      <span class="path4"></span>
                    </i>
                  </span>
                  <span class="menu-title">System</span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex align-items-center">
          <div class="d-flex align-items-center ps-5">
            <div class="d-flex">
              <div class="d-flex align-items-center">
                <a href="#" class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
                  <img src="https://ui-avatars.com/api/?background=E79024&color=fff&name=fajar" class="rounded-3 h-35px w-35px" alt="user">
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                  <div class="menu-item px-5">
                    <a href="#" class="menu-link px-5">
                      <i class="ki-duotone ki-user fs-2 me-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                      </i>
                      Profil
                    </a>
                  </div>
                  <div class="menu-item px-5">
                    <a href="#" class="menu-link px-5">
                      <i class="ki-duotone ki-entrance-right fs-2 me-3 minimize-default">
                        <span class="path1"></span>
                        <span class="path2"></span>
                      </i>
                      Keluar
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>