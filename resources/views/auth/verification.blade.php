@extends('layout.app')

@section('title')
    Verifikasi
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
                                        <p class="mb-0">Silahkan masukkan otp yang telah dikirimkan</p>
                                    </center>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('auth.login.process') }}">
                                        @csrf
                                        <label>OTP</label>
                                        <div class="mb-3 row justify-content-center text-center">
                                            <div class="col-2 px-4">
                                                <input type="number"
                                                    class="form-control no-spinner w-100 text-center otp-input"
                                                    name="otp1" id="otp1" placeholder="*" aria-label="OTP">
                                            </div>
                                            <div class="col-2 px-4">
                                                <input type="number"
                                                    class="form-control no-spinner w-100 text-center otp-input"
                                                    name="otp2" id="otp2" placeholder="*" aria-label="OTP">
                                            </div>
                                            <div class="col-2 px-4">
                                                <input type="number"
                                                    class="form-control no-spinner w-100 text-center otp-input"
                                                    name="otp3" id="otp3" placeholder="*" aria-label="OTP">
                                            </div>
                                            <div class="col-2 px-4">
                                                <input type="number"
                                                    class="form-control no-spinner w-100 text-center otp-input"
                                                    name="otp4" id="otp4" placeholder="*" aria-label="OTP">
                                            </div>
                                        </div>

                                        @error('email')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">
                                                Verifikasi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Sudah punya akun? Silahkan login
                                        <a href="{{ route('auth.login.index') }}"
                                            class="text-info text-gradient font-weight-bold">di sini</a>
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
        Object.assign(document.body.style, {
            width: '100vw',
            height: '100vh',
            backgroundImage: "url('{{ asset('assets/img/login.webp') }}')",
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            backgroundRepeat: 'no-repeat',
        });

        document.querySelectorAll('.otp-input').forEach((el, i, arr) => {
            el.oninput = () => {
                if (el.value && arr[i + 1]) {
                    arr[i + 1].focus();
                }
            };

            el.onkeydown = (e) => {
                if (e.key === 'Backspace' && el.value === '' && arr[i - 1]) {
                    arr[i - 1].focus();
                }
            };
        });
    </script>
@endsection
