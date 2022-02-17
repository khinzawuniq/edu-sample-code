@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<div class="container course-page py-4">
    <div class="card">
        <div class="card-header">
            <h2>Editing <strong>{{$exam->exam_name}}</strong></h2>
        </div>
        <div class="card-body">
            {!! Form::model($exam, ['method' => 'PATCH','route' => ['exams.update', $exam->id]]) !!}
                
            <input type="hidden" name="course_id" value="{{$exam->course_id}}">
            <input type="hidden" name="module_id" value="{{$exam->module_id}}">
           
            <div class="form-group">
                <label for="exam_name">Exam Name</label>
                <input type="text" name="exam_name" id="exam_name" value="{{$exam->exam_name}}" class="form-control" autocomplete="off" required placeholder="Exam Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10"> {!! $exam->description !!} </textarea>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-12">
                            <label for="">Shuffle The Questions?</label>
                            <div class="form-group">
                                <label for="shuffle_question_yes" style="margin-right: 20px">
                                    <input type="radio" name="shuffle_question" id="shuffle_question_yes" value="1" @if($exam->shuffle_question == 1) checked @endif required> Yes
                                </label>
                                <label for="shuffle_question_no">
                                    <input type="radio" name="shuffle_question" id="shuffle_question_no" value="0" @if($exam->shuffle_question == 0) checked @endif> No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-12">
                            <label for="">Shuffle The Answers?</label>
                            <div class="form-group">
                                <label for="shuffle_answer_yes" style="margin-right: 20px">
                                    <input type="radio" name="shuffle_answer" id="shuffle_answer_yes" value="1" @if($exam->shuffle_answer == 1) checked @endif required> Yes
                                </label>
                                <label for="shuffle_answer_no">
                                    <input type="radio" name="shuffle_answer" id="shuffle_answer_no" value="0" @if($exam->shuffle_answer == 0) checked @endif> No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="attempts_allow">Attempts Allowed</label>
                        {!! Form::select('attempts_allow', $attempts_allow, null, ['class'=>'form-control','id'=>'attempts_allow','required'=>true]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="">Grading</label>
                        {{-- {!! Form::select('grading', [1=>1,2=>2,3=>3], null, ['class'=>'form-control','id'=>'grading', 'placeholder'=>'Select Grading']) !!} --}}
                        <select name="grading_id" id="grading_id" class="form-control" required>
                            <option value="">Select Grading</option>
                            @foreach($gradings as $grading)
                                <option value="{{$grading->ref_no}}" {{($grading->ref_no == $exam->grading_id)? 'selected' : ''}}> {{$grading->awarding_body}} </option>
                            @endforeach
                        </select>
        
                        {{-- {!! Form::hidden('grade_mark_from', null, ['class'=>'form-control','id'=>'grade_mark_from']) !!}
                        {!! Form::hidden('grade_mark_to', null, ['class'=>'form-control','id'=>'grade_mark_to']) !!}
                        {!! Form::hidden('grade_description', null, ['class'=>'form-control','id'=>'grade_description']) !!} --}}
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="passing_mark">Passing Mark</label>
                        {!! Form::number('passing_mark', null, ['class'=>'form-control','id'=>'passing_mark', 'min'=>0, 'placeholder'=>'Passing Mark','required'=>true]) !!}
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="">Question Per Page</label>
                        {!! Form::select('question_per_page', $questions_per_page, $exam->question_per_page, ['class'=>'form-control','id'=>'question_per_page', 'placeholder'=>'Select Question Per Page', 'required'=>true]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="input-group">
                        <div class="form-group mr-2">
                            <label for="exam_duration">Exam Duration</label>
                            <input type="number" name="exam_duration" id="exam_duration" value="{{$exam->exam_duration}}" class="form-control" min="0" placeholder="Exam Duration" required>
                        </div>
                        <div class="form-group">
                            <label for="duration_type">Duration Type</label>
                            <select name="duration_type" id="duration_type" class="form-control" required>
                                <option value="hours" @if($exam->duration_type == 'hours') selected @endif>Hours</option>
                                <option value="minutes" @if($exam->duration_type == 'minutes') selected @endif>Minutes</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <input type="checkbox" name="is_limited" id="is_limited" {{$exam->time_limit ? 'checked' : ''}}> Time Limit
                    </div>
                    
                    <div class="dateGroup {{$exam->time_limit ? '' : 'd-none'}}">
                    <div class="form-group">
                        <label for="start_date">Start Date Time</label>
                        <input type="text" name="start_date" autocomplete="off" value="{{$exam->start_date}}" placeholder="Start Date Time" id="start_date" class="form-control psmdatetimepicker1">
                    </div>
        
                    <div class="form-group">
                        <label for="time_limit">Time limit</label>
                        <div class="d-flex">
                            <input type="number" style="width:40%;" min="0" name="time_limit" value="{{$exam->time_limit}}" placeholder="Time Limit" id="time_limit" class="form-control mr-2">
                            <select name="time_type" style="width:30%;" id="time_type" class="form-control">
                                @foreach (config('time_type.type') as $timekey =>  $timetype)
                                    <option value="{{$timekey}}" {{$exam->time_type == $timekey ? 'selected' : ''}}>{{$timetype}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date Time</label>
                        <input type="text" name="end_date" readonly placeholder="End Date Time" id="end_date" class="form-control end_date_time" value="{{$exam->end_date}}">
                    </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save and Continue</button>
            <a href="{{url('/courses/detail/'.$exam->course->slug.'?module_id='.$exam->module_id)}}" class="btn btn-light">Cancel</a>
            
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
            const timetype = $('#time_type').val();
            console.log(type);
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

        $("#grading_id").change(function() {
            var grading_ref_no = $("#grading_id").val();
            $.ajax({
                type:'get',
                url:'/admin/get-grading',
                data:{ref_no:grading_ref_no},
                success:function(response){
                    $("#passing_mark").val(response.passing_mark);
                    console.log(response.passing_mark);
                    // $('#grade_mark_from').val(response.grading_from);
                    // $('#grade_mark_to').val(response.grading_to);
                    // $('#grade_description').val(response.grading_description);
                }
            });
        });
</script>
@endpush
