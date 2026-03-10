<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FarsanHub') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="css/guest.css" />
    <link rel="stylesheet" href="css/fonts.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/css/index.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .btn-google-login {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px !important;
            width: 100%;
            padding: 11px 16px !important;
            background-color: #fff !important;
            color: #3d2200 !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            border: 1.5px solid #FF9933 !important;
            border-radius: 8px !important;
            text-decoration: none !important;
            transition: background-color 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease !important;
            cursor: pointer;
        }
        .btn-google-login:hover {
            background-color: #fff5e6 !important;
            border-color: #e07a1a !important;
            color: #3d2200 !important;
            box-shadow: 0 2px 8px rgba(255, 153, 51, 0.30) !important;
            text-decoration: none !important;
        }
        .btn-google-login:active {
            background-color: #ffe8c2 !important;
            box-shadow: none !important;
        }
    </style>

</head>

<body class="font-sans antialiased text-gray-900">
    <div class="container-fluid">
        <div class="row">
            <!-- Right Column -->
            <div class="bg-light d-flex justify-content-center flex-column vh-100">
                <div class="row d-flex justify-content-center align-items-center ">
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="bg-white p-4" style="border-radius:29px;">
                            <div class="text-center">
                                <img src="{{ asset('images/logo.png') }}" width="200" height="200" />
                                <h2 class="guest-heading mt-4">Login</h2>
                                <!-- <p class="guest-subline text-center ">Login</p> -->
                            </div>
                            <div class=" mx-4 mb-4">

                                {{-- Google Login Button --}}
                                <div class="d-grid mb-3">
                                    <a href="{{ route('auth.google') }}" class="btn-google-login">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48" style="flex-shrink:0;">
                                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                        </svg>
                                        Continue with Google
                                    </a>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <hr class="flex-grow-1" style="border-color: #e0c8a8;">
                                    <span class="px-3 small" style="color:#a08060; font-size:12px;">or sign in with email</span>
                                    <hr class="flex-grow-1" style="border-color: #e0c8a8;">
                                </div>

                                @if(session('error'))
                                <div class="alert alert-danger py-2">{{ session('error') }}</div>
                                @endif

                                <form action="{{ route('login.post') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-block mt-6 py-3">
                                            Login
                                        </button>
                                    </div>
                                </form>
                                {{-- <div class="mt-3 text-center">
                                    <p>Don't have an account? <a class="text-primary" href="{{ route('register') }}">Register here</a></p>
                                </div> --}}
                            </div>
                            <!-- <div class="mt-4 mx-4 text-center">
                                <a href="forgot_pin.php" class="text-danger fw-bold">Forgot Password?</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
