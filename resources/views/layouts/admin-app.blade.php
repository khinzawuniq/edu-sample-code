<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PSM') }}</title>
    
    <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.png') }}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="/adminlte/plugins/ekko-lightbox/ekko-lightbox.css">

  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="/adminlte/plugins/toastr/toastr.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/adminlte/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/adminlte/plugins/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <link rel="stylesheet" href="/adminlte/plugins/dropify/dist/css/dropify.min.css">
  <link rel="stylesheet" href="/adminlte/plugins/jquery-ui/jquery-ui.min.css">
  <link rel="stylesheet" href="{{asset('assets/css/jquery.datetimepicker.css')}}">

  <!-- DataTables -->
  <link rel="stylesheet" href="/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

  <link rel="stylesheet" href="/assets/css/gijgo.min.css"/>
  {{-- funcybox --}}
  <link href="{{ asset('adminlte/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet" type="text/css"/>
  <!-- Google Font: Source Sans Pro -->
  {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}
  <style>
    table.table td {
      font-size: 14px;
    }
    .draggable {
        will-change: transform;
        font-family: "Raleway", sans-serif;
        font-weight: 800;
        list-style-type: none;
        color: #212121;
        line-height: 3.2;
        cursor: move;
        transition: all 200ms;
        user-select: none;
        position: relative;
      }

      .draggable:hover:after {
        opacity: 1;
        transform: translate(0);
      }
      .over {
        transform: scale(1.1, 1.1);
      }
  </style>

  <link rel="stylesheet" href="/assets/css/custom.css"/>
  @stack('styles')
  <!-- jQuery -->
  <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-primary brand-bg-color">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li> --}}
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">1</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">1 Notifications</span>
          
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="far fa-comment-dots mr-2"></i> hello
          </a>
        </div>
      </li> --}}
      <!-- Logout Dropdown Menu -->
      <li class="nav-item dropdown">
        <a data-toggle="dropdown"  href="#">
            <div class="user-panel d-flex" style="overflow: initial;">
                <div class="info text-white">
                  {{ Auth::user()->name }}
                </div>
                <div class="image">
                  <img src="/adminlte/dist/img/user1-128x128.jpg" alt="" class="img-circle elevation-2 mr-2">
                </div>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{route('users.profile',Auth::id())}}" class="dropdown-item"> <i class="fas fa-user mr-2"></i> Profile </a>
          <a href="{{ route('logout') }}" class="dropdown-item"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </div>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="{{url('/admin/dashboard')}}" class="brand-link navbar-light text-center">
      <img src="{{asset('assets/images/psm-logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle"
           style="opacity: 1">
      {{-- <span class="brand-text font-weight-bold text-white">PSM</span> --}}
    </a>

    @php
      $user = App\User::find(Auth::user()->id);
    @endphp
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-flat text-center" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="{{url('/admin/dashboard')}}" class="nav-link {{ (Request::is('admin/dashboard*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i> <br/> <p> Dashboard </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('/admin/category-course-management')}}" class="nav-link {{ (Request::is('admin/course_categories*') || Request::is('admin/courses*') || Request::is('admin/category-course-management*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i> <br/> <p> Courses and Category Management</p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="{{url('/admin/enrol-user')}}" class="nav-link {{ Request::is('admin/enrol-user*')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-friends"></i> <br/> <p>Enrolled Students</p>
            </a>
          </li> --}}
          <li class="nav-item">
            <a href="{{url('/admin/payments')}}" class="nav-link {{ Request::is('admin/payments*')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-dollar-sign"></i> <br/> <p>Student Payments</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/certificate_templates')}}" class="nav-link {{ Request::is('admin/certificate_templates*')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-certificate"></i> <br/> <p>Certificate Templates</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/knowledge-blogs')}}" class="nav-link {{ Request::is('admin/knowledge-blogs*')  ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-friends"></i> <br/> <p>Knowledge Blogs</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{url('/laravel-filemanager')}}" class="nav-link {{ Request::is('laravel-filemanager*')  ? 'active' : '' }}">
              <i class="nav-icon far fa-folder-open"></i> <br/> <p>File Manager</p>
            </a>
          </li>
          
          @can(['list','create','edit','delete'])
          {{-- Grading --}}
          <li class="nav-item has-treeview {{ (Request::is('admin/gradings*')) || (Request::is('admin/ads*')) ||
                                              (Request::is('admin/question-per-pages*')) || (Request::is('admin/campus_address*')) || (Request::is('admin/blog-categories*'))
                                              ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{  (Request::is('admin/gradings*')) || (Request::is('admin/ads*')) ||
                                            (Request::is('admin/question-per-pages*')) || (Request::is('admin/campus_address*')) || (Request::is('admin/blog-categories*'))
                                            ? 'active' : '' }}">
              <i class="nav-icon fas fa-cogs"></i> <br/>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/slideshows')}}" class="nav-link {{ (Request::is('admin/slideshows*')) ? 'active' : '' }}">
                  <i class="fab fa-slideshare nav-icon"></i> <br/>
                  <p>SlideShows</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/gradings')}}" class="nav-link {{ (Request::is('admin/gradings*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i> <br/>
                  <p>Gradings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/question-per-pages')}}" class="nav-link {{ (Request::is('admin/question-per-pages*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i> <br/>
                  <p>Question Per Pages</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/settings')}}" class="nav-link {{ (Request::is('admin/settings*')) ? 'active' : '' }}">
                  <i class="fas fa-cog nav-icon"></i> <br/>
                  <p>Default Settings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/campus_address')}}" class="nav-link {{ (Request::is('admin/campus_address*')) ? 'active' : '' }}">
                  <i class="fas fa-map-marker-alt nav-icon"></i> <br/>
                  <p>Campus Address</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/ads')}}" class="nav-link {{ (Request::is('admin/ads*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i> <br/>
                  <p>Ads</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/blog-categories')}}" class="nav-link {{ (Request::is('admin/blog-categories*')) ? 'active' : '' }}">
                  <i class="fas fa-map-marker-alt nav-icon"></i> <br/>
                  <p>Blog Categories</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item has-treeview {{ (Request::is('admin/users*')) || 
                                              (Request::is('admin/roles*')) ||
                                              (Request::is('admin/permissions*'))
                                              ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{  (Request::is('admin/users*')) || 
                                            (Request::is('admin/roles*')) ||
                                            (Request::is('admin/permissions*'))
                                            ? 'active' : '' }}">
              <i class="nav-icon fas fa-users-cog"></i> <br/>
              <p>
                User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/users')}}" class="nav-link {{ (Request::is('admin/users*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i> <br/>
                  <p>Users</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{url('/admin/roles')}}" class="nav-link {{ (Request::is('admin/roles*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i> <br/>
                  <p>Roles and Permissions</p>
                </a>
              </li>
              
              {{-- <li class="nav-item">
                <a href="{{url('/admin/permissions')}}" class="nav-link {{ (Request::is('admin/permissions*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i> <br/>
                  <p>Permissions</p>
                </a>
              </li> --}}
              
            </ul>
          </li>
          @endcan
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          @include('flash::message')
        </div>
      </div>
    </div>

    @yield('content')

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{date('Y')}} <a href="#">{{ config('app.name') }}</a></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Developed By</b> <a href="#">New River</a>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

{{-- <!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script> --}}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('/assets/js/popper.min.js')}}"></script>
<script src="{{asset('/assets/js/gijgo.min.js')}}" type="text/javascript"></script>

<script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>
<!-- Toastr -->
<script src="/adminlte/plugins/toastr/toastr.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="/adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/adminlte/plugins/moment/moment.min.js"></script>
<script src="/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="/adminlte/dist/js/pages/dashboard.js"></script> --}}
<!-- AdminLTE for demo purposes -->
{{-- <script src="adminlte/dist/js/demo.js"></script> --}}

{{-- CK Editor --}}
<script src="{{asset('/assets/templateEditor/ckeditor/ckeditor.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.js"></script>

{{-- <script src="{{asset('/assets/js/bootstrap-filestyle/src/bootstrap-filestyle.min.js')}}"></script> --}}

<!-- Ekko Lightbox -->
<script src="/adminlte/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

<!-- DataTables -->
<script src="/adminlte/plugins/datatables/jquery.dataTables.js"></script>
<script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="/adminlte/plugins/dropify/dist/js/dropify.min.js"></script>
<script src="{{asset('/assets/js/custom.js')}}"></script>
<script src="{{asset('assets/js/jquerydatetimepickerfull.js')}}"></script>
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>

<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
          alwaysShowClose: true
        });
    });
    // Summernote
    // $('.textarea').summernote();
    $('#lfm').filemanager('file');
    $('.textarea').summernote({
        height: 100,
        width:'100%',
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link']],
          ['view', ['fullscreen', 'codeview']],
        ]
    });

    //Initialize Select2 Elements
    $('.select2').select2();
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    });

    //Date range picker
    $('#reservation').daterangepicker();

    // // Date picker
    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      uiLibrary: 'bootstrap4',
    });

    bsCustomFileInput.init();

    // $('.toastrDefaultSuccess').click(function() {
    //   toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    // });
    // $('.toastrDefaultInfo').click(function() {
    //   toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    // });
    // $('.toastrDefaultError').click(function() {
    //   toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    // });
    // $('.toastrDefaultWarning').click(function() {
    //   toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    // });

    // Basic
    $('.dropify').dropify();

    // Translated
    $('.dropify-fr').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove: 'Supprimer',
            error: 'Désolé, le fichier trop volumineux'
        }
    });

    // Used events
    var drEvent = $('#input-file-events').dropify();

    drEvent.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });

    drEvent.on('dropify.errors', function(event, element) {
        console.log('Has Errors');
    });

    var drDestroy = $('#input-file-to-destroy').dropify();
    drDestroy = drDestroy.data('dropify')
    $('#toggleDropify').on('click', function(e) {
        e.preventDefault();
        if (drDestroy.isDropified()) {
            drDestroy.destroy();
        } else {
            drDestroy.init();
        }
    });

  });


  var remove = document.querySelector('.draggable');
