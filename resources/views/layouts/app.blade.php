<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title', '') {{ config('app.name', 'myPSM - Digital Classroom') }} </title>

    <meta name="description" content="@yield('meta-description', 'PSM INTERNATIONAL COLLEGE')" />
    <meta property="og:title" content="@yield('og-title', 'myPSM - Digital Classroom')" />
    <meta property="og:image" content="@yield('og-image', 'myPSM - Digital Classroom')" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    {{-- For Chat --}}
    <meta name="route" content="{{\Request::route()->getName()}}">
    <meta name="url" content="{{Request::url()}}" data-user="{{ (Auth::check())?Auth::user()->id:'' }}">
    
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
    
    <link rel="stylesheet" href="/assets/css/frontend.css"/>
    <link rel="stylesheet" href="/assets/css/responsive.css"/>
    <link rel="stylesheet" href="/adminlte/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/jquery.datetimepicker.css')}}">
    <link rel="stylesheet" href="/adminlte/plugins/dropify/dist/css/dropify.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/adminlte/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/jquery-ui/jquery-ui.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

    <style>
        @media print {
            html, body {
               display: none;  /* hide whole page */
            }
        }
    </style>
    @stack('styles')
    <!-- jQuery -->
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>

</head>
<body>
    <div id="app">
        <a id="backtotop" class="text-center text-white"><i class="fas fa-arrow-up"></i></a>

        <div class="container brand-wrapper bg-brand">
            <div class="row">
                <div class="col-12">
                    <div class="brand d-flex align-items-center">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{asset('assets/images/psm-logo-1.png')}}" alt="PSM" width="90px">
                        </a>
                        <a href="{{ url('/') }}" class="sitename"><h1 class="text-white text-uppercase mr-auto mb-0">PSM <span class="tag-name">INTERNATIONAL COLLEGE</span> </h1></a>

                        <div class="classroom text-white ml-auto">
                            <div class="mypsm"><span class="my">my</span>PSM</div>
                            <div class="digital-classroom">DIGITAL CLASSROOM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <nav class="navbar navbar-expand-md navbar-light shadow-sm float-left w-100" id="main-navbar">
            <div class="container">
                
            <div class="row navigation-wrapper">
                <div class="col-12 p-0">
    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    @php
                        $programmes = \App\Models\CourseCategory::All();
                    @endphp
    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="main-menu navbar-nav">
                            <li class="nav-item">
                                <a href="{{route('home')}}" class="nav-link {{ (Request::is('/')) ? 'active' : '' }} {{ (Request::is('home')) ? 'active' : '' }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('courses')}}" class="nav-link {{ (Request::is('courses*')) ? 'active' : '' }}">Courses</a>
                            </li>
                            
                            @if(Auth::check())
                            <li class="nav-item">
                                <a href="{{route('my_courses')}}" class="nav-link {{ (Request::is('my_courses*')) ? 'active' : '' }}">My Courses</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{route('blogs')}}" class="nav-link {{ (Request::is('blogs')) ? 'active' : '' }}">Blogs</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{route('library')}}" class="nav-link {{ (Request::is('library')) ? 'active' : '' }}">Library</a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{route('faq')}}" class="nav-link {{ (Request::is('faq')) ? 'active' : '' }}">FAQ</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('contact')}}" class="nav-link  {{ (Request::is('contact')) ? 'active' : '' }}">Contact</a>
                            </li>
                            
                        </ul>
    
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav navbar-right ml-auto">
                            
                            @guest
                                <li class="nav-item text-right">
                                    <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-user mr-2"></i> My Account</a>
                                    {{-- <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-user mr-2"></i> {{ __('Login') }}</a> --}}
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        @if(!empty(auth()->user()->photo))
                                            <img src="{{asset('/uploads/'.auth()->user()->photo)}}" alt="" class="frontend-user-img img-circle elevation-2 mr-2">
                                        @else
                                            <img src="/adminlte/dist/img/user1-128x128.jpg" alt="" class="frontend-user-img img-circle elevation-2 mr-2">
                                        @endif
                                        <span class="caret"></span>
                                    </a>
    
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @can(['list','create','edit'])
                                        <a class="dropdown-item" href="{{ route('dashboard.index') }}" >
                                            Dashboard
                                        </a>
                                        @endcan
    
                                        <a class="dropdown-item" href="{{ url('profile/'.Auth::user()->id) }}">
                                            {{ Auth::user()->name }}'s Profile
                                        </a>
                                        
                                        @can(['list','create','edit','delete'])
                                        <a class="dropdown-item" href="{{ url('admin/switch-role/'.Auth::user()->id) }}">
                                            @if(auth()->user()->switch_role == "Super Admin" || auth()->user()->switch_role == null)
                                                Switch Account To Normal User
                                            @else
                                                Return To My Normal Role
                                            @endif
                                            
                                        </a>
                                        @endcan
    
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
    
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
            </div>
            </nav>


        <main class="main" id="main">
            <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    @include('flash::message')
                  </div>
                </div>
            </div>

            @yield('content')
        </main>

        <section class="footer">
            <div class="container">
                @php
                    $campus_address = App\Models\CampusAddress::where('is_active', 1)->get()->take(3);
                @endphp

                <div class="row footer-top py-4">
                    @foreach($campus_address as $campus)
                    <div class="col-md-4 col-12 mb-2">
                        <h4>{{$campus->campus_name}}</h4>
                        <ul class="pl-0 mb-0">
                            <li>{{$campus->address}}</li>
                            <li>{{$campus->phone}}</li>
                            <li>{{$campus->email}}</li>
                        </ul>
                    </div>
                    @endforeach
                    {{-- <div class="col-md-4 col-12 mb-2">
                        <h4>San Yeik Nyein Campus</h4>
                        <ul class="pl-0 mb-0">
                            <li>No. 513, 5th Floor, San Yeik Nyein Gamone Pwint Shopping Centre Yangon, Myanmar.</li>
                            <li>09764167705.</li>
                            <li>info@psmeducation.com</li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-12 mb-2">
                        <h4>Tarmwe Campus</h4>
                        <ul class="pl-0 mb-0">
                            <li>4th Floor, 155th Street, Kyaikkasan Road, Tarmwe Yangon, Myanmar.</li>
                            <li>09777765030.</li>
                            <li>info@psmeducation.com</li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-12 mb-2">
                        <h4>Mandalay Campus</h4>
                        <ul class="pl-0 mb-0">
                            <li>No. 691, 40th Street, Between 70th and 71st Street, Mahar Aung Myay Mandalay, Myanmar.</li>
                            <li>09777766205.</li>
                            <li>info@psmeducation.com</li>
                        </ul>
                    </div> --}}
                </div>
                
                <div class="row footer-bottom bg-copyright">
                    <div class="col-12 px-5 copyright text-center">

                        <div class="social pr-4">
                            <a target="_blank" href="https://www.facebook.com/psminternationalcollege" class="text-white"><i class="fab fa-facebook-f"></i></a>
                            <a target="_blank" href="#" class="text-white ml-2"><i class="fab fa-instagram"></i></a>
                            <a target="_blank" href="#" class="text-white ml-2"><i class="fab fa-twitter"></i></a>
                            <a target="_blank" href="https://www.youtube.com/channel/UCP6kb8It9b3ZY9ZwI3-6WKA?view_as=subscriber" class="text-white ml-2"><i class="fab fa-youtube"></i></i></a>
                        </div>

                        <p class="m-0">Copyright &copy; PSM International College. All rights reserved.</p>

                    </div>
                </div>
            </div>
        </section>

        <div id="fb-root"></div>
        <div id="fb-customer-chat" class="fb-customerchat">
        </div>

    </div>
    
    <!-- Bootstrap 4 -->
    {{-- <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{asset('/assets/js/popper.min.js')}}"></script>
    <script src="/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="{{asset('assets/js/jquerydatetimepickerfull.js')}}"></script>
    <script src="/adminlte/plugins/dropify/dist/js/dropify.min.js"></script>
    <script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>
    <!-- Toastr -->
    <script src="/adminlte/plugins/toastr/toastr.min.js"></script>

    <script src="{{asset('/assets/js/frontend.js')}}"></script>
    
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <!-- DataTables -->
    <script src="/adminlte/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script>

        $('.select2').select2();
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $('.dropify').dropify();

        $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        uiLibrary: 'bootstrap4',
        });

        //Timepicker
        $('.timepicker').datetimepicker({
            format:'d/m/Y H:i',
        });

        $(document).bind("contextmenu",function(e){
        return false;
            });

    </script>

    <script>
        $("input").keypress(function (evt) {

            var keycode = evt.charCode || evt.keyCode;
            if (keycode  == 44) { //Enter key's keycode
              return false;
            }
          });
        document.addEventListener("keyup", function (e) {
            var keyCode = e.keyCode ? e.keyCode : e.which;
                    if (keyCode == 44) {
                        return false;
                        stopPrntScr();
                    }
                });
        function stopPrntScr() {
        
                    var inpFld = document.createElement("input");
                    inpFld.setAttribute("value", ".");
                    inpFld.setAttribute("width", "0");
                    inpFld.style.height = "0px";
                    inpFld.style.width = "0px";
                    inpFld.style.border = "0px";
                    document.body.appendChild(inpFld);
                    inpFld.select();
                    document.execCommand("copy");
                    inpFld.remove(inpFld);
                }
               function AccessClipboardData() {
                    try {
                        window.clipboardData.setData('text', "Access   Restricted");
                    } catch (err) {
                    }
                }
                setInterval("AccessClipboardData()", 300);

        var get_stop_lesson = localStorage.getItem('stop_lesson');
        if(get_stop_lesson != '') {
            getPauseLesson();
        }

        function getPauseLesson()
        {
            if(get_stop_lesson != null) {
                var stop_lesson = JSON.parse(get_stop_lesson);
                console.log(stop_lesson);

                var play_id             = stop_lesson.play_id;
                var course_id           = stop_lesson.course_id;
                var current_module_id   = stop_lesson.current_module_id;
                var current_lesson_id   = stop_lesson.current_lesson_id;
                var pause_date          = stop_lesson.pause_date;
                
                $.ajax({
                                type:'POST',
                                async: false,
                                url: "{{url('pause_lesson')}}",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: {
                                    play_id: play_id,
                                    course_id: course_id,
                                    module_id: current_module_id,
                                    lesson_id: current_lesson_id,
                                    pause_date: pause_date
                                },
                                success: (response) => {
                                    console.log(response);
                                    localStorage.setItem('stop_lesson', '');
                                },
                                
                        });
            }
        }

    </script>
    <script>
          var chatbox = document.getElementById('fb-customer-chat');
          chatbox.setAttribute("page_id", "2011395949122540");
          chatbox.setAttribute("attribution", "biz_inbox");
    
          window.fbAsyncInit = function() {
            FB.init({
              xfbml            : true,
              version          : 'v11.0'
            });
          };
    
          (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));
    </script>

    @stack('scripts')
</body>
</html>
