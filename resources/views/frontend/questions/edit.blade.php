@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<div class="container course-page py-4">
    <div class="card">
        <div class="card-header">
        <h3>Question</h3>
        </div>
        <div class="card-body">
            {!! Form::Model($question, ['route'=>['questions.update', $question->id], 'method'=>'PATCH']) !!}
                <input type="hidden" name="course_id" id="course_id" value="{{$question->course_id}}">
                <input type="hidden" name="module_id" id="module_id" value="{{$question->module_id}}">
                <input type="hidden" name="exam_id" id="exam_id" value="{{$question->exam_id}}">
                <input type="hidden" name="question_type" id="question_type" value="{{$question->question_type}}">

                <input type="hidden" name="question_group_id" id="question_group_id" value="{{$question->question_group_id}}">
                <input type="hidden" name="question_group_name" id="question_group_name" value="{{$question->question_group_name}}">
                
                {{-- <div class="form-group">
                    <label for="question_group">Question Group Name <span class="text-danger">*</span></label>
                    {!! Form::select('question_group_id', $group_names, old('question_group_id'), ['class'=>'form-control','id'=>'question_group_id', 'required'=>true]) !!}
                </div> --}}

                <div class="form-group">
                    <label for="">Question <span class="text-danger">*</span></label>
                    <input type="text" name="question" id="question" class="form-control" value="{{$question->question}}" required>
                </div>
                @if($question->question_type == 'multiple_choice')

                <input type="hidden" name="correct_answer" id="correct_answer" value="{{$question->correct_answer}}">

                @if(count($question_answers) > 0)
                @foreach($question_answers as $key=>$answer)
                <input type="hidden" name="answer_id[]" value="{{$answer->id}}">
                <div class="form-group">
                    <label for="choice_{{$key+1}}">Choice {{$key+1}} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="choice[]" id="choice_{{$key+1}}" class="form-control mr-3" value="{{$answer->answer}}" required>
                        <label for="correct_answer_{{$key+1}}">
                        <input type="radio" name="correct" id="correct_answer_{{$key+1}}" value="{{$key+1}}" class="correct-answer" {{($question->correct_answer == $answer->answer)? 'checked': ''}} > Correct Answer
                        </label>
                    </div>
                </div>
                @endforeach
                @else
                
                <div class="form-group">
                    <label for="choice_1">Choice 1 <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="choice[]" id="choice_1" class="form-control mr-3" required>
                        <label for="correct_answer_1">
                        <input type="radio" name="correct" id="correct_answer_1" value="1" class="correct-answer"> Correct Answer
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="choice_2">Choice 2 <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="choice[]" id="choice_2" class="form-control mr-3" required>
                        <label for="correct_answer_2">
                            <input type="radio" name="correct" id="correct_answer_2" value="2" class="correct-answer"> Correct Answer
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="choice_3">Choice 3 <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="choice[]" id="choice_3" class="form-control mr-3" required>    
                        <label for="correct_answer_3">
                            <input type="radio" name="correct" id="correct_answer_3" value="3" class="correct-answer"> Correct Answer
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="choice_4">Choice 4 <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="choice[]" id="choice_4" class="form-control mr-3" required>
                        <label for="correct_answer_4">
                            <input type="radio" name="correct" id="correct_answer_4" value="4" class="correct-answer"> Correct Answer
                        </label>
                    </div>
                </div>

                @endif

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="answer_no_style">Numbering Style <span class="text-danger">*</span></label>
                            <select name="answer_no_style" id="answer_no_style" class="form-control" required>
                                <option value=""></option>
                                @foreach(config('services.numbering_style') as $key=>$val)
                                    <option value="{{$key}}" {{($question->answer_no_style == $key)? 'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="mark">Mark <span class="text-danger">*</span></label>
                            <input type="number" name="mark" id="mark" class="form-control" value="{{$question->mark}}" required>
                        </div>
                    </div>
                </div>

                @endif

                @if($question->question_type == 'true_false')
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="">True / False</label> <br>
                                <label for="true" class="mr-4">
                                    <input type="radio" name="correct_answer" id="true" value="true" {{($question->correct_answer == 'true')? 'checked':''}}> True
                                </label>
                                <label for="false">
                                    <input type="radio" name="correct_answer" id="false" value="false" {{($question->correct_answer == 'false')? 'checked':''}}> False
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="mark">Mark <span class="text-danger">*</span></label>
                                <input type="number" name="mark" id="mark" class="form-control" value="{{$question->mark}}" required>
                            </div>
                        </div>
                    </div>
                    
                @endif

            <button type="submit" class="btn btn-primary px-5">Save</button>
            @if($question_group_id == 0)
                <a href="{{url('/exams/question_list/'.$question->exam_id.'?course_id='.$question->course_id.'&module_id='.$question->module_id)}}" class="btn btn-light px-5" >Cancel</a>
            @else
                <a href="{{ url()->previous() }}" class="btn btn-light px-5" >Cancel</a>
            @endif
            
            {{-- <a href="{{url('/courses/detail/'.$question->course_id.'?module_id='.$question->module_id)}}" class="btn btn-light px-5">Cancel</a> --}}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script>
$(document).ready(function() {
    $(function(){
       $(".correct-answer").click(function() {
        var answer_no = $(this).val();
        var correct_answer = $("#choice_"+answer_no).val();
        $("#correct_answer").val(correct_answer);
       });
    });
});
</script>
@endpush
