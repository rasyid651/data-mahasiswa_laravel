<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets-template/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-template/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/login') }}">
                <img src="{{ asset('assets-template/dist/img/AdminLTELogo.png') }}"
                     alt="Logo"
                     style="width:58px;height:48px;opacity:.9;margin-right:2px;">
                Admin<b>LTE</b>
            </a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Masukkan username dan password</p>

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text"
                               class="form-control @error('username') is-invalid @enderror"
                               name="username"
                               placeholder="Username"
                               value="{{ old('username') }}"
                               required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password"
                               placeholder="Password"
                               required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-center">
                        <div class="g-recaptcha"
                             data-sitekey="{{ config('services.recaptcha.site_key') }}">
                        </div>
                        @error('g-recaptcha-response')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                Masuk
                            </button>
                        </div>
                    </div>
                </form>

                <hr style="height: 0.5px;">

                <p class="text-center text-muted mb-0" style="font-size:12px;">
                    Developer ©
                    <a href="{{ url('/login') }}">Rasyid Teknologi</a>
                    2026
                </p>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets-template/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets-template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-template/dist/js/adminlte.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
