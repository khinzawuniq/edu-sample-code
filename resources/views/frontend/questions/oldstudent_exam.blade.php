@extends('layouts.app')

@section('content')
<div class="container start-exam-page py-4">

    {{-- <div class="row">
        <div class="col-12 text-right">
            <a href="{{url('/courses/detail/'.$exam->course_id.'?module_id='.$exam->module_id)}}" class="btn btn-secondary btn-sm mb-2">Back</a>
        </div>
    </div> --}}

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
            {{-- <div class="question-navigation mb-2">Question Navigation</div> --}}
            <div class="row">
                <div class="col-md-9 col-sm-8 col-12 py-4 px-2">
                    <div class="nav-btn-wrapper mb-3">
                        @foreach($questions as $key=>$question)
                        {{-- @if(count($question->studentAnswer) > 0)
                        @php 
                            $answer_status = false;
                        @endphp
                        @foreach($question->studentAnswer as $key=>$answer)
                            @if($answer->exam_by == Auth::id())
                                @php 
                                    $answer_status = true; 
                                @endphp
                            @endif
                        @endforeach
                            <button class="btn {{($answer_status)?'btn-success':'btn-secondary'}} mr-1 qbutton-{{$question->id}}" id="question_{{$key+1}}"> {{$key+1}} </button>
                        @else
                            <button class="btn btn-secondary mr-1 qbutton-{{$question->id}}" id="question_{{$key+1}}"> {{$key+1}} </button>
                        @endif --}}
                        <button class="btn btn-secondary mr-1 qbutton-{{$question->id}}" id="question_{{$key+1}}"> {{$key+1}} </button>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-12 py-4 px-2 countdown-wrapper">
                    <div class="exam-time-wrapper">
                        <div class="display-time">
                            <h4 class="text-center mb-0">Exam Countdown</h4>
                            <h4 class="countdown px-2 py-2 text-center"><span id="hour">0</span>:<span id="minute"> 60</span>:<span id="second"> 00</span></h4>
                        </div>
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
                        {{-- <div class="stop-exam">
                            <button class="btn btn-danger btn-sm" id="stop_exam">Stop Exam</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="choice-list-wrapper">
        @foreach($questions as $key=>$question)

        <div class="row mb-3 question-{{$question->id}}">
            
            {{-- @if(count($question->studentAnswer) > 0)
                <input type="hidden" name="answer_status" id="answer_status" value="{{($answer_status)?'complete':''}}">
            @else
                <input type="hidden" name="answer_status" id="answer_status">
            @endif --}}
            <input type="hidden" name="answer_status" id="answer_status">
    
            {{-- <div class="col-md-3 col-sm-4 col-12">
                <div class="card question-no">
                    <div class="card-body">
                        <h5>Question {{$key+1}} </h5>
                        <p>
                            Not yet answered 
                            <br>
                            Marked out of {{$question->mark}} <br>
                            Flag question <br>
                        </p>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-12 col-sm-12 col-12">
                <div class="card question-detail bg-light">
                    <div class="card-body">
                        <p class="question-name mb-3"> {{$question->question}} </p>
                        <div class="choice-wrapper">
                            {{-- @php 
                                $answer_choice = null;
                                $answer_question = null;
                            @endphp
                            @foreach($question->studentAnswer as $key=>$answer)
                                @if($answer->exam_by == Auth::id())
                                    @php 
                                        $answer_choice = $answer->choice_answer_id;
                                        $answer_question = $answer->question_id;
                                        $choice_answer = $answer->choice_answer;
                                    @endphp
                                @endif
                            @endforeach --}}
                            @if($question->question_type == 'multiple_choice')
                            @foreach($question->questionAnswer as $key=>$choice)
                            
                                <label for="choice_{{$key+1}}" style="display: block;">
                                    <input type="radio" name="choice_{{$question->id}}" id="choice_{{$key+1}}" onClick="choiceAnswer({{$question->id}}, {{$choice->id}}, {{$student_exam->id}})" value="{{$choice->answer}}"> {{$choice->answer_no}} {{$choice->answer}}
                                    {{-- <input type="radio" name="choice_{{$question->id}}" id="choice_{{$key+1}}" onClick="choiceAnswer({{$question->id}}, {{$choice->id}})" value="{{$choice->answer}}" {{($answer_choice == $choice->id && $answer_question == $choice->question_id)? 'checked':''}}> {{$choice->answer_no}} {{$choice->answer}} --}}
                                </label>
                            
                            @endforeach
                            @endif
    
                            @if($question->question_type == 'true_false')
                            <label for="true">
                                <input type="radio" name="correct_answer_{{$question->id}}" id="true_{{$question->id}}" value="true" onClick="choiceAnswerBoolean({{$question->id}}, 'true', {{$student_exam->id}})"> True
                                {{-- <input type="radio" name="correct_answer_{{$question->id}}" id="true_{{$question->id}}" value="true" onClick="choiceAnswerBoolean({{$question->id}}, 'true', {{$student_exam->id}})" {{($question->id == $answer_question && $choice_answer == 'true')? 'checked':''}}> True --}}
                            </label>
                            <label for="false">
                                <input type="radio" name="correct_answer_{{$question->id}}" id="false_{{$question->id}}" value="false" onClick="choiceAnswerBoolean({{$question->id}}, 'false', {{$student_exam->id}})"> False
                                {{-- <input type="radio" name="correct_answer_{{$question->id}}" id="false_{{$question->id}}" value="false" onClick="choiceAnswerBoolean({{$question->id}}, 'false', {{$student_exam->id}})" {{($question->id == $answer_question && $choice_answer == 'false')? 'checked':''}}> False --}}
                            </label>
                            @endif
                        </div>

                        <div class="mark-review">
                            <button class="btn btn-danger btn-sm" onClick="markReview({{$question->id}})">Mark for review</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @if($exam->question_per_page != 1)
        <div class="row question-pagination mt-5">
            <div class="col-12">
                {!! $questions->links() !!}
            </div>
        </div>
        @endif

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
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $("#navbarSupportedContent").addClass('hide');
    var examId        = {{$exam->id}};
    var courseId      = {{$exam->course_id}};
    var moduleId      = {{$exam->module_id}};
    var studentExam  = {{$student_exam->id}};
    // console.log(examId, courseId, moduleId);
    var duration_type = '{{$exam->duration_type}}';
    var exam_duration = "{{$exam->exam_duration}}";
    var second = 0;
    var minute = 2;
    var hour = 0;
    if(duration_type == 'hours') {
        hour = 1;
        // hour = exam_duration;
        // $("#hour").text(hour);
        $("#hour").text(1);
        $("#minute").text(2);
    }
    if(duration_type == 'minutes') {
        minute = exam_duration;
    }
    var goSecond = false;

    var interval = setInterval(function(){
        if(goSecond == true) {
            second = parseInt(second) + 1;
            $("#second").text(second);
        }
            
        if(second == 60) {
            second = 0;
            minute = minute - 1;
            $("#minute").text(minute);
        }

        if(duration_type == 'hours') {
            if(minute == 0) {
                minute = 2;
                hour = parseInt(hour) - 1;
                $("#minute").text(minute);
                $("#hour").text(hour);
            }

            if(hour == 0) {
                
                if(goSecond == true) {
                    $.ajax({
                        type:'get',
                        url:"/stop_exam",
                        data:{
                            course_id: courseId,
                            module_id: moduleId,
                            exam_id: examId,
                            student_exam: studentExam,
                        },
                        success:function(response){
                            if(response.code == 200) {
                                console.log(response.student_exam);
                                $("#stop_exam").attr('disabled','disabled');
                                $(".choice-list-wrapper").addClass('hide');
                                $(".exam-result-wrapper").removeClass('hide');

                                $("#navbarSupportedContent").removeClass('hide');

                                $(".started-on").text(response.data.start_exam);
                                $(".state").text(response.student_exam.state);
                                $(".completed-on").text(response.data.stop_exam);
                                $(".time-taken").text(response.data.time_taken);
                                // $(".time-taken").text(response.student_exam.time_taken);
                                $(".grade").text(response.student_exam.grade);
                            }
                        }
                    });
                }

                goSecond = false;
            }
        }
    },1000);

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

    $(".not-answered-btn").text({{count($questions)}});
});

$(window).scroll(function () {
    
    var scrollHeight = $(window).scrollTop();
    if(scrollHeight > 100) {
        $("#main-navbar").removeClass('sticky-top');
    }

});

    var answered = 0;
    var notAnswered = {{count($questions)}};
    var marked = 0;

    function choiceAnswer(qId, cId, sExamId)
    {
        $.ajax({
            type:'get',
            url:'/student_answer',
            data:{
                question_id: qId,
                answer_id: cId,
                student_exam_id: sExamId,
            },
            success:function(response){
                if(response.code == 200) {
                    $(".question-"+qId+" #answer_status").val('complete');
                    $(".qbutton-"+qId).removeClass('btn-secondary','btn-danger').addClass('btn-success');
                    answered = parseInt(answered) + 1;
                    $(".answered-btn").text(answered);
                    notAnswered = parseInt(notAnswered) - 1;
                    $(".not-answered-btn").text(notAnswered);
                }
            }
        });
    }
    
    function choiceAnswerBoolean(qId, val, sExamId)
    {
        $.ajax({
            type:'get',
            url:'/student_answer',
            data:{
                question_id: qId,
                choice_answer: val,
                student_exam_id: sExamId,
            },
            success:function(response){
                if(response.code == 200) {
                    $(".question-"+qId+" #answer_status").val('complete');
                    $(".qbutton-"+qId).removeClass('btn-secondary','btn-danger').addClass('btn-success');
                    answered = parseInt(answered) + 1;
                    $(".answered-btn").text(answered);
                    notAnswered = parseInt(notAnswered) - 1;
                    $(".not-answered-btn").text(notAnswered);
                }
            }
        });
    }

    function markReview(qId)
    {
        $(".qbutton-"+qId).removeClass('btn-secondary','btn-success').addClass('btn-danger');
        marked = parseInt(marked) + 1;
        $(".marked-btn").text(marked);
    }
</script>
@endpush
