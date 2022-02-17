@extends('layouts.app')

@section('content')
<div class="container start-exam-page py-4" id="start_exam_page">

    <div class="card mb-3">
        <div class="card-body">
            <h4> {{$exam->course->course_name}} </h4>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-brand">
            <h3 class="card-title text-center text-white mb-0">Exam Room</h3>
        </div>
        <div class="card-body py-0 px-3">
            
            <div class="row">

                <div class="col-md-9 col-sm-8 col-12 py-4 px-2">
                    <div class="nav-btn-wrapper mb-3">
                        @foreach($questions as $key=>$question)

                            @if($before_start)
                                @php
                                
                                $result = false;
                                if(in_array($question->id, $question_arr)) {
                                    $result = true;
                                }
                                @endphp
                            <button class="btn {{($result)?'btn-success':'btn-secondary'}} mr-1 qbutton-{{$question->id}}" id="question_{{$key+1}}"> {{$key+1}} </button>
                            @else
                            <button class="btn btn-secondary mr-1 qbutton-{{$question->id}}" id="question_{{$key+1}}"> {{$key+1}} </button>
                            @endif

                        @endforeach
                    </div>
                </div>

                <div class="col-md-3 col-sm-4 col-12 py-4 px-2 countdown-wrapper">
                    <div class="exam-time-wrapper">
                        <div class="display-time">
                            <h4 class="text-center mb-0">Exam Countdown</h4>
                            @if($before_start)
                                <h4 class="countdown px-2 py-2 text-center"><span id="hour">{{$current['hour']}}</span>:<span id="minute">{{$current['minute']}}</span>:<span id="second">{{$current['second']}}</span></h4>
                            @else
                                <h4 class="countdown px-2 py-2 text-center"><span id="hour">{{($exam->duration_type=='hours')?$exam->exam_duration:'00'}}</span>:<span id="minute">{{($exam->duration_type=='minutes')?$exam->exam_duration:'00'}}</span>:<span id="second">00</span></h4>
                            @endif
                            
                        </div>
                        <div class="answered-wrapper mb-2">
                            <div class="answered btn-label mr-auto">Answered</div>
                            @if($before_start)
                                <button class="btn btn-success answered-btn ml-auto">{{count($student_exam->beforeAnswer($student_exam->id, $exam->id))}}</button>
                            @else
                                <button class="btn btn-success answered-btn ml-auto">0</button>
                            @endif
                        </div>
                        <div class="not-answered-wrapper mb-2">
                            <div class="not-answered btn-label mr-auto">Not Answered</div>
                            @if($before_start)
                                <button class="btn btn-secondary not-answered-btn ml-auto">{{count($questions) - count($student_exam->beforeAnswer($student_exam->id, $exam->id))}}</button>
                            @else
                                <button class="btn btn-secondary not-answered-btn ml-auto">0</button>
                            @endif
                        </div>
                        <div class="marked-wrapper mb-2">
                            <div class="marked btn-label mr-auto">Marked</div>
                            <button class="btn btn-danger marked-btn ml-auto">0</button>
                        </div>
                        {{-- <div class="stop-exam">
                            <button class="btn btn-danger btn-sm" id="stop_exam">Stop Exam</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="choice-list-wrapper">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
        <div class="carousel-inner">
        
        @foreach($questions as $key=>$question)
        @php $key = $key+1; @endphp
        @php
            $active_class = 'active';
            if($exam->question_per_page == 1) {
                $active_class = 'active';
            }elseif($exam->question_per_page == 2) {
                if($key == 1) {
                    $active_class = 'active';
                }else {
                    $active_class = null;
                }
            }elseif($exam->question_per_page == 3) {
                if($key <= 5) {
                    $active_class = 'active';
                }else {
                    $active_class = null;
                }
            }elseif($exam->question_per_page == 4) {
                if($key <= 10) {
                    $active_class = 'active';
                }else {
                    $active_class = null;
                }
            }
        @endphp
        <div class="carousel-item item-{{$key}} {{$active_class}}">
            <input type="hidden" name="qitem_id" id="qitem_id_{{$question->id}}" class="qitem_id" value="{{$key}}">
            <div class="row mb-3 question-{{$question->id}}">
            
                <input type="hidden" name="answer_status" id="answer_status">
        
                <div class="col-md-12 col-sm-12 col-12">
                    <div class="card question-detail bg-light">
                        <div class="card-body">
                            <p class="question-name mb-3">{{$key}}. {{$question->question}} </p>
                            <div class="choice-wrapper wrapper-{{$question->id}}">

                                @if($before_start)
                                @php
                                    $search_q = array_search($question->id, $question_arr);
                                    $ans_value = 0;
                                    if(count($question_arr) > 0) {
                                        $ans_value = $student_exam->beforeAnswer($student_exam->id, $exam->id)[$search_q]->choice_answer_id;
                                        // $ans_value = $student_exam->studentAnswer[$search_q]->choice_answer_id;
                                    }
                                @endphp

                                <input type="hidden" name="student_answer_{{$question->id}}" id="student_answer_{{$question->id}}" value="{{$ans_value}}">
                                @else
                                <input type="hidden" name="student_answer_{{$question->id}}" id="student_answer_{{$question->id}}" value="0">
                                @endif
                                

                                @if($question->question_type == 'multiple_choice')
                                {{-- @foreach($question->questionAnswer as $key=>$choice) --}}
                                @foreach($question->choiceAnswer($exam->id, $question->id) as $key=>$choice)
                                
                                    @php
                                        $num_style = (!empty($question->answer_no_style))? $question->answer_no_style: 1;
                                        $answer_no = $question->numberStyle($num_style);
                                    @endphp

                                    @if($before_start)
                                        @php
                                        $checked = null;
                                        $search_q = array_search($question->id, $question_arr);
                                        if(count($question_arr) > 0) {
                                            if($student_exam->beforeAnswer($student_exam->id, $exam->id)[$search_q]->choice_answer_id == $choice->id) {
                                                $checked = "checked";
                                            }
                                        }
                                        @endphp

                                        <label for="choice_{{$question->id}}_{{$key+1}}">
                                            <input {{$checked}} type="radio" name="choice_{{$question->id}}" id="choice_{{$question->id}}_{{$key+1}}" onClick="choiceAnswer({{$question->id}}, {{$choice->id}}, {{$student_exam->id}})" value="{{$choice->answer}}"> {{$answer_no[$key+1]}} {{$choice->answer}}
                                            {{-- <input {{$checked}} type="radio" name="choice_{{$question->id}}" id="choice_{{$question->id}}_{{$key+1}}" onClick="choiceAnswer({{$question->id}}, {{$choice->id}}, {{$student_exam->id}})" value="{{$choice->answer}}"> {{$choice->answer_no}} {{$choice->answer}} --}}
                                        </label> <br>

                                    @else
                                    <label for="choice_{{$question->id}}_{{$key+1}}">
                                        <input type="radio" name="choice_{{$question->id}}" id="choice_{{$question->id}}_{{$key+1}}" onClick="choiceAnswer({{$question->id}}, {{$choice->id}}, {{$student_exam->id}})" value="{{$choice->answer}}"> {{$answer_no[$key+1]}} {{$choice->answer}}
                                    </label> <br>
                                    @endif
                                
                                @endforeach
                                @endif
        
                                @if($question->question_type == 'true_false')
                                    @if($before_start)
                                        @php
                                        $search_q = array_search($question->id, $question_arr);
                                        $result = '';
                                        if(in_array($question->id, $question_arr)) {
                                            $result = $student_exam->studentAnswer[$search_q]->choice_answer;
                                        }
                                        
                                        @endphp

                                        <label for="true_{{$question->id}}">
                                            <input {{($result == 'true')?'checked':''}} type="radio" name="correct_answer_{{$question->id}}" id="true_{{$question->id}}" value="true" onClick="choiceAnswerBoolean({{$question->id}}, 'true', {{$student_exam->id}})"> True
                                        </label>
                                        <label for="false_{{$question->id}}">
                                            <input {{($result == 'false')?'checked':''}} type="radio" name="correct_answer_{{$question->id}}" id="false_{{$question->id}}" value="false" onClick="choiceAnswerBoolean({{$question->id}}, 'false', {{$student_exam->id}})"> False
                                        </label>
                                    @else

                                    <label for="true_{{$question->id}}">
                                        <input type="radio" name="correct_answer_{{$question->id}}" id="true_{{$question->id}}" value="true" onClick="choiceAnswerBoolean({{$question->id}}, 'true', {{$student_exam->id}})"> True
                                    </label>
                                    <label for="false_{{$question->id}}">
                                        <input type="radio" name="correct_answer_{{$question->id}}" id="false_{{$question->id}}" value="false" onClick="choiceAnswerBoolean({{$question->id}}, 'false', {{$student_exam->id}})"> False
                                    </label>

                                    @endif
                                @endif
                            </div>
    
                            <div class="mark-review">
                                <button class="btn btn-danger btn-sm mark-{{$question->id}}" onClick="markReview({{$question->id}})">Mark for review</button>
                                <button class="btn btn-danger btn-sm unmark-{{$question->id}} hide" onClick="markReview({{$question->id}})">Unmark</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        </div>
        <div class="text-right nav-wrapper">
            @if($morepages == 1)
            
            <a class="btn brand-btn-color text-white hide" id="prev_question" style="width:100px;" href="#carouselExampleControls" role="button"> Previous</a>
            <a class="btn brand-btn-color text-white" id="next_question" style="width:100px;" href="#carouselExampleControls" role="button"> Next </a>
            {{-- <a class="btn brand-btn-color text-white" style="width:100px;" href="#carouselExampleControls" role="button" data-slide="prev"> Previous</a>
            <a class="btn brand-btn-color text-white" id="next_question" style="width:100px;" href="#carouselExampleControls" role="button" data-slide="next"> Next </a> --}}
            @endif

            <a class="btn brand-btn-color text-white {{($morepages == 1)?'hide':'show'}}" id="finish_exam" data-toggle="modal" data-target="#showResult" style="width:100px;" href="#" role="button"> Finish </a>
        </div>
        </div>

    </div>

    <div class="exam-result-wrapper hide">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3 col-sm-3 col-5 text-right">Started On</div>
                    <div class="col-md-9 col-sm-9 col-7 started-on"></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 col-sm-3 col-5 text-right">State</div>
                    <div class="col-md-9 col-sm-9 col-7 state"></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 col-sm-3 col-5 text-right">Completed On</div>
                    <div class="col-md-9 col-sm-9 col-7 completed-on"></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 col-sm-3 col-5 text-right">Time Taken</div>
                    <div class="col-md-9 col-sm-9 col-7 time-taken"></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 col-sm-3 col-5 text-right">Grade</div>
                    <div class="col-md-9 col-sm-9 col-7 grade"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="showResult" role="dialog" aria-labelledby="showResultLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-0">
                
                <div class="exam-time-wrapper mb-4" style="padding: 10px 20px;">
                    <div class="answered-wrapper mb-2">
                        <div class="answered btn-label mr-auto">Answered</div>
                        <button class="btn btn-success answered-btn ml-auto">0</button>
                    </div>
                    <div class="not-answered-wrapper mb-2">
                        <div class="not-answered btn-label mr-auto">Not Answered</div>
                        <button class="btn btn-secondary not-answered-btn ml-auto">0</button>
                    </div>
                    <div class="marked-wrapper mb-2">
                        <div class="marked btn-label mr-auto">Marked</div>
                        <button class="btn btn-danger marked-btn ml-auto">0</button>
                    </div>
                </div>

                <h4>Are you sure you want to finish your exam now?</h4>
                
                <div class="btn-action-wrapper mt-4 mb-3">
                    <button class="btn btn-primary mr-3" id="show_exam" style="width:150px;">Yes, finish exam!</button>
                    <button class="btn btn-secondary" style="width:120px;" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bg-danger" id="timeUp" role="dialog" aria-labelledby="timeUpLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <div class="modal-body text-center">                

                <h4>TIME IS UP!</h4>
                
            </div>
        </div>
    </div>
</div>

{{-- End Modal --}}
@endsection

@push('styles')
<style>
    .choice-list-wrapper.hide {
        display: none;
    }
    .exam-result-wrapper.hide {
        display: none;
    }
    #navbarSupportedContent.hide {
        display: none !important;
    }
    .question-pagination nav {
        display: flex;
    }
    .question-pagination .pagination {
        margin-right: auto;
        margin-left: auto;
    }
    .display-time h4 {
        font-size: 1.2rem;
        font-weight: 600;
    }
    .question-detail-wrapper {
        display: flex;
    }
    .question-detail {
        margin-right: auto;
    }
    .action-wrapper {
        margin-left: auto;
    }
    .answered-wrapper,
    .marked-wrapper,
    .not-answered-wrapper {
        display: flex;
        font-weight: 500;
    }
    .btn-label {
        font-size: 1.1rem;
    }
    .countdown-wrapper {
        border-left: 1px solid #00000020;
        border-radius: 0.25rem;
    }
    .nav-btn-wrapper .btn {
        width: 40px;
        margin-bottom: 15px;
        padding: 0.375rem 0.3rem;
    }
    .exam-time-wrapper .btn {
        width: 40px;
        padding: 0.375rem 0.3rem;
    }
    .carousel-item {
        float: none;
    }
    #finish_exam.hide {
        display: none;
    }
    #finish_exam.show {
        display: inline-block;
    }
    .mark-review .hide {
        display: none;
    }
    .nav-wrapper .hide {
        display: none;
    }
    .modal-fullscreen {
        width: 100vw;
        max-width: none;
        height: 100%;
        margin: 0;
    }
    #start_exam_btn {
        position: absolute;
        left: auto;
        right: auto;
        top: 47%;
    }
    #start_exam_page {
        overflow-y: scroll;
    }
