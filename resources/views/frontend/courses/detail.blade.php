@extends('layouts.app')

@section('title'){!! $course->course_name." -" !!} @stop

@push('styles')
{{-- <link rel="stylesheet" href="//unpkg.com/videojs-wavesurfer/dist/css/videojs.wavesurfer.min.css"> --}}
<link href="http://vjs.zencdn.net/5.0.2/video-js.css" rel="stylesheet">

{{-- chating start --}}
{{-- styles --}}
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>
<link href="{{ asset('css/chatify/style.css') }}" rel="stylesheet" />
<link href="{{ asset('css/chatify/light.mode.css') }}" rel="stylesheet" />
{{-- chating end --}}

<link href="{{ asset('assets/fullcalendar/main.min.css') }}" rel="stylesheet" />
<script src="{{ asset('assets/fullcalendar/main.min.js') }}"></script>

{{-- <script src="//unpkg.com/videojs-wavesurfer/dist/videojs.wavesurfer.min.js"></script> --}}

    <style>
        .module-card {
            color: #3b3b3b;
            line-height: 1.7;
            border-radius: 5px;
            background-color: #edeff7;
            margin-top: 5px;
            padding: 10px;
            
        }
        .clickevent {
            cursor: pointer;
        }
        .module-input{
            border: 1px solid #ccc;
            outline: none;
            padding: 5px;
            margin-bottom: 5px;
            width: 90%;
        }
        .module-input:focus{
            outline: none;
        }
        .lesson-input{
            border: 1px solid #ccc;
            outline: none;
            padding: 5px;
            width: 80%;
        }
        .lesson-input:focus{
            outline: none;
        }
        .btngroup {
            align-self: center
        }
        .addlessonbytype{
            cursor: pointer;
            box-shadow: -5px 10px 5px -1px rgba(194,197,209,1);
            margin-bottom: 1em;
        }

        /* Style the tab */
        .tab {
        width: 100%;
        }
        .tab button {
            border: none;
            outline: none;
            text-align: left;
            width: 100%;
            font-size: 16px;
            border-radius: 0;
            cursor: auto;
            user-select: text;
            
        }
        .tab button:hover {
        background-color: #ddd;
        }
        .tab button.active {
        background-color: #123760 !important;
        }
        .tab button.active > div > span {
            color:#fff;
        }
        .tab button.active > div > .dragIcon {
            color:#fff;
        }
        .psmModalHeader {
            background: rgba(1,1,209, 0.5);
        }
        .psmIcon {
            font-size: 24px;
            color: #6cb2eb;
            margin-bottom: 5px;
        }
        .dragIcon{
            cursor: pointer;
            color: #000;
        }
        .lessondragIcon{
            cursor: pointer;
            color: #000;
        }
        .fileIcon {
            font-size: 1.5em;
        }

        iframe {
            width: 100%;
            height: 250px;
        }
        button:focus{
            outline: none;
            box-shadow: none !important;
        }
        
        .exam_wrapper.hide {
            display: none;
        }
        .player-container{
            position: relative;
        }
        .controls-group {
            position: absolute;
            top: 45%;
            z-index: 100;
        }
        .controlIcon {
            font-size: 2em;
        }
        .vjs-big-play-button {
            z-index: 1000 !important;
        }
        
        .accordion>.card {
            overflow: auto;
        }
        .course-breadcrumb a, .course-breadcrumb span {
            font-size: .9rem;
        }
        .showMore{
            cursor: pointer;
        }

        .bar-wrapper {
            height: 300px;
            position: relative;
        }
        .bar {
            position: relative;
            bottom: 0;
            width: 5px;
            display: inline-block;
            border: 1px solid red;
            height: 5px;
            border-bottom: 3px solid #fff;
        }
        #audiocanvas {
            background: #000;
        }
        .leftSection {
            left: 0;
            transition: All 0.5s ease;
        }
        .leftSection.hide {
            left: -100%;
        }
        .btn-learning-duration {
            padding-top: 0.375rem;
            padding-bottom: 0.375rem;
            background-color: #123760;
            border-radius: 0;
            color: #fff;
        }
        .btn-learning-duration:hover {
            color: #fbb700;
        }

        #calendar-container {
            height: 400px;
            width: 100%;
        }
        #noteModal .modal-body {
            min-height: 400px;
            background-color: #f7f7f7;
        }
        #noteModal .note-tab-wrapper .col-9 {
            min-height: 400px;
            background-color: #fff;
        }
        .modal-header.psmModalHeader {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        .note-tab-wrapper .col-9 {
            padding-left: .5rem;
            padding-right: .5rem;
        }
        .note-tab-wrapper #v-pills-tab {
            background-color: #fff;
        }
        .note-tab-wrapper #v-pills-tabContent {
            background-color: #fff;
            padding-left: .5rem;
            padding-right: .5rem;
            padding-top: .7rem;
        }
        /* .tab-content>.tab-pane,
        .tab-content .description-wrapper>.tab-pane {
            display: none;
        } */

    </style>
