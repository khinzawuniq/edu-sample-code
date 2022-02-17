@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Questions</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
      <div class="card-header">
          <div class="card-title">
            Question Create
          </div>
      </div>
      <div class="card-body" >
        {!! Form::open(array('route' => 'backend-questions.store','method'=>'POST')) !!}

        <input type="hidden" name="course_id" id="course_id" value="0">
        <input type="hidden" name="module_id" id="module_id" value="0">
        <input type="hidden" name="exam_id" id="exam_id" value="0">
        <input type="hidden" name="question_type" id="question_type" value="{{$question_type}}">
        
        <div class="form-group">
            <label for="question_group_id">Question Group Name <span class="text-danger">*</span></label>
            {!! Form::select('question_group_id', $group_names, old('question_group_id'), ['class'=>'form-control','id'=>'question_group_id', 'required'=>true]) !!}
        </div>

        <div class="form-group">
            <label for="">Question <span class="text-danger">*</span></label>
            <input type="text" name="question" id="question" class="form-control" required>
        </div>
        @if($question_type == 'multiple_choice')

        <input type="hidden" name="correct_answer" id="correct_answer">

        <div class="form-group">
            <label for="choice_1">Choice 1 <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" name="choice[]" id="choice_1" class="form-control mr-3" required>
                <label for="correct_answer_1">
                <input type="radio" name="correct" id="correct_answer_1" value="1" class="correct-answer" required> Correct Answer
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="choice_2">Choice 2 <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" name="choice[]" id="choice_2" class="form-control mr-3" required>
                <label for="correct_answer_2">
                    <input type="radio" name="correct" id="correct_answer_2" value="2" class="correct-answer" required> Correct Answer
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="choice_3">Choice 3 <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" name="choice[]" id="choice_3" class="form-control mr-3" required>    
                <label for="correct_answer_3">
                    <input type="radio" name="correct" id="correct_answer_3" value="3" class="correct-answer" required> Correct Answer
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="choice_4">Choice 4 <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" name="choice[]" id="choice_4" class="form-control mr-3" required>
                <label for="correct_answer_4">
                    <input type="radio" name="correct" id="correct_answer_4" value="4" class="correct-answer" required> Correct Answer
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label for="answer_no_style">Numbering Style <span class="text-danger">*</span></label>
                    <select name="answer_no_style" id="answer_no_style" class="form-control" required>
                        <option value=""></option>
                        @foreach(config('services.numbering_style') as $key=>$val)
                            <option value="{{$key}}">{{$val}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label for="mark">Mark <span class="text-danger">*</span></label>
                    <input type="number" name="mark" id="mark" class="form-control" required>
                </div>
            </div>
        </div>

        @endif

        @if($question_type == 'true_false')
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="">True / False</label> <br>
                        <label for="true" class="mr-4">
                            <input type="radio" name="correct_answer" id="true" value="true" required> True
                        </label>
                        <label for="false">
                            <input type="radio" name="correct_answer" id="false" value="false" required> False
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="mark">Mark <span class="text-danger">*</span></label>
                        <input type="number" name="mark" id="mark" class="form-control" required>
                    </div>
                </div>
            </div>
            
        @endif
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary brand-btn-color">Save</button>
            <a href="{{route('backend-questions.index')}}" class="btn btn-default"> Cancel </a>
        </div>

        {!! Form::close() !!}
      </div>
  </div>

</section>
<!-- /.content -->

@endsection

@push('styles')
<style>

</style>
@endpush

@push('scripts')
<script>
$(function(){
  $(".correct-answer").click(function() {
    var answer_no = $(this).val();
    var correct_answer = $("#choice_"+answer_no).val();
    $("#correct_answer").val(correct_answer);
  });

  $("#question_group_id").select2({
    theme: 'bootstrap4',
  });
});

</script>
@endpush