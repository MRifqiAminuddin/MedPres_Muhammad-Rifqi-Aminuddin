<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/icon_jai_yazaki.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon_jai_yazaki.png') }}">
    <title>
        @yield('title') | PT. JAI
    </title>
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" /> --}}
    <link href="{{ asset('assets/fonts/google-font.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> --}}
    <script src="{{ asset('assets/js/font-awesome.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}"></script>

    @yield('head')

</head>

<body class="g-sidenav-show" style="background-color: #fcfcfc!important">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <script>
            function alertDelete(text, identity) {
                Swal.fire({
                    title: "Please Confirm!",
                    html: "Do you want to delete data with the name <b>" + text + "</b>?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteData(text, identity);
                    }
                });
            }

            function confirm(name, text, identity, fNew) {
                Swal.fire({
                    title: "Please Confirm!",
                    html: text,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fNew(name, identity);
                    }
                });
            }

            function success(text) {
                let timerInterval;
                Swal.fire({
                    icon: "success",
                    title: "Success!",
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
                    title: "I'm Sorry!",
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

        @auth
            @yield('auth')
        @endauth
        @guest
            @yield('guest')
        @endguest

        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
                <p class="m-0">{{ session('success') }}</p>
            </div>
        @endif

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
        @yield('js')
    </main>
</body>

</html>
