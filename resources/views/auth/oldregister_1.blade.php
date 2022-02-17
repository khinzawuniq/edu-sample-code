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
            max-width: 450px;
            width: 100%;
            border-radius: 10px;
            margin: 0 auto;
        }
        .btn-old-password, .btn-password, .btn-confirm-password {
            cursor: pointer;
            position: absolute;
            right: 10px;
            bottom: 7px;
            z-index: 99;
        }
        .password, .confirm_password {
            border-radius: 0.25rem !important;
        }
    </style>
</head>
<body>
    <div id="app">

        <main class="main" id="main">

            <div class="container register-page py-5">
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
            
                            <div class="card-body py-4 text-white text-center">

                                <div class="logo-wrapper mb-4">
                                    <img src="{{asset('assets/images/psm-logo.png')}}" alt="PSM" width="80px">
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                      @include('flash::message')
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
            
                                    <div class="form-group row justify-content-center">
                                        {{-- <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label> --}}
            
                                        <div class="col-md-10">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Name" autocomplete="name" autofocus>
            
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row justify-content-center">
                                        {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> --}}
            
                                        <div class="col-md-10">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Email" autocomplete="email">
            
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row justify-content-center">
                                        {{-- <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label> --}}
            
                                        <div class="col-md-10">
                                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required placeholder="Phone" autocomplete="phone">
            
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row password-wrapper justify-content-center">
                                        {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> --}}
            
                                        <div class="col-md-10 text-left">
                                            <div class="input-group">
                                                <input id="password" type="password" class="form-control password @error('password') is-invalid @enderror" name="password" required placeholder="Password" autocomplete="new-password">
                                                <span class="btn-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                            </div>
                                            <small class="mm text-left"> Password ပေးသည့်အခါ အနည်းဆုံး (၆) လုံး ပေးရပါမည်။ </small>
                                            {{-- <small class="mm text-left">The password must have at least 6 characters.</small> --}}
            
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row password-wrapper mb-5 justify-content-center">
                                        {{-- <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label> --}}
            
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <input id="password-confirm" type="password" class="form-control confirm_password" name="password_confirmation" required placeholder="Confirm Password" autocomplete="new-password">
                                                <span class="btn-confirm-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="form-group row justify-content-center mb-0">
                                        <div class="col-md-10">
                                            <button type="submit" class="btn btn-primary px-5">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
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
            $('.btn-password').click(function(){
                if('password' == $('.password').attr('type')){
                    $('.password').prop('type', 'text');
                }else{
                    $('.password').prop('type', 'password');
                }
            });
            $('.btn-confirm-password').click(function(){
                if('password' == $('.confirm_password').attr('type')){
                    $('.confirm_password').prop('type', 'text');
                }else{
                    $('.confirm_password').prop('type', 'password');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>