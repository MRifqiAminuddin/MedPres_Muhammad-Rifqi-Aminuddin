<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/logos/medpres.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logos/medpres.png') }}">
    <title>
        @yield('title') | MedPres RS Delta Surya
    </title>
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" /> --}}
    <link href="{{ asset('assets/fonts/google-font.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css') }}?v=1.0.3" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
    <link href="{{ asset('assets/css/fontawesome.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}"></script>

    @yield('head')

</head>

<body class="g-sidenav-show" style="background-color: #e6e6e6!important">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <script>
            function alertDelete(text, identity) {
                Swal.fire({
                    title: "Konfirmasi Segera!",
                    html: "Apakah Anda ingin menghapus data milik <b>" + text + "</b>?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Tidak",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteData(text, identity);
                    }
                });
            }

            function showConfirm(name, identity, text, callback) {
                Swal.fire({
                    title: 'Konfirmasi!',
                    html: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya',
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback(name, identity);
                    }
                });
            }


            function success(text) {
                let timerInterval;
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    html: text,
                    timer: 2000,
                    timerProgressBar: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            }

            function fail(text) {
                let timerInterval;
                Swal.fire({
                    icon: "error",
                    title: "Mohon maaf!",
                    html: text,
                    timer: 2000,
                    timerProgressBar: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            }

            function showLoader() {
                $("#preloader").css("display", "flex")
            }

            function hideLoader() {
                $("#preloader").css("display", "none")
            }
        </script>

        @if (session()->has('success'))
            <script>
                success("{{ session('success') }}");
            </script>
        @endif

        @if (session()->has('fail'))
            <script>
                fail("{{ session('fail') }}");
            </script>
        @endif

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

        @auth
            @include('layout.components.sidebar')
            <main
                class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg {{ Request::is('rtl') ? 'overflow-hidden' : '' }}">
                @include('layout.components.navbar')
                <div class="container-fluid py-4">
                    @yield('content')
                    @include('layout.components.footer')
                </div>
            </main>

            {{-- @include('layout.components.fixed-plugin') --}}
        @endauth
        @guest
            @yield('content');
        @endguest

        <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
        <script>
            var navbarColorOnResize = function() {
                if ($(window).width() > 991) {
                    if ($('.main-content .fixed-plugin > .card').length != 0) {
                        $('.main-content .fixed-plugin > .card').removeClass('blur');
                    }
                }
            };
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', navbarColorOnResize);
            } else {
                navbarColorOnResize();
            }
        </script>
        @yield('script')
    </main>
</body>

</html>