@endpush
@section('content')
<div class="container main-content-bg course-detail-page">
     
    <div class="row">
        <div class="col-md-12">
          @include('flash::message')
        </div>
    </div>

    <div class="row mb-4 justify-content-center shortcut-icon-wrapper">
        
        <div class="col-md-3 col-sm-3 col-3 d-flex justify-content-center icon-group">

            @include('frontend.chating.chat_box')

            <a href="#" class="shortcut-icon text-center" id="open-chat-box">
                <img src="{{asset('/assets/images/chat.png')}}" alt="Chat" height="40px"> <br>
                CHAT
            </a>
        </div>
        <div class="col-md-3 col-sm-3 col-3 d-flex justify-content-center icon-group">
            <a href="#" class="shortcut-icon text-center" id="calendar-btn" data-toggle="modal" data-target="#calendarModal">
                <img src="{{asset('/assets/images/calendar.png')}}" alt="Calendar" height="40px"> <br>
                CALENDAR
            </a>
        </div>
        <div class="col-md-3 col-sm-3 col-3 d-flex justify-content-center icon-group">
            <a href="#" class="shortcut-icon text-center" data-toggle="modal" data-target="#noteModal">
                <img src="{{asset('/assets/images/note.png')}}" alt="Note" height="40px"> <br>
                NOTE
            </a>
        </div>
    </div>
      
    <div class="row action-btn-wrapper mb-3">
        <div class="col-12 text-right">
           
            @can('list')
            <a href="{{url('admin/batch_groups/'.$course->id)}}" class="btn btn-warning">Batch Group</a>
            {{-- <a href="{{url('admin/batch_groups/create/'.$course->id)}}" class="btn btn-warning">Batch Group Create</a> --}}

            <a href="{{url('question_group_names?course_id='.$course->id)}}" class="btn btn-info">Question Group</a>
            <a href="{{url('question_group_names/create?course_id='.$course->id)}}" class="btn btn-info">New Question Group</a>
            
            <a href="{{url('courses/enrol-users/'.$course->id)}}" class="btn btn-primary">Student List</a>
            <button class="btn btn-primary" data-toggle="modal" data-target="#enrolUser">Enrol User</button>
            {{-- <button class="btn btn-primary brand-btn-color" data-toggle="modal" data-target="#enrolUser">Enrol User</button> --}}
            @endcan
        </div>
    </div>

    <div class="card course-content border-0">
        <div class="card-header bg-brand text-white main-course-header">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-6">
                    <h5 class="course-content-title mb-0">Course <br> Content</h5>
                </div>
                <div class="col-md-3 col-sm-3 col-6 text-center">
                   <div>
                     @if ($course->start_date)
                     Course start date:{{date('d M Y',strtotime($course->start_date))}}
                     @endif
                     {{-- Category: {{$course->category->name}} --}}
                   </div>
                </div>
                <div class="col-md-7 col-sm-7 col-12 text-right course-breadcrumb align-self-center">
                    @if(Request::is('courses*'))
                    <a href="{{url('/home')}}">Home</a> / <a href="{{url('/courses')}}">Courses</a> / <a href="{{url('/courses/detail/'.$course->slug)}}">{{$course->course_name}}</a> / <span class="course_module_name"></span>
                    @endif
                    @if(Request::is('my_courses*'))
                    <a href="{{url('/home')}}">Home</a> / <a href="{{url('/my_courses')}}">My Courses</a> / <a href="{{url('/my_courses/detail/'.$course->slug)}}">{{$course->course_name}}</a> / <span class="course_module_name"></span>
                    @endif
                </div>
            </div>


        </div>
        <div class="card-body course-content-body">
        <input type="hidden" id="firstModuleName" value="{{ count($modules) > 0 ? $modules[0]->name : ''}}">
        <div class="row">
            <div class="col">
                <button type="button" class="btn btn-success mb-1" style="background:#123760;border-radius:0;" value="0" id="show_hide_menu" onclick="showHideLeftMenu()"><i class="fas fa-align-left showHideMenuIcon"></i></button>
            </div>
            @if(auth()->user()->role == "Student" || auth()->user()->switch_role == "Student")
            <div class="col text-right">
                <a href="{{url('/durations_list/'.$course->id.'/'.auth()->user()->id)}}" class="btn btn-sm btn-learning-duration">Learning Hours</a>
            </div>
            @endif

        </div>
        
            <div class="row lesson-wrapper">
                <div class="col-md-5 leftSection hide">
                    @can('list')
                    <div class="text-right mb-2">
                        <button class="btn btn-success btn-md" data-toggle="modal" data-target="#topicModal"><i class="fas fa-plus"></i>Add Topic</button>
                    </div>
                    @endcan
                <div class="tab" id="{{auth()->user()->role != "Student" ? 'modulesortable' : ''}}">
                        @foreach ($modules as $module)
                        @if(auth()->user()->role == "Student" || auth()->user()->switch_role == "Student")
                            @if($module->is_active == 1)

                            <button class="tablinks mb-2 p-2" tabindex="1" onclick="openTab(event,'moduleTab{{$module->id}}',{{$module->id}}, '{{$module->name}}')" id="defaultOpen">
                               <div class="module{{$module->id}}">
                                @can('list')
                                <i class="fas fa-arrows-alt dragIcon"></i>
                                @endcan
                                <input type="hidden" name="module_order[]" value="{{$module->id}}">
                                <span id="origin_module_name{{$module->id}}">{{$module->name}}</span> <span class="clickevent" onclick="chnageEditMode({{$module->id}})"></span>
                               </div>
                               <div class="module-edit{{$module->id}} d-none">
                                <input type="text" autocomplete="off" class="module-input" onkeypress="saveByEnter({{$module->id}})" value="{{$module->name}}" name="module" id="module_name{{$module->id}}">
                                    <span class="clickevent" onclick="saveModule({{$module->id}})"><i class="fas fa-save"></i></span>
                                    <span class="clickevent" onclick="cancelEdit({{$module->id}})"><i class="fas fa-times"></i></span>
                                </div>
                                {{-- @can('list')
                                <div class="text-right btngroup">
                                    <a onclick="hideModule({{$module->id}})" id="active-module-control{{$module->id}}" class="btn btn-sm btn-light"><i class="{{$module->is_active ? 'fas fa-eye text-primary' : 'fas fa-eye-slash text-muted' }}"></i></a>
                                    
                                    <a onclick="chnageEditMode({{$module->id}})" class="btn btn-sm btn-warning><i class="fas fa-edit"></i></a>
                                    <a onclick="deleteModule({{$module->id}})" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a>
                                <form action="{{ route('course_modules.destroy', $module->id) }}" method="post" style="display: none;" class="deleteModuleDataForm{{$module->id}}">
                                        @csrf
                                        @method('DELETE')
                                </form>
                                </div>
                                @endcan --}}
                            </button>

                            @endif
                        @else
                            @if(auth()->user()->role != "Student" || auth()->user()->switch_role != "Student")
                            <button class="tablinks mb-2 p-2 {{Request::get('module_id') == $module->id ? 'active' : ''}}" onclick="openTab(event,'moduleTab{{$module->id}}',{{$module->id}}, '{{$module->name}}')" id="defaultOpen">
                                <div class="module{{$module->id}}">
                                @can('list')
                                <i class="fas fa-arrows-alt dragIcon"></i>
                                @endcan
                                <input type="hidden" name="module_order[]" value="{{$module->id}}">
                                <span id="origin_module_name{{$module->id}}">{{$module->name}}</span> <span class="clickevent" onclick="chnageEditMode({{$module->id}})"></span>
                                </div>
                                <div class="module-edit{{$module->id}} d-none">
                                <input type="text" autocomplete="off" class="module-input" onkeypress="saveByEnter({{$module->id}})" placeholder="{{(substr($module->name, 0, 5 ) == "Unit-") ? $module->name : '' }}" value="{{(substr($module->name, 0, 5 ) == "Unit-") ? '' : $module->name }}" name="module" id="module_name{{$module->id}}">
                                    <span class="clickevent" onclick="saveModule({{$module->id}})"><i class="fas fa-save"></i></span>
                                    <span class="clickevent" onclick="cancelEdit({{$module->id}})"><i class="fas fa-times"></i></span>
                                </div>
                                @can('list')
                                <div class="text-right btngroup">
                                    <a onclick="hideModule({{$module->id}})" id="active-module-control{{$module->id}}" class="btn btn-sm btn-light"><i class="{{$module->is_active ? 'fas fa-eye text-primary' : 'fas fa-eye-slash text-muted'}}"></i></a>
                                    {{-- <a href="/admin/course_modules/{{$module->id}}/edit" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a> --}}
                                    <a onclick="chnageEditMode({{$module->id}})" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <a onclick="deleteModule({{$module->id}})" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a>
                                <form action="{{ route('course_modules.destroy', $module->id) }}" method="post" style="display: none;" class="deleteModuleDataForm{{$module->id}}">
                                        @csrf
                                        @method('DELETE')
                                </form>
                                </div>
                                @endcan
                            </button>
                            @endif
                        @endif
                        @endforeach
                        
                    </div>
                    @can('list')
                    <div class="text-right mt-2">
                        <button class="btn btn-success btn-md" data-toggle="modal" data-target="#topicModal"><i class="fas fa-plus"></i>Add Topic</button>
                    </div>
                    @endcan
                </div>
                @include('frontend.courses.moduleList')
            </div>
        </div>
    </div>

    <div class="bottom-bg-wrapper">
        <img src="{{asset('/assets/images/mycourse-bottom-bg.png')}}" alt="Courses Background Image">
    </div>

            <input type="hidden" id="selected_course_id" value="{{$course->id}}">
            <input type="hidden" id="selected_module_id" value="">
            <div class="modal fade" id="lessonModal" tabindex="-1" aria-labelledby="lessonModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <form action="/admin/course_modules" method="post">
                    @csrf
                  <div class="modal-content">
                    <div class="modal-header psmModalHeader">
                      <h5 class="modal-title text-white" id="lessonModalLabel">Add an activity or resource</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="card text-center p-3 addlessonbytype" onclick="addLessonByType('lessons')">
                                    <i class="psmIcon fas fa-book"></i>
                                 <strong>Lessons</strong> 
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card text-center p-3 addlessonbytype" onclick="addLessonByType('file')">
                                    <i class="psmIcon fas fa-file-alt"></i>
                                    <strong> File</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-center p-3 addlessonbytype" onclick="addLessonByType('url')">
                                    <i class="psmIcon fas fa-link"></i>
                                    <strong>URL</strong>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                                <div class="col-md-4">
                                    <div class="card text-center p-3 addlessonbytype" onclick="addLessonByType('zoom')">
                                        <i class="psmIcon fas fa-video"></i>
                                        <strong>Zoom Meeting</strong>
                                    </div>
                                </div>
                            <div class="col-md-4">
                                <div class="card text-center p-3 addlessonbytype" onclick="addLessonByType('exam')">
                                    <i class="psmIcon fab fa-quora"></i>
                                    <strong>Exam</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-center p-3 addlessonbytype" onclick="addLessonByType('assignment')">
                                    <i class="psmIcon fas fa-file-invoice"></i>
                                    <strong>Assignment</strong>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-center p-3 addlessonbytype" onclick="addLessonByType('text_and_image')">
                                    <i class="psmIcon fas fa-images"></i>
                                    <strong>Text & Image</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-center p-3 addlessonbytype" onclick="addLessonByType('certificate')">
                                    <i class="psmIcon fas fa-graduation-cap"></i>
                                    <strong>Certificate</strong>
                                </div>
                            </div>
                        </div>


                    </div>
                  </div>
                </form>
                </div>
            </div>

              
            
            <div class="modal fade" id="topicModal" tabindex="-1" aria-labelledby="topicModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <form action="/admin/course_modules" method="post">
                    @csrf
                  <div class="modal-content">
                    <div class="modal-header psmModalHeader">
                      <h5 class="modal-title text-white" id="topicModalLabel">Add Topic</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                    <input type="hidden" name="course_id" value="{{$course->id}}">
                            <div class="form-group">
                                <label for="">Number of Topics</label>
                                <input type="number" name="count" id="count" min="1" value="10" class="form-control">
                            </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Save changes</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </form>
                </div>
            </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="enrolUser" role="dialog" aria-labelledby="enrolUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header psmModalHeader">
            <h5 class="modal-title text-white" id="enrolUserLabel">Enrol User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
            {!! Form::open(['route' => 'enrol-user.store', 'method'=>'POST', 'id'=>'enrol_form']) !!}
            <input type="hidden" name="course_id" value="{{$course->id}}">
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-8 col-12">
                    <div class="form-group">
                        <label for="enrole_users" >Select Users *</label>
                        {{-- {!! Form::select('enrole_users[]', $users, old('enrole_users'), ['class'=>'form-control','id'=>'enrole_users','multiple'=>"multiple", 'required'=>true]) !!} --}}
                        <select name="enrole_users[]" id="enrole_users" class="form-control" multiple="multiple" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}} - {{$user->email}}</option>
                            @endforeach
                            @foreach($user_course_groups as $group)
                                <option value="{{$group->id}}-group">{{$group->course_name}} - ({{count($group->enrolUser)}})</option>
                            @endforeach
                            <option value="all">All Student</option>
                        </select>
                    </div>
                </div>
            </div>

            @if(count($batch_groups) > 0)
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-8 col-12">
                    <div class="form-group">
                        <label for="enrole_users" >Select Batch Group *</label>
                        {!! Form::select('batch_group_id', $batch_groups, old('batch_group_id'), array('class' => 'form-control', 'placeholder'=>'','id'=>'batch_group_id','required'=>true)) !!}
                    </div>
                </div>
            </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-8 col-12">
                    <div class="form-group">
                        <label for="is_limited">
                            <input type="checkbox" name="is_limited" id="is_limited"> Time Limit
                        </label>
                    </div>
                </div>
            </div>
            <div class="dateGroup d-none">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-sm-8 col-12">
                        <div class="form-group">
                            <label for="start_date">Start Date Time:</label>
                            {!! Form::text('start_date', null, ['placeholder' => 'Start Date','class' => 'form-control psmdatetimepicker1','autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-sm-8 col-12">
                        <div class="form-group">
                            <label for="time_limit">Time limit</label>
                            <div class="d-flex">
                                <input type="number" style="width:40%;" min="0" name="time_limit" value="" placeholder="Time Limit" id="time_limit" class="form-control mr-2">
                                <select name="time_type" style="width:30%;" id="time_type" class="form-control">
                                    @foreach (config('time_type.type') as $timekey =>  $timetype)
                                        <option value="{{$timekey}}">{{$timetype}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-sm-8 col-12">
                        <div class="form-group">
                            <label for="end_date">End Date Time:</label>
                            {!! Form::text('end_date', null, ['placeholder' => 'End Date','class' => 'form-control end_date_time', 'readonly'=>true, 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-md-3"></div>
                <div class="col-md-8 text-right">
                    <button type="submit" class="btn btn-primary">Enrol Users</button>
                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
                
            </div>

            {!! Form::close() !!}
        </div>
        
        </div>
    </div>
    </div>
    {{-- End Modal --}}

    {{-- Question Modal --}}
    <div class="modal fade" id="newQuestionModal" role="dialog" aria-labelledby="newQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header psmModalHeader">
                <h3 class="modal-title text-white" id="newQuestionModalLabel">A New Question</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            
            <div class="modal-body text-center">
                <form action="{{url('/admin/questions/create')}}" method="get">
                    <input type="hidden" name="course_id" id="course_id" value="{{$course->id}}">
                    <input type="hidden" name="module_id" id="module_id">
                    <input type="hidden" name="exam_id" id="exam_id">

                    <h4 class="mb-4">Choose Question Type</h4>
                    <div class="form-group mb-4">
                        <label for="multiple_choice" class="px-2"> <input type="radio" class="question_type" name="question_type" id="multiple_choice" value="multiple_choice" checked> Multiple Choice</label>
                        <label for="true_false" class="px-2"> <input type="radio" class="question_type" name="question_type" id="true_false" value="true_false"> True/False</label>
                        {{-- <label for="matching" class="px-2"> <input type="radio" class="question_type" name="question_type" id="matching" value="matching"> Matching </label> --}}
                    </div>
    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-5" id="select_question_type">Select</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
        </div>
    {{-- End Question Modal --}}
    
    {{-- Note --}}
    <div class="modal fade" id="noteModal" role="dialog" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header psmModalHeader">
                <h3 class="modal-title text-white" id="newQuestionModalLabel">Note Listing</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-3"></div>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-6 text-left">
                                <button class="btn btn-success btn-sm" id="new_note">New Note</button>
                            </div>
                            <div class="col-6 text-right">
                                <button class="btn btn-primary btn-sm" id="save_note" disabled>Save Note</button>
                                {{-- <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#noteCreateModal">Add New Note</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row note-tab-wrapper">
                    <div class="col-3">
                      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($notes as $key=>$note)
                            <a class="nav-link" id="v-pills-{{$note->id}}-tab" data-id="{{$note->id}}" data-toggle="pill" href="#v-pills-{{$note->id}}" role="tab" aria-controls="v-pills-{{$note->id}}" aria-selected="true"> 
                                {{ Str::limit($note->note_description, 30, $end='...') }}
                            </a>
                        @endforeach
                      </div>
                    </div>
                    <div class="col-9">
                      <div class="tab-content" id="v-pills-tabContent">
                        @foreach($notes as $key=>$note)
                        <div class="tab-pane fade" id="v-pills-{{$note->id}}" role="tabpanel" aria-labelledby="v-pills-{{$note->id}}-tab">
                            <div class="note-description d-inline-block mr-4">{{ $note->note_description }}</div>
                            <div class="note-action d-inline-block text-right">
                                <button class="btn btn-outline-warning btn-sm note-edit" onClick="noteEdit({{$note->id}})"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-outline-danger btn-sm note-delete" onClick="noteDelete({{$note->id}})"><i class="fas fa-times"></i></button>
                            </div>

                            <div class="note-edit-wrapper edit-row-{{$note->id}} d-none">
                                <textarea name="note_description_{{$note->id}}" id="note_description_{{$note->id}}" class="form-control mb-2 edit-note" rows="5"> {{$note->note_description}} </textarea>
                                <div class="update-note"> <button class="btn btn-primary btn-sm update-btn" onClick="updateNote({{$note->id}})">Update Note</button> </div>
                            </div>
                        </div>
                        @endforeach
                        {{-- <div class="description-wrapper">
                            
                        </div> --}}
                        <div class="tab-pane fade" id="v-pills-0" role="tabpanel" aria-labelledby="v-pills-0-tab">
                            <textarea name="note_description_0" id="note_description_0" class="form-control" rows="5" placeholder="Enter Your Note"></textarea>
                        </div>
                      </div>
                    </div>
                </div>

            </div>
            
            </div>
        </div>
    </div>
    <div class="modal fade" id="noteCreateModal" role="dialog" aria-labelledby="noteCreateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header psmModalHeader">
                <h3 class="modal-title text-white" id="noteCreateModalLabel">Create Note</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <form action="{{route('notes.store')}}" method="post">
                    @csrf

                    <input type="hidden" name="course_id" id="course_id" value="{{$course->id}}">
                    <input type="hidden" name="module_id" id="module_id">
                    
                    <div class="form-group">
                        <label for="note_title">Title</label>
                        <input type="text" name="note_title" id="note_title" class="form-control" placeholder="Note Title" required>
                    </div>
                    <div class="form-group">
                        <label for="note_description">Description</label>
                        <textarea name="note_description" id="note_description" class="form-control psmeditor" rows="5" placeholder="Note Description"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary btn-sm">Save</button>
                        <button class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
    </div>
    {{-- End Question Modal --}}

    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              {{-- <h5 class="modal-title" id="calendarModalLabel">Modal title</h5> --}}
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div id='calendar-container'>
                    <div id='calendar'></div>
                </div>
            </div>
            
          </div>
        </div>
    </div>

    {{-- @include('frontend.chating.chat_box') --}}
    @include('frontend.chating.message_box', ['users'=>$enrol_users,'group'=>$group])

@endsection
@push('scripts')
{{-- Start Chating --}}
{{-- <script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script> --}}
<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>
{{-- End Chating --}}

<script src="http://vjs.zencdn.net/ie8/1.1.0/videojs-ie8.min.js"></script>
<script src="http://vjs.zencdn.net/5.0.2/video.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>

    <script>
    $(document).ready(function() {

        var module_name = $('#firstModuleName').val();
        $(".course_module_name").text(module_name);
        $("input[name='videoids[]']").each(function() {
            videojs('myPlayer'+$(this).val());
        });
        
        $("#enrole_users").select2({
            theme: 'bootstrap4',
            placeholder: "Select Users"
        });
        $("#duration").select2({
            theme: 'bootstrap4',
            placeholder: "Select Duration"
        });
        
        $('.psmdatetimepicker1').datetimepicker();

        $('.psmeditor').summernote({
            height: 150,
            width:'100%',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
        // $("#start_exam").click(function() {
        //     var agree = confirm("Are you sure start exam?");
        //     if(agree) {
        //         location.href = "";
        //     }
        // });
    });

    // Start Note Fnction
    $(".note-tab-wrapper .nav-link").click(function() {
        $("#v-pills-0").removeClass('show active');

        var note_id = $(this).attr('data-id');
        
        $("#v-pills-tabContent .tab-pane").removeClass('show active');
        $("#v-pills-"+note_id).addClass('show active');

        $(".tab-pane .note-description").removeClass('d-none').removeClass('d-inline-block').addClass('d-inline-block');
        $(".tab-pane .note-action").removeClass('d-none').removeClass('d-inline-block').addClass('d-inline-block');
        $(".note-edit-wrapper").removeClass('d-none').addClass('d-none');
    });

    $("#new_note").on('click', function() {
        $("#v-pills-tabContent .tab-pane").removeClass('show active');
        $("#v-pills-tabContent #v-pills-0").addClass('show active');
        $("#save_note").removeAttr('disabled','disabled');
    });

    $("#save_note").on('click', function() {

        var course_id = $("#selected_course_id").val();
        var note_description = $("#note_description_0").val();

        if(note_description != '') {
            $.ajax({
                type:'POST',
                url: "{{url('notes')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    course_id : course_id,
                    note_description : note_description,
                },
                success: (response) => {
                    if(response.status == 200) {
                        console.log(response.note);
                        var note = response.note;
                        $("#v-pills-tabContent").prepend(
                            '<div class="tab-pane fade show active" id="v-pills-'+note.id+'" role="tabpanel" aria-labelledby="v-pills-'+note.id+'-tab">'+
                            note.note_description +   
                            '</div>'
                        );

                        $("#v-pills-tab").prepend(
                            '<a class="nav-link" id="v-pills-'+note.id+'-tab" data-toggle="pill" href="#v-pills-'+note.id+'" role="tab" aria-controls="v-pills-'+note.id+'" aria-selected="true">'+
                                response.short_note +
                            '</a>'
                        );

                        $("#v-pills-tabContent #v-pills-0").removeClass('show active');
                        $("#save_note").attr('disabled','disabled');

                        $("#note_description_0").val('');
                        $("#note_description_0").focus();
                    }
                },
                error: function(response){
                    console.log('Error! '+response.responseJSON.errors);
                }
            });
        }else {
            alert('Please input note description.');
            $("#note_description_0").focus();
        }

    });

    function noteEdit(note_id)
    {
        $("#v-pills-"+note_id+" .note-description").addClass('d-none').removeClass('d-inline-block');
        $("#v-pills-"+note_id+" .note-action").addClass('d-none').removeClass('d-inline-block');
        $(".edit-row-"+note_id).removeClass('d-none');
    }

    function updateNote(note_id)
    {
        var note_description = $("#note_description_"+note_id).val();

        if(note_description != '') {
            $.ajax({
                type:'PATCH',
                url: "/notes/"+note_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    note_description : note_description,
                },
                success: (response) => {
                    if(response.status == 200) {
                        console.log(response.note);
                        var note = response.note;

                        $("#v-pills-"+note.id+"-tab").html(response.short_note);
                        $("#v-pills-"+note.id+" .note-description").html(note.note_description);
                        $("#note_description_"+note.id).val(note.note_description);

                        $("#v-pills-"+note_id+" .note-description").removeClass('d-none').addClass('d-inline-block');
                        $("#v-pills-"+note_id+" .note-action").removeClass('d-none').addClass('d-inline-block');

                        $(".edit-row-"+note_id).addClass('d-none');
                        
                    }
                },
                error: function(response){
                    console.log('Error! '+response.responseJSON.errors);
                }
            });
        }else {
            alert('Please input note description.');
            $("#note_description_"+note_id).focus();
        }
    }
    
    function noteDelete(note_id)
    {
        var result = confirm("Are you sure delete?");

        if(result) {
            $.ajax({
                type:'DELETE',
                url: "/notes/"+note_id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: (response) => {
                    if(response.status == 200) {

                        $("#v-pills-"+note_id+"-tab").remove();
                        $("#v-pills-"+note_id).remove();
                        
                    }
                },
                error: function(response){
                    console.log('Error! '+response.responseJSON.errors);
                }
            });
        }
    }
    // End Note Function

    $("#calendar-btn").on('click', function() {
        setTimeout(() => {
            $('.fc-dayGridMonth-button').trigger('click');
        }, 200);
    });

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            height: '100%',
            expandRows: true,
            slotMinTime: '08:00',
            slotMaxTime: '20:00',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
                // right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            initialView: 'dayGridMonth',
            // initialDate: new Date(),
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            selectable: true,
            nowIndicator: true,
            dayMaxEvents: true, // allow "more" link when too many events

        });

        calendar.render();
    });
    

    $(function () {
 $('#modulesortable').sortable({
    handle: '.dragIcon',
    cancel: '',
    connectWith: '.tab',
    update: function (event, ui) {
        let values = [];
        $("input[name='module_order[]']").each(function() {
            values.push($(this).val());
        });
        console.log(values);
        $.ajax({
            type:"get",
            url:"/save-module-order",
            data:{list:values},
            success:function(response){
                if (response.success) {
                    
                }
            }
        })
    }
});
$('#modulesortable').disableSelection();


            $('.lessonSortable').sortable({
                handle:'.lessondragIcon',
                cancel: '',
                update: function (event, ui) {
                    const id = $(this).data("id");
                    let values = [];
                    $("input[name='lesson_order"+id+"[]']").each(function() {
                        values.push($(this).val());
                    });
                    $.ajax({
                        type:"get",
                        url:"/save-lesson-order",
                        data:{list:values},
                        success:function(response){
                            if (response.success) {
                                
                            }
                        }
                    })
                }
            });
            $('.lessonSortable').disableSelection();

    });

        var module_name = "";
        var lesson_name = "";
        function saveModule(id){
            saveModuleAjax(id);
        }


        function allPlayerPause(lesson_id){
            $("input[name='videoids[]']").each(function() {
                if(lesson_id != $(this).val()){
                    const myVideoPlayer = videojs('myPlayer'+$(this).val());
                    myVideoPlayer.pause();
                }

            });
        }
        function saveModuleAjax(id){
            const name =  $('#module_name'+id).val();
            
            $('#header_module_name'+id).html(name);
            $('#origin_module_name'+id).html(name);
            $('#module_name'+id).val(name);
            $('.module'+id).removeClass('d-none');
            $('.module-edit'+id).addClass('d-none');

            $.ajax({
                type: 'PATCH',
                url:`/admin/course_modules/${id}`,
                data: {name: name,type:'ajax','_token':getToken()},
                success : function(response){
                   if (response.code == 200) {
                    //    $('#header_module_name'+id).html(name);
                    //    $('#origin_module_name'+id).html(name);
                    //    $('#module_name'+id).val(name);
                    //    $('.module'+id).removeClass('d-none');
                    //    $('.module-edit'+id).addClass('d-none');
                   }
                }
                
            })
        }
        function saveByEnter(id){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                saveModuleAjax(id);
            }
        }
        function saveLessonByEnter(id){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                saveLessonAjax(id);
            }
        }

        function saveLesson(id){
            saveLessonAjax(id)
        }


        function saveLessonAjax(id){
            const name =  $('#lesson_name'+id).val();
            $.ajax({
                type: 'PATCH',
                url:`/admin/lessons/${id}`,
                data: {name: name,type:'ajax','_token':getToken()},
                success : function(response){
                   if (response.code == 200) {
                       $('#lesson_name'+id).val(name);
                       $('#origin_lesson_name'+id).html(name)
                       $('.lesson'+id).removeClass('d-none')
                       $('.lesson-edit'+id).addClass('d-none')
                   }
                }
                
            })
        }
        function cancelEdit(id){
            $('#module_name'+id).val(module_name);
            $('.module'+id).removeClass('d-none')
            $('.module-edit'+id).addClass('d-none')
        }
        function chnageEditMode(id){
            module_name = $('#module_name'+id).val();
            $('.module'+id).addClass('d-none')
            $('.module-edit'+id).removeClass('d-none')
        }

        function cancelLessonEdit(id){
            $('#lesson_name'+id).val(lesson_name);
            $('.lesson'+id).removeClass('d-none')
            $('.lesson-edit'+id).addClass('d-none')
        }
        function chnageLessonEditMode(id){
            lesson_name = $('#lesson_name'+id).val();
            $('.lesson'+id).addClass('d-none')
            $('.lesson-edit'+id).removeClass('d-none')
        }
        function getToken(){
          return  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }


        function hideLesson(id){
            $.ajax({
            url:`/admin/lesson-active/${id}`,
            type:'GET',
            success: function(response){
                if (response.code == 200) {
                const inactiveHtml = "<i class='fas fa-eye-slash text-muted'></i>";
                const activeHtml = "<i class='fa fa-eye text-primary'></i>";
                $('#active-lesson-control'+id).html("");
                if(response.status){
                    $('#active-lesson-control'+id).html(activeHtml);
                }else{
                    $('#active-lesson-control'+id).html(inactiveHtml);
                }
                //   alert(response.message);
                
                }
            }
            })
        }



        function hideModule(id){
        $.ajax({
          url:`/admin/module-active/${id}`,
          type:'GET',
          success: function(response){
            if (response.code == 200) {
              const inactiveHtml = "<i class='fas fa-eye-slash text-muted'></i>";
              const activeHtml = "<i class='fa fa-eye text-primary'></i>";
              $('#active-module-control'+id).html("");
              if(response.status){
                $('#active-module-control'+id).html(activeHtml);
              }else{
                $('#active-module-control'+id).html(inactiveHtml);
              }
            //   alert(response.message);
             
            }
          }
        })
      }

      function deleteModule(id){
        var result = confirm("Confirm delete record?");
        if(result) {
            $('.deleteModuleDataForm'+id).submit();
        }
      }
      function deleteLesson(id){
        var result = confirm("Confirm delete record?");
        if(result) {
            $('.deleteLessonDataForm'+id).submit();
        }
      }
      function addLessonByType(type){
          console.log(type);
        const module_id = $('#selected_module_id').val();
        const course_id = $('#selected_course_id').val();

        if(type != 'exam') {
            location.href = '/admin/add-resource-by-type?course_id='+course_id+'&module_id='+module_id+'&type='+type;
        }else {
            location.href = '/admin/exams/create?course_id='+course_id+'&module_id='+module_id+'&type='+type;
        }
      }

      function setModuleId(id){
        $('#selected_module_id').val(id);
      }

      function saveModuleOrder(){
        let values = [];
        $("input[name='module_order[]']").each(function() {
            values.push($(this).val());
        });
        $.ajax({
            type:"get",
            url:"/save-module-order",
            data:{list:values},
            success:function(response){
                if (response.success) {
                    
                }
            }
        })
      }
      function openTab(evt, cityName,id, moduleName) {
        $(".course_module_name").text(moduleName);
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
            }
            
            // Get the element with id="defaultOpen" and click on it
            const mID = "{{Request::get('module_id')}}";
            if (!mID) {
                document.getElementById("defaultOpen").click();
            }

        // Exam
        var examname = "";
        function saveExamByEnter(id){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                saveExamAjax(id);
            }
        }

        function saveExam(id){
            saveExamAjax(id)
        }


        function saveExamAjax(id){
            const exam_name =  $('#exam_name_'+id).val();
            $.ajax({
                type: 'PATCH',
                url:`/admin/exams/${id}`,
                data: {exam_name: exam_name,type:'ajax','_token':getToken()},
                success : function(response){
                   if (response.code == 200) {
                       $('#exam_name_'+id).val(exam_name);
                       $('#origin_exam_name_'+id).html(exam_name)
                       $('.exam_'+id).removeClass('d-none')
                       $('.exam-edit-'+id).addClass('d-none')
                   }
                }
                
            })
        }

        function cancelExamEdit(id){
            $('#exam_name_'+id).val(examname);
            $('.exam_'+id).removeClass('d-none')
            $('.exam-edit-'+id).addClass('d-none')
        }
        function chnageExamEditMode(id){
            examname = $('#exam_name_'+id).val();
            $('.exam_'+id).addClass('d-none')
            $('.exam-edit-'+id).removeClass('d-none')
        }


        function previousVideo(module_id,lesson_id){
            const myPlayer = videojs('myPlayer'+lesson_id);
            let videoUrls = [];
            let videoTitles = [];
            let videoDescriptions = [];
            const currentVideo = $('#lessonVideo'+lesson_id).val();
            $("input[name='videoUrl"+module_id+"[]']").each(function() {
                videoUrls.push($(this).val());
            });
            $("input[name='videoTitle"+module_id+"[]']").each(function() {
                videoTitles.push($(this).val());
            });
            $("input[name='videoDescription"+module_id+"[]']").each(function() {
                videoDescriptions.push($(this).val());
            });
            // console.log(videoUrls);
            const currentIndex = videoUrls.indexOf(currentVideo);
            // console.log(currentIndex);
            if(currentIndex > 0 && currentIndex <= videoUrls.length-1){
                $('#lessonVideo'+lesson_id).val(videoUrls[currentIndex-1]);
                $('#lessonTitle'+lesson_id).html(videoTitles[currentIndex-1]);
                $('#lessonDescription'+lesson_id).html(videoDescriptions[currentIndex-1]);

                $('.lesson_title'+lesson_id).html(videoTitles[currentIndex-1]);

                setTimeout(function() {
                    myPlayer.src(videoUrls[currentIndex-1])
                    myPlayer.play();
                }, 0);
                
            }

        }
        function nextVideo(module_id,lesson_id){
            const myPlayer = videojs('myPlayer'+lesson_id);
            let videoUrls = [];
            let videoTitles = [];
            let videoDescriptions = [];

            const currentVideo = $('#lessonVideo'+lesson_id).val();
            $("input[name='videoUrl"+module_id+"[]']").each(function() {
                videoUrls.push($(this).val());
            });
            $("input[name='videoTitle"+module_id+"[]']").each(function() {
                videoTitles.push($(this).val());
            });
            $("input[name='videoDescription"+module_id+"[]']").each(function() {
                videoDescriptions.push($(this).val());
            });
            // console.log(videoUrls);
            const currentIndex = videoUrls.indexOf(currentVideo);
            // console.log('currentIndex'+currentIndex);
            if(currentIndex < videoUrls.length-1){
                $('#lessonVideo'+lesson_id).val(videoUrls[currentIndex+1]);
                $('#lessonTitle'+lesson_id).html(videoTitles[currentIndex+1]);
                $('#lessonDescription'+lesson_id).html(videoDescriptions[currentIndex+1]);

                $('.lesson_title'+lesson_id).html(videoTitles[currentIndex+1]);
                
                setTimeout(function() {
                    myPlayer.src(videoUrls[currentIndex+1])
                    myPlayer.play();
                }, 0);
            }
        }

        var play_id = "";
        var current_lesson_id = "";
        var current_module_id = "";
        var closeAfterSave = false;

        var myPlayer = '';

        function startPlay(course_id, module_id, lesson_id, play_type)
        {
            allPlayerPause(lesson_id);

            current_lesson_id = lesson_id;
            current_module_id = module_id;

            myPlayer = videojs('myPlayer'+lesson_id);

            // var isPlaying = myPlayer.currentTime > 0 && !myPlayer.paused && !myPlayer.ended && myPlayer.readyState > myPlayer.HAVE_CURRENT_DATA;
            var isPlaying = myPlayer.currentTime > 0 && !myPlayer.paused && !myPlayer.ended;
            
            if (closeAfterSave == false) {
                myPlayer.on('play', () => {
                        if(play_type == 'audio') {
                            $("#myPlayer"+lesson_id).attr("poster","/assets/images/vr.gif");
                            $("#myPlayer"+lesson_id+"_html5_api").attr("poster","/assets/images/vr.gif");
                            $("#myPlayer"+lesson_id+" .vjs-poster").removeClass('vjs-hidden');
                            $("#myPlayer"+lesson_id+" .vjs-poster").css('background-image', 'url("/assets/images/vr.gif")');
                        }

                        $.ajax({
                                type:'POST',
                                url: "{{url('start_lesson')}}",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: {
                                    course_id: course_id,
                                    module_id: module_id,
                                    lesson_id: lesson_id
                                },
                                success: (response) => {
                                    console.log(response);
                                    if(response) {
                                        play_id = response.playtime.id;
                                    }

                                    closeAfterSave = true;
                                },
                                    error: function(response){
                                    console.log('Error! '+response.responseJSON.errors);
                                }
                        });

                });
                
            }

            myPlayer.on('pause', () => { 
                    // console.log(play_id);
                    if(play_type == 'audio') {
                        $("#myPlayer"+lesson_id).attr("poster","/assets/images/vr.png");
                        $("#myPlayer"+lesson_id+"_html5_api").attr("poster","/assets/images/vr.png");
                        $("#myPlayer"+lesson_id+" .vjs-poster").css({'background':'url("/assets/images/vr.png") no-repeat center center','background-size':400});
                    }

                    $.ajax({
                            type:'POST',
                            url: "{{url('pause_lesson')}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                play_id: play_id,
                                course_id: course_id,
                                module_id: module_id,
                                lesson_id: lesson_id
                            },
                            success: (response) => {
                                console.log(response);

                                closeAfterSave = false;
                            },
                                error: function(response){
                                console.log('Error! '+response.responseJSON.errors);
                            }
                    });

                }); 

            if (myPlayer.readyState() < 1) {
                // do not have metadata yet so loadedmetadata event not fired yet (I presume)
                // wait for loadedmetdata event
                myPlayer.one("loadedmetadata", onLoadedMetadata);
            }
            else {
                // metadata already loaded
                onLoadedMetadata();
            }

        }

        function onLoadedMetadata() {
            // console.log("Duration "+myPlayer.duration());
            var lesson_duration = myPlayer.duration();

            $.ajax({
                url:'/save-video-duration',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:'POST',
                data: {
                    course_id : course_id,
                    course_module_id : current_module_id,
                    lesson_id : current_lesson_id,
                    lesson_duration : lesson_duration,
                },
                success: function(response){
                    console.log(response.currentlesson_duration.lesson_duration);
                }
            });
        }
        
        function hideExam(id){
            $.ajax({
            url:`/admin/exam-active/${id}`,
            type:'GET',
            success: function(response){
                if (response.code == 200) {
                    const inactiveHtml = "<i class='fas fa-eye-slash text-muted'></i>";
                    const activeHtml = "<i class='fa fa-eye text-primary'></i>";
                    $('#active-exam-control'+id).html("");
                    if(response.status){
                        $('#active-exam-control'+id).html(activeHtml);
                    }else{
                        $('#active-exam-control'+id).html(inactiveHtml);
                    }
                    // alert(response.message);
                }
            }
            })
        }

        $('#is_limited').click(function(){
            if($(this).prop('checked')){
                $('.dateGroup').removeClass('d-none');
                $('.psmdatetimepicker1').attr("required", true);
                $('.end_date_time').attr("required", true);
                $('#time_limit').attr("required", true);
                $('#time_type').attr("required", true);
                $('.psmdatetimepicker1').val("");
                $('.end_date_time').val("");
                $('#time_limit').val("");
            }else{
                $('.dateGroup').addClass('d-none');
                $('.psmdatetimepicker1').attr("required", false);
                $('.end_date_time').attr("required", false);
                $('#time_limit').attr("required", false);
                $('#time_type').attr("required", false);
                $('#time_limit').val("");
            }
        })

        $('#time_limit').on("input",function(){
            const start_date = $('.psmdatetimepicker1').val();
            const val = $(this).val();
            const type = $('#time_type option:selected').text();
            const timetype = $('#time_type').val();
            
            // console.log(type);
            if(val && start_date && timetype != ''){
                $.ajax({
                    type:'get',
                    url:'/get-end-date',
                    data:{start_date:start_date,time_limit:val,time_type:type},
                    success:function(response){
                        $('.end_date_time').val(response.end_date);
                    }
                })
            }
        })
        $('#time_type').change(function(){
            const start_date = $('.psmdatetimepicker1').val();
            const val = $('#time_limit').val();
            const type = $('#time_type option:selected').text();
            // console.log(type);
            if(val && start_date){
                $.ajax({
                    type:'get',
                    url:'/get-end-date',
                    data:{start_date:start_date,time_limit:val,time_type:type},
                    success:function(response){
                        $('.end_date_time').val(response.end_date);
                    }
                })
            }
        });


        function newQuestion(module_id, exam_id)
        {
            $("#module_id").val(module_id);
            $("#exam_id").val(exam_id);
        }

        function deleteExam(id)
        {
            var result = confirm("Confirm delete record?");
            if(result) {
                $('.deleteExamDataForm'+id).submit();
            }
        }

        function fileRemove(id){
            $('.assignment_upload'+id).val("");
        }

        function showUpload(id){
            $('.fileUpload'+id).removeClass('d-none');
        }
        function cancelUpload(id){
            $('.fileUpload'+id).addClass('d-none');
        }

        function showControls(id){
           $('.controlGroup'+id).removeClass('d-none');
           $('#myPlayer'+id+' > .vjs-control-bar').removeClass('d-none');
        }
        function hideControls(id){
           $('.controlGroup'+id).addClass('d-none');
           $('#myPlayer'+id+' > .vjs-control-bar').addClass('d-none');
        }


        function setPlayPause(lesson_id){
            const currentPlayer = videojs('myPlayer'+lesson_id);
            if (currentPlayer.paused()) {
                // console.log('play');
                currentPlayer.play()
            }else { 
                // console.log('pause');
                currentPlayer.pause(); 
            } 
        }
        function showHideLeftMenu(){
            const on_off = $('#show_hide_menu').val();
            if(on_off == 0){
                $('.leftSection').removeClass('hide');
                $('.rightSection').removeClass("col-md-12");
                $('.rightSection').addClass("col-md-7");
                $('.showHideMenuIcon').addClass('fa-align-left')
                $('.showHideMenuIcon').removeClass('fa-align-right')
                $('#show_hide_menu').val(1);
            }else{
                $('.leftSection').addClass('hide');
                $('.rightSection').removeClass("col-md-7");
                $('.rightSection').addClass("col-md-12");
                $('.showHideMenuIcon').addClass('fa-align-right')
                $('.showHideMenuIcon').removeClass('fa-align-left')
                $('#show_hide_menu').val(0);
            }
        }

        function selectQuestionGroup(group_id, course_id, module_id, exam_id)
        {

            location.href = '/question_group_names/'+group_id+'/select-group?course_id='+course_id+'&module_id='+module_id+'&exam_id='+exam_id;

        }

            let disableConfirmation = false;
            window.addEventListener('beforeunload', event => {
                
                const confirmationText = 'Are you sure leave?';

                if (!disableConfirmation) {
                    
                        const myVideoPlayer = videojs('myPlayer'+current_lesson_id);
                        myVideoPlayer.pause();

                        var course_id = $("#selected_course_id").val();
                        var d = new Date();
                        var data = {
                                        play_id: play_id,
                                        course_id: course_id,
                                        module_id: current_module_id,
                                        lesson_id: current_lesson_id,
                                        pause_date: d
                                    };
                        
                        localStorage.setItem('stop_lesson', JSON.stringify(data));

                        $.ajax({
                                    type:'POST',
                                    async: false,
                                    url: "{{url('pause_lesson')}}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    data: {
                                        play_id: play_id,
                                        course_id: course_id,
                                        module_id: current_module_id,
                                        lesson_id: current_lesson_id
                                    },
                                    success: (response) => {
                                        console.log(response);
                                        closeAfterSave == false;
                                    },
                                    
                        });
                    
                    
                    event.returnValue = confirmationText;
                    return confirmationText;

                } else {

                    disableConfirmation = false;
                }
            });

            $(window).on('unload', function() {

                if(closeAfterSave == true) {
                    var course_id = $("#selected_course_id").val();
                    var d = new Date();
                    var data = {
                                        play_id: play_id,
                                        course_id: course_id,
                                        module_id: current_module_id,
                                        lesson_id: current_lesson_id,
                                        pause_date: d,
                                };

                    localStorage.setItem('stop_lesson', JSON.stringify(data));
                    
                    $.ajax({
                                    type:'POST',
                                    async: false,
                                    url: "{{url('pause_lesson')}}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    data: {
                                        play_id: play_id,
                                        course_id: course_id,
                                        module_id: current_module_id,
                                        lesson_id: current_lesson_id
                                    },
                                    success: (response) => {
                                        console.log(response);
                                        closeAfterSave == false;
                                    },
                                    
                    });
                }

            });

    </script>

    {{-- Chating --}}
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>

    <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
    var pusher = new Pusher("{{ config('chatify.pusher.key') }}", {
        encrypted: true,
        cluster: "{{ config('chatify.pusher.options.cluster') }}",
        authEndpoint: '{{route("pusher.auth")}}',
        auth: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }
    });
    </script>
    <script src="{{ asset('assets/js/code.js') }}"></script>
    <script>
    // Messenger global variable - 0 by default
    messenger = "{{ @$chartid }}";
    course_id = $("#selected_course_id").val();

    var auth_id_now = {{Auth::id()}};
    var my_group = "{{$chatgroup ? $chatgroup->ref_no:''}}";

    </script>

@endpush