</style>
@endpush

@push('scripts')
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>

$(document).ready(function() {

    $("#navbarSupportedContent").addClass('hide');
    var totalQuestion = {{count($questions)}};
    var examId        = {{$exam->id}};
    var courseId      = {{$exam->course_id}};
    var moduleId      = {{$exam->module_id}};
    var studentExam  = {{$student_exam->id}};
    // console.log(examId, courseId, moduleId);
    var duration_type = '{{$exam->duration_type}}';
    var exam_duration = "{{$exam->exam_duration}}";
    var second = '00';
    var minute = '00';
    var hour = '00';
    if(duration_type == 'hours') {
        
        @if($before_start)
            hour = {{$current['hour']}};
            minute = {{$current['minute']}};
        @else
            hour = exam_duration;
        @endif
        
        hour = (`${hour}`.length == 1)?"0"+hour:hour;
        minute = (`${minute}`.length == 1)?"0"+minute:minute;
        
        $("#hour").text(hour);
        $("#minute").text(minute);
    }
    if(duration_type == 'minutes') {

        @if($before_start)
            minute = {{$current['minute']}};
        @else
            minute = exam_duration;
        @endif

        minute = (`${minute}`.length == 1)?"0"+minute:minute;
        
        $("#minute").text(minute);
    }

    second = (`${second}`.length == 1)?"0"+second:second;

    $("#second").text(second);
    var goSecond = true;
    var tUp = 0;

    var interval = setInterval(function(){

        if(duration_type == 'minutes') {
            if(second == '00') {
                second = 60;
                if(minute != '00') {
                    minute = parseInt(minute) - 1;
                }
                minute = (`${minute}`.length == 1)?"0"+minute:minute;
                $("#minute").text(minute);
            }

            if(minute == '00' && second == '01') {
                    
                    // goSecond = false;
                    // $("#timeUp").modal('show');
                    tUp = parseInt(tUp) + 1;
                    if(tUp == 2) {
                        // $("timeUp").modal('hide');
                        location.href = "/exam_result?course_id="+courseId+"&module_id="+moduleId+"&exam_id="+examId+"&student_exam="+studentExam;
                    }
            }else {
                // if(goSecond == true) {
                    second = parseInt(second) - 1;
                    second = (`${second}`.length == 1)?"0"+second:second;
                    $("#second").text(second);
                    
                // }
            }
        }
        
        if(duration_type == 'hours') {
            
            
            if(minute == '00') {
                minute = 60;
                hour = parseInt(hour) - 1;

                hour = (`${hour}`.length == 1)?"0"+hour:hour;
                minute = (`${minute}`.length == 1)?"0"+minute:minute;

                $("#minute").text(minute);
                $("#hour").text(hour);
            }

            if(second == '00') {
                second = 60;
                minute = minute - 1;
                minute = (`${minute}`.length == 1)?"0"+minute:minute;
                $("#minute").text(minute);
            }

            if(hour == '00' && minute == '00' && second == '01') {
                
                // goSecond == false;
                        
                        // $("#timeUp").modal('show');
                        tUp = parseInt(tUp) + 1;
                        if(tUp == 2) {
                            // $("timeUp").modal('hide');
                            location.href = "/exam_result?course_id="+courseId+"&module_id="+moduleId+"&exam_id="+examId+"&student_exam="+studentExam;
                        }
                    
            } else {
                // if(goSecond == true) {
                    second = parseInt(second) - 1;
                    second = (`${second}`.length == 1)?"0"+second:second;
                    $("#second").text(second);
                    
                // }
            }
        }
    },1000);

    $("#show_exam").on('click', function() {
        
        location.href = "/exam_result/"+examId+"?course_id="+courseId+"&module_id="+moduleId+"&exam_id="+examId+"&student_exam="+studentExam;
    });

    // $("#stop_exam").click(function() {
    //     goSecond = false;

    //     $.ajax({
    //         type:'get',
    //         url:"/stop_exam",
    //         data:{
    //             course_id: courseId,
    //             module_id: moduleId,
    //             exam_id: examId,
    //             student_exam: studentExam,
    //         },
    //         success:function(response){
    //             if(response.code == 200) {
    //                 console.log(response.student_exam);
    //                 $("#stop_exam").attr('disabled','disabled');
    //                 $(".choice-list-wrapper").addClass('hide');
    //                 $(".exam-result-wrapper").removeClass('hide');

    //                 $("#navbarSupportedContent").removeClass('hide');

    //                 $(".started-on").text(response.data.start_exam);
    //                 $(".state").text(response.student_exam.state);
    //                 $(".completed-on").text(response.data.stop_exam);
    //                 $(".time-taken").text(response.data.time_taken);
    //                 // $(".time-taken").text(response.student_exam.time_taken);
    //                 $(".grade").text(response.student_exam.grade);
    //             }
    //         }
    //     });
    // });

    @if($before_start)
        $(".not-answered-btn").text({{count($questions)-count($student_exam->beforeAnswer($student_exam->id, $exam->id))}});
    @else
        $(".not-answered-btn").text({{count($questions)}});
    @endif
    

    @if($exam->question_per_page == 2)
        $("#next_question").on('click', function() {
            var lastActive = $(".carousel-item.active:last .qitem_id").val();
            if(totalQuestion != lastActive) {
                $(".carousel-item").removeClass('active');
            }
            $("#prev_question").removeClass('hide');
            for(var i=0; i < 1; i++) {
                lastActive = parseInt(lastActive) + 1;
                    
                $(".carousel-item.item-"+lastActive).addClass('active');
                if(totalQuestion == lastActive) {
                    $("#next_question").addClass('d-none');
                    
                    $("#finish_exam").removeClass('hide');
                    $("#finish_exam").addClass('show');    
                }
            }
        
        });
        $("#prev_question").on('click', function() {
            var firstActive = $(".carousel-item.active:first .qitem_id").val();
            if(firstActive != 1) {
                $(".carousel-item").removeClass('active');
                $("#prev_question").addClass('hide');
                $("#next_question").removeClass('d-none');
                $("#finish_exam").addClass('hide');
                $("#finish_exam").removeClass('show');
                for(var i=0; i < 1; i++) {
                    firstActive = parseInt(firstActive) - 1;
                    console.log(firstActive);
                    $(".carousel-item.item-"+firstActive).addClass('active');
                    
                }
            } 
        });
    @elseif($exam->question_per_page == 3)
        $("#next_question").on('click', function() {
            var lastActive = $(".carousel-item.active:last .qitem_id").val();
            if(totalQuestion != lastActive) {
                $(".carousel-item").removeClass('active');
            }
            $("#prev_question").removeClass('hide');
            for(var i=0; i < 5; i++) {
                lastActive = parseInt(lastActive) + 1;
                    
                $(".carousel-item.item-"+lastActive).addClass('active');
                if(totalQuestion == lastActive) {
                    $("#next_question").addClass('d-none');
                    $("#finish_exam").removeClass('hide');
                    $("#finish_exam").addClass('show');    
                }
            }
        
        });
        $("#prev_question").on('click', function() {
            var firstActive = $(".carousel-item.active:first .qitem_id").val();

            $("#next_question").removeClass('d-none');
            $("#finish_exam").addClass('hide');
            $("#finish_exam").removeClass('show');
            if(firstActive != 1) {
                $(".carousel-item").removeClass('active');
                for(var i=0; i < 5; i++) {
                    firstActive = parseInt(firstActive) - 1;
                    console.log(firstActive);
                    $(".carousel-item.item-"+firstActive).addClass('active');
                }
                var qitem_id = $(".carousel-item.active:first .qitem_id").val();
                if(qitem_id == 1) {
                    $("#prev_question").addClass('hide');
                }
            }
        });
    @elseif($exam->question_per_page == 4)
        $("#next_question").on('click', function() {
            var lastActive = $(".carousel-item.active:last .qitem_id").val();
            if(totalQuestion != lastActive) {
                $(".carousel-item").removeClass('active');
            }
            $("#prev_question").removeClass('hide');
            for(var i=0; i < 10; i++) {
                lastActive = parseInt(lastActive) + 1;
                    
                $(".carousel-item.item-"+lastActive).addClass('active');
                if(totalQuestion == lastActive) {
                    $("#next_question").addClass('d-none');
                    $("#finish_exam").removeClass('hide');
                    $("#finish_exam").addClass('show');    
                }
            }
        
        });
        $("#prev_question").on('click', function() {
            var firstActive = $(".carousel-item.active:first .qitem_id").val();
            $("#next_question").removeClass('d-none');

            $("#finish_exam").addClass('hide');
            $("#finish_exam").removeClass('show');

            if(firstActive != 1) {
                $(".carousel-item").removeClass('active');
                for(var i=0; i < 10; i++) {
                    firstActive = parseInt(firstActive) - 1;
                    console.log(firstActive);
                    $(".carousel-item.item-"+firstActive).addClass('active');
                }
                var qitem_id = $(".carousel-item.active:first .qitem_id").val();
                if(qitem_id == 1) {
                    $("#prev_question").addClass('hide');
                }
            }
        });
    @endif

});

