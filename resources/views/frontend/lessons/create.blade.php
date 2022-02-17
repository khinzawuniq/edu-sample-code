@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<div class="container course-page">
    <div class="card">
        <div class="card-header">
        <h3>Adding a new {{$type}} to <i>{{$module->name}}</i>  of <strong>{{$course->course_name}}</strong></h3>
        </div>
        <div class="card-body">
            {!! Form::open(array('route' => 'lessons.store','method'=>'POST', 'enctype'=>'multipart/form-data', 'files'=>true)) !!}
                
            <input type="hidden" name="course_id" value="{{$course->id}}">
            <input type="hidden" name="course_module_id" value="{{$module->id}}">
            <input type="hidden" name="lesson_type" value="{{array_search(Request::get('type'),config('lesson_type.type'))}}">
           
            @if (Request::get('type') == "lessons")
            <div class="form-group">
                <label for="name">Lesson Name</label>
                <input type="text" name="name" id="name" class="form-control" autocomplete="off" required placeholder="Lesson Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="file_path">Upload Video</label>
                <div class="input-group">
                   <span class="input-group-btn">
                   <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                    <i class="far fa-image"></i> Choose
                   </a>
                   </span>
                   <input id="thumbnail" class="form-control" type="text" name="file_path">
                </div> 
             </div>
             <div class="form-group">
                <input type="checkbox" name="is_limited" id="is_limited"> Time Limit
              </div>
             <div class="dateGroup d-none">
             <div class="form-group">
                <label for="open_quiz_date">Start Date Time</label>
                <input type="text" name="open_quiz_date" autocomplete="off" placeholder="Start Date Time" id="open_quiz_date" class="form-control psmdatetimepicker1">
            </div>

            <div class="form-group">
                <label for="time_limit">Time limit</label>
                <div class="d-flex">
                    <input type="number" style="width:20%;" min="0" name="time_limit" value="" placeholder="Time Limit" id="time_limit" class="form-control mr-2">
                    <select name="time_type" style="width:10%;" id="time_type" class="form-control">
                        @foreach (config('time_type.type') as $timekey =>  $timetype)
                            <option value="{{$timekey}}">{{$timetype}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="close_quiz_date">End Date Time</label>
                <input type="text" name="close_quiz_date" readonly placeholder="End Date Time" id="close_quiz_date" class="form-control end_date_time">
            </div>
             </div>

            @endif






            @if (Request::get('type') == "file")
            <div class="form-group">
                <label for="name">File Name</label>
                <input type="text" name="name" id="name" class="form-control" autocomplete="off" required placeholder="General Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="description">File(PDF,Excel,Word,Text File,Power Point)</label>
                <div class="input-group">
                   <span class="input-group-btn">
                   <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                    <i class="fas fa-file-alt"></i> Choose
                   </a>
                   </span>
                   <input id="thumbnail" class="form-control" type="text" name="file_path">
                </div> 
             </div>
            @endif


            @if (Request::get('type') == "text_and_image")
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" autocomplete="off" required placeholder="Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="file_path">Image</label>
                <div class="input-group">
                   <span class="input-group-btn">
                   <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                    <i class="fas fa-file-alt"></i> Choose
                   </a>
                   </span>
                   <input id="thumbnail" class="form-control" type="text" name="file_path">
                </div> 
             </div>
            @endif


            @if (Request::get('type') == "url")
            <div class="form-group">
                <label for="name">Course Name</label>
                <input type="text" name="name" id="name" class="form-control" autocomplete="off" required placeholder="General Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="url">URL Link</label>
                <input type="text" name="url" id="url" class="form-control" placeholder="External Url" autocomplete="off">
            </div>
            @endif
            @if (Request::get('type') == "zoom")
            <div class="form-group">
                <label for="name">Meeting Name</label>
                <input type="text" name="name" id="name" autocomplete="off" class="form-control" autocomplete="off" required placeholder="General Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="url">Zoom Meeting Link</label>
                <input type="text" name="url" id="url" autocomplete="off" class="form-control" placeholder="Zoom Meeting Link" required>
            </div>
            <div class="form-group">
                <label for="zoom_id">Zoom Meeting ID</label>
                <input type="text" name="zoom_id" id="zoom_id" autocomplete="off" class="form-control" placeholder="Zoom Meeting ID" required>
            </div>
            <div class="form-group">
                <label for="zoom_password">Zoom Meeting Passowrd</label>
                <input type="text" name="zoom_password" id="zoom_password" autocomplete="off" class="form-control" placeholder="Zoom Meeting Password" required>
            </div>
            @endif

            @if (Request::get('type') == "assignment")

            <div class="form-group">
                <label for="name">Assignment Name</label>
                <input type="text" name="name" id="name" autocomplete="off" class="form-control" autocomplete="off" required placeholder="General Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="assingment_due_date">Submission Deadline</label>
                <input type="text" name="assingment_due_date" id="assingment_due_date" placeholder="Due date" class="form-control psmdatetimepicker2" autocomplete="off">
            </div>
            @endif


            @if (Request::get('type') == "certificate")

            <div class="form-group">
                <label for="name">Certificate Title</label>
                <input type="text" name="name" id="name" autocomplete="off" class="form-control" autocomplete="off" required placeholder="Certificate Title">
            </div>
            <div class="form-group">
                <label for="description">Certificate Content</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10"></textarea>
            </div>
            <div class="row">
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="display">Certificate Display</label>
                        <select name="display" id="display" class="form-control">
                            <option value="1">Portrait</option>
                            <option value="2">Landscape</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="activity_restriction">Activity Restriction</label>
                        <select name="activity_restriction" id="activity_restriction" class="form-control">
                            <option value="1">No restriction</option>
                            <option value="2">Lessons</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="grade_restriction">Grade Restriction</label>
                        <select name="grade_restriction" id="grade_restriction" class="form-control">
                            <option value="1">No restriction</option>
                            <option value="2">Pass</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="payment_restriction">Payment Restriction</label>
                        <select name="payment_restriction" id="payment_restriction" class="form-control">
                            <option value="1">No restriction</option>
                            <option value="2">Paid</option>
                        </select>
                    </div>
                </div>
            </div>

            @if(count($exams) > 0)
            <div class="row">
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="certificate_exam_id">Exam</label>
                        {!! Form::select('certificate_exam_id', $exams, old('certificate_exam_id'), array('placeholder' => 'Select Exam *','class' => 'form-control', 'id'=>'certificate_exam_id','required'=>true)) !!}
                    </div>
                </div>
            </div>
            @endif

            @endif
             <button type="submit" class="btn btn-success">Save and Continue</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script>
$(document).ready(function() {
    $(function(){
        $('.psmdatetimepicker1').datetimepicker();
        $('.psmdatetimepicker2').datetimepicker();
        $('.psmdatetimepicker3').datetimepicker();
        $('.psmdatetimepicker4').datetimepicker();
    });

});


    $('.psmeditor').summernote({
            height: 200,
            width:'100%',
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
        ]
        });
        $('#lfm').filemanager('file');

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
            console.log(type);
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
        })
        $('#time_type').change(function(){
            const start_date = $('.psmdatetimepicker1').val();
            const val = $('#time_limit').val();
            const type = $('#time_type option:selected').text();
            console.log(type);
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
        })
</script>
@endpush
