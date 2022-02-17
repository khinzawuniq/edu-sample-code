@extends('layouts.app')
@push('styles')
<style>
.group_label {
    font-size: 1.1rem;
    margin-top: 15px;
}
#group_name {
    color: #fff;
    font-size: 1.1rem;
    background-color: #b12418;
    border: 2px solid #333;
    padding: 10px;
    border-radius: 10px;
    text-align: center;
    width: 100%;
    display: inline-block;
}
.result {
    color: #fff;
    font-size: 1.1rem;
    font-weight: bold;
    border: 2px solid #333;
    border-radius: 10px;
    padding: 10px;
    min-width: 60px;
    display: inline-block;
    text-align: center;
}
#total_question {
    background-color: #38c172;
}
#total_mark {
    background-color: #aaa;
}
</style>
@endpush
@section('content')
<div class="container course-page py-4">

    <div class="row mb-4">
        <div class="col-12 text-right">
            <a href="{{url('/courses/detail/'.$exam->course->slug.'?module_id='.$exam->module_id)}}" class="btn btn-secondary btn-sm mb-2">Back</a>
        </div>
    </div>

    <div class="row mt-5 mb-4">
        <div class="col-4 col-sm-3 col-md-3">
            <div class="group_label">Question Group Name</div>
        </div>
        <div class="col-8 col-sm-9 col-md-9">
            <span id="group_name">{{($group)?$group->qgroup->group_name:'-'}}</span>
        </div>
    </div>

    <div class="row" style="margin-top: 80px;margin-bottom: 80px;">
        <div class="col-12 col-sm-6 col-md-6">
            <div class="row">
                <div class="col-6">
                    <div class="group_label">Number of Questions</div>
                </div>
                <div class="col-6">
                    <span class="result" id="total_question"> {{count($questions)}} </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 text-right">
            <div class="row">
                <div class="col-6">
                    <div class="group_label">Total Marks</div>
                </div>
                <div class="col-6">
                    <span class="result" id="total_mark"> {{($total_mark)? $total_mark:0}} </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <strong>Last Updated: {{($group)? date('d M Y, H:i A', strtotime($group->created_at)):'-'}}</strong>
        </div>
    </div>

    {{-- <div class="card mb-3">
        <div class="card-body">
            <h5> {{$exam->course->course_name}} </h5>
        </div>
    </div> --}}

    {{-- @foreach($questions as $key=>$question)
    <div class="card mb-3">
        <div class="card-body">
            <p class="question-title"> {{$key+1}}) {{$question->question}} </p>
            <div class="question-detail-wrapper">
                <div class="question-detail">
                    Question Group Name : {{($question->question_group_id)? $question->groupName->group_name : $question->statusGroupName->group_name}} <br>
                    Question Type : {{$question->question_type}} <br>
                    Mark    : {{$question->mark}}
                </div>
                <div class="action-wrapper">
                    <a href="{{route('questions.edit', $question->id)}}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    <a onclick="deleteQuestion({{$question->id}})" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a>
                    <form action="{{ route('questions.destroy', $question->id) }}" method="post" style="display: none;" class="deleteQuestionDataForm{{$question->id}}">
                       @csrf
                       @method('DELETE')
                   </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach --}}
</div>
@endsection

@push('styles')
<style>
    .question-detail-wrapper {
        display: flex;
    }
    .question-detail {
        margin-right: auto;
    }
    .action-wrapper {
        margin-left: auto;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $(function(){

    });
});
    function deleteQuestion(id){
        var result = confirm("Confirm delete record?");
        if(result) {
            $('.deleteQuestionDataForm'+id).submit();
        }
    }
</script>
@endpush
