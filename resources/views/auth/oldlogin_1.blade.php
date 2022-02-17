<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PSM INTERNATIONAL COLLEGE') }}</title>
    <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.png') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Tempusdominus Bbootstrap 4 -->
    {{-- <link rel="stylesheet" href="/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> --}}
    
    {{-- <link rel="stylesheet" href="/assets/css/frontend.css"/>
    <link rel="stylesheet" href="/assets/css/responsive.css"/> --}}
    <link rel="stylesheet" href="/adminlte/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/jquery.datetimepicker.css')}}">
    <link rel="stylesheet" href="/adminlte/plugins/dropify/dist/css/dropify.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/adminlte/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/jquery-ui/jquery-ui.min.css">

    <!-- jQuery -->
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>

    <style>
        body {
            background: rgba(0,0,0, 0.5);
        }
        .card {
            background-color: #021f63;
            max-width: 420px;
            width: 100%;
            border-radius: 10px;
            margin: 0 auto;
        }
        .password-forgot {
            color: #ffffff;
            font-weight: 500;
        }
        .password-forgot:hover {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div id="app">

        <main class="main" id="main">

            <div class="container login-page py-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
            
                            <div class="card-body py-5 text-white text-center">
                                <div class="logo-wrapper mb-4">
                                    <img src="{{asset('assets/images/psm-logo.png')}}" alt="PSM" width="80px">
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                      @include('flash::message')
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
            
                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-9">
                                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="Email or Phone Number" autofocus>
            
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-9">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
            
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row justify-content-center mb-4 text-left">
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="form-group row justify-content-center mb-3">
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-primary brand-btn-color px-5">
                                                {{-- {{ __('Login') }} --}}
                                                Sign In
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center mb-1">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link password-forgot" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>

                                    <div class="form-group row justify-content-center mb-0">
                                        <p class="text-muted mb-0">
                                            Password မေ့နေပါက <br> Forgot Password ကိုနှိပ်ပါ။
                                        </p>
                                    </div>
            
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

    </div>
    
    <!-- Bootstrap 4 -->
    <script src="{{asset('/assets/js/popper.min.js')}}"></script>
    <script src="/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="{{asset('assets/js/jquerydatetimepickerfull.js')}}"></script>
    <script src="/adminlte/plugins/dropify/dist/js/dropify.min.js"></script>
    <script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>
    <!-- Toastr -->
    <script src="/adminlte/plugins/toastr/toastr.min.js"></script>

    <script src="{{asset('/assets/js/frontend.js')}}"></script>
    
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script>
        $(function(){
            $('.dropify').dropify();
        });
        $('.select2').select2();
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

    </script>

    @stack('scripts')
</body>
</html>
