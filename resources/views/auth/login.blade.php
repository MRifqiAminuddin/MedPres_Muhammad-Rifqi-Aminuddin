@extends('layout.app')

@section('title')
    Masuk
@endsection

@section('content')
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-7 col-md-9 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-6" style="background-color: #fff;">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <center>
                                        <h3 class="font-weight-bolder text-primary text-gradient">RS Delta Surya
                                        </h3>
                                        <h3 class="font-weight-bolder text-primary text-gradient">Medical Prescription</h3>
                                        <p class="mb-0">Silahkan masukkan email dan password Anda</p>
                                    </center>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('auth.login.process') }}">
                                        @csrf
                                        <label>Email</label>
                                        <div class="mb-3">
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Email" value="" aria-label="Email"
                                                aria-describedby="email-addon">
                                            @error('email')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Password" value="" aria-label="Password"
                                                aria-describedby="password-addon">
                                            @error('password')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">
                                                Masuk
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Belum aktivasi akun? Aktivasi
                                        <a href="{{ route('auth.verification.index') }}"
                                            class="text-primary text-gradient font-weight-bold">di sini</a>
                                    </p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#listAkunModal">lihat akun</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="modal fade" id="listAkunModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">List Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="fa-solid fa-x text-dark"></i></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-dark text-white" role="alert">
                        Dokter<br>
                        dr.soemarso@gmail.com <br>
                        12345678
                    </div>
                    <div class="alert alert-info text-white" role="alert">
                        Apoteker<br>
                        apt.rani@gmail.com <br>
                        12345678
                    </div>
                    <div class="alert alert-success text-white" role="alert">
                        Admin<br>
                        admin@gmail.com <br>
                        12345678
                    </div>
                    <div class="alert alert-light text-dark" role="alert">
                        Super Admin<br>
                        superadmin@gmail.com <br>
                        12345678
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.body.style.width = "100vw";
        document.body.style.height = "100vh";
        document.body.style.backgroundImage = "url('{{ asset('assets/img/login.webp') }}')";
        document.body.style.backgroundSize = "cover";
        document.body.style.backgroundPosition = "center";
        document.body.style.backgroundRepeat = "no-repeat";
    </script>
@endsection
