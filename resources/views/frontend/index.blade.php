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
    
    <link rel="stylesheet" href="{{asset('/assets/css/auth.css')}}"/>
    <style>
        body {
            background: rgba(0,0,0, 0.5);
            /* background: rgba(227,227,227, 0.8); */
        }
        .logo-wrapper {
            margin-bottom: 50px;
        }
        
        #main {
            max-width: 420px;
            width: 100%;
            padding: 50px;
            margin: 0 auto;
            background-color: #021f63;
            border-radius: 10px;
            color: #ffffff;
            position: absolute;
            left: 0;
            right: 0;
            top: 10%;
        }
        .btn-sign-in {
            color: #ffffff;
            border: 1px solid #ffffff;
            width: 200px;
        }
        .btn-sign-in:hover {
            color: #007bff;
            border: 1px solid #007bff;
        }
        .btn-create-account {
            background: #ffffff;
            color: #000000;
            width: 200px;
        }
        .btn-create-account:hover {
            background-color: #007bff;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div id="app">
        <main class="main text-center" id="main">
            <div class="logo-wrapper">
                <img src="{{asset('assets/images/psm-logo.png')}}" alt="PSM" width="80px">
            </div>

            <div class="form-group">
                <a href="{{route('login')}}" class="btn btn-outline btn-sign-in">Sign In</a>
            </div>
            <div class="form-group mb-5">
                <a href="{{route('register')}}" class="btn btn-create-account">Create New Account</a>
            </div>
            <p class="text-white text-center">
                အကောင့်ရှိပြီး ဖြစ်ပါက Sign In ကိုနှိပ်ပါ။ <br>
                အကောင့်မရှိသေးပါက Create Account <br>
                နှိပ်ပြီး အကောင့်အသစ်ဖွင့်လို့ရပါတယ်။
            </p>
        </main>
    </div>
    <script>
        $(function(){
            
        });
    </script>
</body>
</html>
