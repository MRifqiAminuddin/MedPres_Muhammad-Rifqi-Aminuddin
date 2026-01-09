@extends('layouts.app')

@section('auth')

    <div id="preloader" style="display: none;">
        <div id="user-table_processing" class="dt-processing" role="status">
            <div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    @if (\Request::is('static-sign-up'))
        @include('layouts.navbars.guest.nav')
        @yield('content')
        @include('layouts.footers.guest.footer')
    @elseif(\Request::is('static-sign-in'))
        @include('layouts.navbars.guest.nav')
        @yield('content')
        {{-- @include('layouts.footers.guest.footer') --}}
    @else
        @if (\Request::is('rtl'))
            @include('layouts.navbars.auth.sidebar-rtl')
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden">
                @include('layouts.navbars.auth.nav-rtl')
                <div class="container-fluid py-4">
                    @yield('content')
                    {{-- @include('layouts.footers.auth.footer') --}}
                </div>
            </main>
        @elseif(\Request::is('profile'))
            @include('layouts.navbars.auth.sidebar')
            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
                @include('layouts.navbars.auth.nav')
                @yield('content')
            </div>
        @elseif(\Request::is('virtual-reality'))
            @include('layouts.navbars.auth.nav')
            <div class="border-radius-xl mt-3 mx-3 position-relative"
                style="background-image: url('{{ asset('assets/img/vr-bg.jpg') }}') ; background-size: cover;">
                @include('layouts.navbars.auth.sidebar')
                <main class="main-content mt-1 border-radius-lg">
                    @yield('content')
                </main>
            </div>
            {{-- @include('layouts.footers.auth.footer') --}}
        @else
            @include('layouts.navbars.auth.sidebar')
            <main
                class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ Request::is('rtl') ? 'overflow-hidden' : '' }}">
                @include('layouts.navbars.auth.nav')
                <div class="container-fluid py-4">
                    @yield('content')
                    {{-- @include('layouts.footers.auth.footer') --}}
                </div>
            </main>
        @endif

        @include('components.fixed-plugin')
    @endif

    <script>
        $(document).ready(function() {
            if (window.location.pathname.split('/')[1] == "management") {
                urlNow = new URL(window.location.href).origin + '/' + window.location.pathname.split('/')[1] + '/' +
                    window.location.pathname.split('/')[2];
            } else {
                urlNow = new URL(window.location.href).origin + '/' + window.location.pathname.split('/')[1];
            }
            console.log(urlNow);
        });

        function refreshSidebar(id) {
            fetch('{{ route('sidebar.content') }}')
                .then(response => response.text())
                .then(html => {
                    // Ganti isi elemen sidebar dengan konten yang diperbarui
                    document.getElementById('sidenav-main').innerHTML = html;
                    var menuActive = document.getElementById(id);
                    menuActive.classList.add('active');
                })
                .catch(error => console.error('Error refreshing sidebar:', error));
        }
    </script>

@endsection
