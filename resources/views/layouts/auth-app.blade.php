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
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
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

    <link rel="stylesheet" href="/assets/css/auth.css"/>

    @stack('styles')
    <!-- jQuery -->
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>

    <style>
        #app {
            vertical-align: middle;
        }
        #main {
            display: table;
            width: 100%;
        }
        .container {
            display: table-cell;
            vertical-align: middle;
        }
    </style>
    @stack('styles')
</head>
<body class="vh-100">
    <div id="app" class="vh-100">

        <main class="main vh-100" id="main">

            @yield('content')

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
