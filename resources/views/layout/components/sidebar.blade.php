<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main" style="background-color: #ffffff!important; border: 1px solid #e8e2e2 !important;">
    <div class="sidenav-header h-auto">
        <i class="fa-solid fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex justify-content-center m-0 navbar-brand text-wrap p-1" href="#">
            <img src="{{ asset('assets/img/logos/medpres.png') }}" class="navbar-brand-img mh-100" alt="..."
                style="height: 80px">
        </a>
        <div class="h-auto">
            <h5 class="text-center font-weight-bolder">Medical Prescription</h5>
        </div>
    </div>
    <hr class="horizontal dark">
    {{-- <div class="card h-auto py-4 mb-4">
        <h5 class="text-center">Management License</h5>
    </div> --}}
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            {{-- <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}"">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fa-solid fa-lg fa-search ps-2 pe-2 text-center text-dark"
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dokumen</span>
                </a>
            </li> --}}
            <li class="nav-item mt-1 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu Utama</h6>
            </li>
            <li class="nav-item">
                <a id="menuDashboard" class="nav-link {{ Request::routeIs('dashboard.index') ? 'active' : '' }}"
                    href="{{ route('dashboard.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fa-xl fa-solid fa-store ps-2 pe-2 text-center text-dark"
                            aria-hidden="true">
                        </i>
                    </div>
                    <span class="nav-link-text ms-1">Dasbor</span>
                </a>
            </li>

            <li class="nav-item mt-3 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manajemen</h6>
            </li>
            <li class="nav-item">
                <a id="menuDokter" class="nav-link {{ Request::routeIs('management.admin.index') ? 'active' : '' }}"
                    href="{{ route('management.admin.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fa-solid fa-lg fa-user-lock ps-2 pe-2 text-center text-dark"
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Admin</span>
                </a>
            </li>
            <li class="nav-item">
                <a id="menuDokter" class="nav-link {{ Request::routeIs('management.doctor.index') ? 'active' : '' }}"
                    href="{{ route('management.doctor.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fa-solid fa-lg fa-user-doctor-hair ps-2 pe-2 text-center text-dark"
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dokter</span>
                </a>
            </li>
            <li class="nav-item">
                <a id="#" class="nav-link {{ Request::routeIs('management.pharmacist.index') ? 'active' : '' }}" href="{{ route('management.pharmacist.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fa-solid fa-lg fa-mortar-pestle ps-2 pe-2 text-center text-dark"
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Apoteker</span>
                </a>
            </li>
            <li class="nav-item">
                <a id="menuDepartment" class="nav-link {{ Request::routeIs('dashboard.index') ? 'active' : '' }}"
                    href="#">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fa-solid fa-lg fa-hospital-user ps-2 pe-2 text-center text-dark"
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pasien</span>
                </a>
            </li>
            {{-- @endif --}}
        </ul>
    </div>
</aside>
