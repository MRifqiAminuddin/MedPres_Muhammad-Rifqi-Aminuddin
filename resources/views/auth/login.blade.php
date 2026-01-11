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
                                        <h3 class="font-weight-bolder text-info text-gradient">RS Delta Surya
                                        </h3>
                                        <h3 class="font-weight-bolder text-info text-gradient">Medical Prescription</h3>
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
                                            <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">
                                                Masuk
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Belum aktivasi akun? Aktivasi
                                        <a href="{{ route('auth.verification.index') }}" class="text-info text-gradient font-weight-bold">di sini</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
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
