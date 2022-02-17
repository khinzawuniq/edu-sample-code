@extends('layouts.app')
@push('styles')
<style>
    .exam-title {
        font-size: 1.1rem;
    }
    .exam-detail-label {
        width: 200px;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="container exam-detail-page py-4">
    <div class="row">
        <div class="col-12 text-right">
            <a href="{{url('/courses/detail/'.$exam->course->slug.'?module_id='.$exam->module_id)}}" class="btn btn-secondary btn-sm mb-2">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4><i>{{$exam->exam_name}}</i>  of <strong>{{$exam->course->course_name}}</strong></h4>
        </div>
        <div class="card-body">
            <div class="exam-title mb-3"> {{$exam->exam_name}} </div>
            <div class="exam-description"> {!! ($exam->description)? $exam->description : '' !!} </div>
            <div class="exam-detail mb-4">
                <div class="attempts-allow"> <span class="exam-detail-label">Attempts Allowed</span> :  {{($exam->attempts_allow != 0)? $exam->attempts_allow : 'Unlimited'}} </div>
                <div class="your-allow"> <span class="exam-detail-label">Your Attempt</span> :  {{count($student_exam)}} </div>
                <div class="exam_duration"> <span class="exam-detail-label">Exam Duration</span> :  {{$exam->exam_duration}} {{$exam->duration_type}} </div>
                <div class="number_question"> <span class="exam-detail-label">Number of Question</span> :  {{count($exam->questionAssign)}} </div>
                <div class="passing_mark"> <span class="exam-detail-label">Passing Mark</span> :  {{$exam->passing_mark}} </div>
                {{-- <div class="time-limit"> <span class="exam-detail-label">Time Limit</span> : {{($exam->time_limit != 0)? $exam->time_limit : 'Unlimited'}} {{($exam->time_limit != 0)? $exam->time_type : ''}} </div>
                <div class="grading-method"> <span class="exam-detail-label">Grading Method</span> : @if(!empty($exam->grading_id)) {{$exam->grading->grading_from.' -'}} {{$exam->grading->grading_to.' -'}} {{$exam->grading->grading_description}} @endif </div> --}}
            </div>

            <button class="btn btn-primary btn-sm" id="start_exam" data-toggle="modal" data-target="#startExam">Start Exam</button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="startExam" role="dialog" aria-labelledby="startExamLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-0">
                <h4>Are you sure to take this exam now?</h4>
                <h5>Your time will start automatically.</h5>
                <div class="btn-action-wrapper mt-4 mb-3">
                    <button class="btn btn-primary mr-3" id="start_now" style="width:120px;">Yes, start now!</button>
                    <button class="btn btn-secondary" style="width:120px;" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}
@endsection
@push('scripts')

<script>
$(document).ready(function(){
        var examId = {{$exam->id}};
        var moduleId = {{$exam->module_id}};
        var courseId = {{$exam->course_id}};

        $("#start_now").click(function() {    
            location.href = "/exams/start_exam/"+examId+"?course_id="+courseId+"&module_id="+moduleId;
        });

});

</script>
@endpush