$(window).scroll(function () {
    
    var scrollHeight = $(window).scrollTop();
    if(scrollHeight > 100) {
        $("#main-navbar").removeClass('sticky-top');
    }

});


    @if($before_start)
    var answered = {{count($student_exam->beforeAnswer($student_exam->id, $exam->id))}};
    var notAnswered = {{count($questions) - count($student_exam->beforeAnswer($student_exam->id, $exam->id))}};    
    @else
    var answered = 0;
    var notAnswered = {{count($questions)}};
    @endif

    var marked = 0;
    var examId        = {{$exam->id}};
    var courseId      = {{$exam->course_id}};
    var moduleId      = {{$exam->module_id}};
    var studentExam   = {{$student_exam->id}};

    function choiceAnswer(qId, cId, sExamId)
    {
        var studentAnswerId = $("#student_answer_"+qId).val();

                    if($(".qbutton-"+qId).hasClass("btn-danger")) {
                        // if(studentAnswerId == 0) {
                            marked = parseInt(marked) - 1;
                            $(".marked-btn").text(marked);
                        // }
                    }

                    $(".question-"+qId+" #answer_status").val('complete');
                    $(".qbutton-"+qId).removeClass('btn-secondary btn-danger').addClass('btn-success');
                    if(studentAnswerId == 0) {
                        answered = parseInt(answered) + 1;
                        $(".answered-btn").text(answered);
                        notAnswered = parseInt(notAnswered) - 1;
                        $(".not-answered-btn").text(notAnswered);
                    }

                    if($('.mark-'+qId).hasClass('hide')) {
                        $(".unmark-"+qId).addClass('hide');
                        $(".mark-"+qId).removeClass('hide');
                    }

        $.ajax({
            type:'get',
            url:'/student_answer',
            data:{
                question_id: qId,
                answer_id: cId,
                student_exam_id: sExamId,
                student_answer_id: studentAnswerId,
                exam_id: examId,
            },
            success:function(response){
                console.log(response);
                if(response.code == 200) {

                    $("#student_answer_"+qId).val(response.studentAnswer.id);
                }
            }
        });
    }
    
    function choiceAnswerBoolean(qId, val, sExamId)
    {
        var studentAnswerId = $("#student_answer_"+qId).val();

                    if($(".qbutton-"+qId).hasClass("btn-danger")) {
                        if(studentAnswerId == 0) {
                            marked = parseInt(marked) - 1;
                            $(".marked-btn").text(marked);
                        }
                    }

                    $(".question-"+qId+" #answer_status").val('complete');
                    $(".qbutton-"+qId).removeClass('btn-secondary btn-danger').addClass('btn-success');
                    if(studentAnswerId == 0) {
                        answered = parseInt(answered) + 1;
                        $(".answered-btn").text(answered);
                        notAnswered = parseInt(notAnswered) - 1;
                        $(".not-answered-btn").text(notAnswered);
                    }

                    if($('.mark-'+qId).hasClass('hide')) {
                        $(".unmark-"+qId).addClass('hide');
                        $(".mark-"+qId).removeClass('hide');
                    }

        $.ajax({
            type:'get',
            url:'/student_answer',
            data:{
                question_id: qId,
                choice_answer: val,
                student_exam_id: sExamId,
                student_answer_id: studentAnswerId,
                exam_id: examId,
            },
            success:function(response){
                if(response.code == 200) {
                    
                    $("#student_answer_"+qId).val(response.studentAnswer.id);

                }
            }
        });
    }

    function markReview(qId)
    {

        if($('.unmark-'+qId).hasClass('hide')) {
            marked = parseInt(marked) + 1;

            var studentAnswerId = $("#student_answer_"+qId).val(); 
            if(studentAnswerId > 0) {
                answered = parseInt(answered) - 1;
                $(".answered-btn").text(answered);
                notAnswered = parseInt(notAnswered) + 1;
                $(".not-answered-btn").text(notAnswered);
            }

            $(".mark-"+qId).addClass('hide');
            $(".unmark-"+qId).removeClass('hide');

            $(".qbutton-"+qId).removeClass('btn-secondary btn-success').addClass('btn-danger');
        }else {
            marked = parseInt(marked) - 1;
            $(".mark-"+qId).removeClass('hide');
            $(".unmark-"+qId).addClass('hide');

            $(".qbutton-"+qId).removeClass('btn-danger').addClass('btn-secondary');
        }

        $("#student_answer_"+qId).val(0);
        $(".marked-btn").text(marked);
        $(".wrapper-"+qId+" input[type=radio]").prop('checked', false);
    }

    function saveToStdExam()
    {
        $.ajax({
                type: 'get',
                url:`/exams/unnormal_stop/${studentExam}`,
                data: {
                    course_id : courseId,
                    module_id : moduleId,
                    exam_id   : examId,
                },
                success : function(response){
                   console.log(response);
                }
        });
    }

    document.getElementById("show_exam").addEventListener("click", function() {
        window.onbeforeunload = "";
        location.href = "/exam_result/"+examId+"?course_id="+courseId+"&module_id="+moduleId+"&exam_id="+examId+"&student_exam="+studentExam;
    });

    

    (function(window, location) {
        history.replaceState(null, document.title, location.pathname+"#!/history");
        history.pushState(null, document.title, location.pathname);
        
        window.addEventListener("popstate", function() {
        if(location.hash === "#!/history") {
            history.replaceState(null, document.title, location.pathname);
            setTimeout(function(){
                var result = confirm("Are you sure leave now?");
                if(result) {
                    location.replace("/exam_result?course_id="+courseId+"&module_id="+moduleId+"&exam_id="+examId+"&student_exam="+studentExam);
                }
            
            },10);
        }
        }, false);
    }(window, location));

    function disableBack() { 
        window.history.forward();
    }
    setTimeout("disableBack()", 0);
    window.onunload = function () { null };

</script>
@endpush
