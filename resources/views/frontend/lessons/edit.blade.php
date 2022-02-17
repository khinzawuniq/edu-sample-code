@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<div class="container course-page">
    <div class="card">
        <div class="card-header">
        <h2>Editing <strong>{{$lesson->name}}</strong></h2>
        </div>
        <div class="card-body">
            {!! Form::model($lesson, ['method' => 'PATCH','enctype'=>'multipart/form-data', 'files'=>true,'route' => ['lessons.update', $lesson->id]]) !!}
                
            <input type="hidden" name="course_id" value="{{$lesson->module->course_id}}">
            <input type="hidden" name="course_module_id" value="{{$lesson->module->id}}">

            @if (config('lesson_type.type')[$lesson->lesson_type] == "file")
            <div class="form-group">
                <label for="name">File Name</label>
            <input type="text" name="name" id="name" value="{{$lesson->name}}" class="form-control" autocomplete="off" required placeholder="File Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10">{!! $lesson->description !!}</textarea>
            </div>
            <div class="form-group">
                <label for="file_path">Additional files</label>
                <div class="input-group">
                    <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                     <i class="fas fa-file-alt"></i> Choose
                    </a>
                    </span>
                    <input id="thumbnail" class="form-control" type="text" name="file_path" value="{{$lesson->file_path}}">
                 </div> 
            </div>
            @endif


            
            @if (config('lesson_type.type')[$lesson->lesson_type] == "text_and_image")
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" autocomplete="off" required placeholder="Name" value="{{$lesson->name}}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10">{!! $lesson->description !!}</textarea>
            </div>
            <div class="form-group">
                <label for="file_path">Image</label>
                <div class="input-group">
                   <span class="input-group-btn">
                   <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                    <i class="fas fa-file-alt"></i> Choose
                   </a>
                   </span>
                   <input id="thumbnail" class="form-control" type="text" name="file_path" value="{{$lesson->file_path}}">
                </div> 
             </div>
            @endif


            @if (config('lesson_type.type')[$lesson->lesson_type] == "url")
            <div class="form-group">
                <label for="name">Course Name</label>
            <input type="text" name="name" id="name" value="{{$lesson->name}}" class="form-control" autocomplete="off" required placeholder="General Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10">{!! $lesson->description !!}</textarea>
            </div>
            <div class="form-group">
                <label for="url">URL Link</label>
                <input type="text" name="url" value="{{$lesson->url}}" id="url" class="form-control" placeholder="External Url">
            </div>
            @endif


            @if (config('lesson_type.type')[$lesson->lesson_type] == "zoom")
            <div class="form-group">
                <label for="name">Meeting Name</label>
            <input type="text" name="name" id="name" value="{{$lesson->name}}" class="form-control" autocomplete="off" required placeholder="General Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10">{!! $lesson->description !!}</textarea>
            </div>
            <div class="form-group">
                <label for="url">Zoom Meeting Link</label>
                <input type="text" name="url" id="url" value="{{$lesson->url}}" class="form-control" placeholder="Zoom Meeting Link">
            </div>
            <div class="form-group">
                <label for="zoom_id">Zoom Meeting ID</label>
                <input type="text" name="zoom_id" id="zoom_id" value="{{$lesson->zoom_id}}" autocomplete="off" class="form-control" placeholder="Zoom Meeting ID" required>
            </div>
            <div class="form-group">
                <label for="zoom_password">Zoom Meeting Passowrd</label>
                <input type="text" name="zoom_password" id="zoom_password"  value="{{$lesson->zoom_password}}" autocomplete="off" class="form-control" placeholder="Zoom Meeting Password" required>
            </div>
            @endif


            @if (config('lesson_type.type')[$lesson->lesson_type] == "lessons")
                <div class="form-group">
                    <label for="name">Lesson Name</label>
                    <input type="text" name="name" id="name" value="{{$lesson->name}}" class="form-control" autocomplete="off" required placeholder="Lesson Name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10">{{$lesson->description}}</textarea>
                </div>
                <div class="form-group">
                    <label for="file_path">Upload Video</label>
                    <div class="input-group">
                    <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                        <i class="far fa-image"></i> Choose
                    </a>
                    </span>
                <input id="thumbnail" class="form-control" type="text" name="file_path" value="{{$lesson->file_path}}">
                    </div> 
                </div>
                <div class="form-group">
                    <input type="checkbox" name="is_limited" id="is_limited" {{$lesson->time_limit ? 'checked' : ''}}> Time Limit
                </div>
                <div class="dateGroup {{$lesson->time_limit ? '' : 'd-none'}}">
                <div class="form-group">
                    <label for="open_quiz_date">Start Date Time</label>
                    <input type="text" name="open_quiz_date" autocomplete="off" value="{{$lesson->open_quiz_date}}" placeholder="Start Date Time" id="open_quiz_date" class="form-control psmdatetimepicker1">
                </div>

                <div class="form-group">
                    <label for="time_limit">Time limit</label>
                    <div class="d-flex">
                    <input type="number" style="width:20%;" min="0" name="time_limit" value="{{$lesson->time_limit}}" placeholder="Time Limit" id="time_limit" class="form-control mr-2">
                        <select name="time_type" style="width:10%;" id="time_type" class="form-control">
                            @foreach (config('time_type.type') as $timekey =>  $timetype)
                                <option value="{{$timekey}}" {{$lesson->time_type == $timekey ? 'selected' : ''}}>{{$timetype}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="close_quiz_date">End Date Time</label>
                    <input type="text" name="close_quiz_date" readonly placeholder="End Date Time" id="close_quiz_date" class="form-control end_date_time" value="{{$lesson->close_quiz_date}}">
                </div>
                </div>
            @endif

            @if (config('lesson_type.type')[$lesson->lesson_type] == "assignment")
            <div class="form-group">
                <label for="name">General Name</label>
            <input type="text" name="name" id="name" value="{{$lesson->name}}" class="form-control" autocomplete="off" required placeholder="General Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10">{!! $lesson->description !!}</textarea>
            </div>
            <div class="form-group">
                <label for="file_path">Additional files</label>
                <input type="file" name="file_path" id="file_path" class="form-control dropify">
            </div>
            <div class="form-group">
                <label for="assingment_allow_submission_from_date">Allow submissions from</label>
                <input type="text" name="assingment_allow_submission_from_date" value="{{$lesson->assingment_allow_submission_from_date}}" placeholder="Allow submissions from" id="assingment_allow_submission_from_date" class="form-control psmdatetimepicker1">
            </div>
            <div class="form-group">
                <label for="assingment_due_date">Due date</label>
                <input type="text" name="assingment_due_date" id="assingment_due_date" value="{{$lesson->assingment_due_date}}" placeholder="Due date" class="form-control psmdatetimepicker2">
            </div>
            <div class="form-group">
                <label for="assingment_cut_off_date">Cut-off date</label>
                <input type="text" name="assingment_cut_off_date" id="assingment_cut_off_date" value="{{$lesson->assingment_cut_off_date}}" placeholder="Cut-off date" class="form-control psmdatetimepicker3">
            </div>
            <div class="form-group">
                <label for="assingment_remind_date">Remind me to grade by</label>
                <input type="text" name="assingment_remind_date" id="assingment_remind_date" value="{{$lesson->assingment_remind_date}}" placeholder="Remind me to grade by" class="form-control psmdatetimepicker4">
            </div>
            @endif


            @if (config('lesson_type.type')[$lesson->lesson_type] == "certificate")
            <div class="form-group">
                <label for="name">Certificate Title</label>
                <input type="text" name="name" id="name" value="{{$lesson->name}}" class="form-control" autocomplete="off" required placeholder="Certificate Title">
            </div>
            <div class="form-group">
                <label for="description">Certificate Content</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10">{!! $lesson->description !!}</textarea>
            </div>
            <div class="row">
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="display">Certificate Display</label>
                        <select name="display" id="display" class="form-control">
                            <option value="1" {{($lesson->display == 1)? 'selected':''}}>Portrait</option>
                            <option value="2" {{($lesson->display == 2)? 'selected':''}}>Landscape</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="activity_restriction">Activity Restriction</label>
                        <select name="activity_restriction" id="activity_restriction" class="form-control">
                            <option value="1" {{($lesson->activity_restriction == 1)? 'selected':''}}>No restriction</option>
                            <option value="2" {{($lesson->activity_restriction == 2)? 'selected':''}}>Lessons</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="grade_restriction">Grade Restriction</label>
                        <select name="grade_restriction" id="grade_restriction" class="form-control">
                            <option value="1" {{($lesson->grade_restriction == 1)? 'selected':''}}>No restriction</option>
                            <option value="2" {{($lesson->grade_restriction == 2)? 'selected':''}}>Pass</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="form-group">
                        <label for="payment_restriction">Payment Restriction</label>
                        <select name="payment_restriction" id="payment_restriction" class="form-control">
                            <option value="1" {{($lesson->payment_restriction == 1)? 'selected':''}}>No restriction</option>
                            <option value="2" {{($lesson->payment_restriction == 2)? 'selected':''}}>Paid</option>
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

             <button type="submit" class="btn btn-success">Save & Display</button>
            {!! Form::close() !!}
        </div>
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
            ['view', ['fullscreen', 'codeview']],
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