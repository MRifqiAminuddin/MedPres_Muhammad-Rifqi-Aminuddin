<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main" style="background-color: #ffffff!important;">
    <div class="sidenav-header h-auto">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex justify-content-center m-0 navbar-brand text-wrap p-1"
            href="{{ route('dashboard.index') }}">
            <img src="{{ asset('assets/img/logo_jai_yazaki.png') }}" class="navbar-brand-img mh-100" alt="...">
        </a>
        <div class="h-auto">
            <h5 class="text-center font-weight-bolder">License Management</h5>
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
                            class="fas fa-lg fa-search ps-2 pe-2 text-center text-dark"
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dokumen</span>
                </a>
            </li> --}}
            <li class="nav-item mt-3 mb-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Main Menu</h6>
            </li>
            <li class="nav-item">
                <a id="menuDashboard" class="nav-link {{ Request::routeIs('dashboard.index') ? 'active' : '' }}"
                    href="{{ route('dashboard.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-store ps-2 pe-2 text-center text-dark"
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            @if (auth()->user()->hasPermission('Read License') || auth()->user()->hasPermission('Change License'))
                <li class="nav-item">
                    <a id="menuLicense"
                        class="nav-link {{ Request::routeIs('license.index') ? 'active' : '' }} {{ Request::routeIs('license.detail') ? 'active' : '' }}"
                        href="{{ route('license.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="fas fa-lg fa-search ps-2 pe-2 text-center text-dark"
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">License</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasPermission('Read Permission') || auth()->user()->hasPermission('Change Permission'))
                <li class="nav-item">
                    <a id="{{ route('permission.index') }}"
                        class="nav-link {{ Request::routeIs('permission.index') ? 'active' : '' }}"
                        href="{{ route('permission.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                                class="fas fa-lg fa-solid fa-key ps-2 pe-2 text-center text-dark"
                                aria-hidden="true"></i>

                        </div>
                        <span class="nav-link-text ms-1">Permission</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a id="{{ route('task.index') }}"
                    class="nav-link {{ Request::routeIs('task.index') ? 'active' : '' }}"
                    href="{{ route('task.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-solid fa-list-check ps-2 pe-2 text-center text-dark"
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Task</span>
                </a>
            </li>

            <li class="nav-item">
                <a id="{{ route('mail.index') }}"
                    class="nav-link {{ Request::routeIs('mail.index') ? 'active' : '' }}"
                    href="{{ route('mail.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-solid fa-envelope ps-2 pe-2 text-center text-dark"
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Mail</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link {{ Request::is('licenses/upload') ? 'active' : '' }}" href="{{ route('licenses.upload') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-upload ps-2 pe-2 text-center text-dark {{ Request::is('licenses/upload') ? 'text-white' : 'text-dark' }}"
                            aria-hidden="true"></i>
                    </div>
                <span class="nav-link-text ms-1">Upload License</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('profile') }}">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-upload ps-2 pe-2 text-center text-dark {{ Request::is('profile') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li> --}}
            @if (auth()->user()->hasPermission('Read Data Master') || auth()->user()->hasPermission('Change Data Master'))
                <li class="nav-item mt-3 mb-2">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Management</h6>
                </li>
                <li class="nav-item">
                    <a id="menuRole" class="nav-link {{ Request::routeIs('management.role.index') ? 'active' : '' }}"
                        href="{{ route('management.role.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center text-dark"
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Role</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a id="{{ route('management.user.index') }}"
                        class="nav-link {{ Request::routeIs('management.user.index') ? 'active' : '' }}"
                        href="{{ route('management.user.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center text-dark"
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a id="menuDepartment"
                        class="nav-link {{ Request::routeIs('management.department.index') ? 'active' : '' }}"
                        href="{{ route('management.department.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center text-dark"
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Department</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a id="menuField" class="nav-link {{ Request::routeIs('management.field.index') ? 'active' : '' }}"
                        href="{{ route('management.field.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center text-dark"
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Field</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a id="menuCategory"
                        class="nav-link {{ Request::routeIs('management.category.index') ? 'active' : '' }}"
                        href="{{ route('management.category.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center text-dark"
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Category</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a id="menuDocumentType"
                        class="nav-link {{ Request::routeIs('management.document.type.index') ? 'active' : '' }}"
                        href="{{ route('management.document.type.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center text-dark"
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Document Type</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a id="menuOccurenceType"
                        class="nav-link {{ Request::routeIs('management.occurence.type.index') ? 'active' : '' }}"
                        href="{{ route('management.occurence.type.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center text-dark"
                                aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Occurence Type</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