function dragStart(e) {
  dragSrcEl = this;
  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.innerHTML);
};
 
function dragEnter(e) {
  this.classList.add('over');
}
 
function dragLeave(e) {
  e.stopPropagation();
  this.classList.remove('over');
}
 
function dragOver(e) {
  e.preventDefault();
  e.dataTransfer.dropEffect = 'move';
  return false;
}
 
function dragDrop(e) {
  if (dragSrcEl != this) {
    dragSrcEl.innerHTML = this.innerHTML;
    this.innerHTML = e.dataTransfer.getData('text/html');
  }
  return false;
}
 
function dragEnd(e) {
  var listItens = document.querySelectorAll('.draggable');
  [].forEach.call(listItens, function(item) {
    item.classList.remove('over');
    item.style.opacity = '1';
  });
  
}
  function addEventsDragAndDrop(el) {
    el.addEventListener('dragstart', dragStart, false);
    el.addEventListener('dragenter', dragEnter, false);
    el.addEventListener('dragover', dragOver, false);
    el.addEventListener('dragleave', dragLeave, false);
    el.addEventListener('drop', dragDrop, false);
    el.addEventListener('dragend', dragEnd, false);
  }
   
  var listItens = document.querySelectorAll('.draggable');
  [].forEach.call(listItens, function(item) {
    addEventsDragAndDrop(item);
  });
</script>

@stack('scripts')

</body>
</html>
