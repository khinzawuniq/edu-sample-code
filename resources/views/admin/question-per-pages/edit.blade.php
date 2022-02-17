@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Questions Per Page</h1>
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
            Questions Per Page Edit
          </div>
      </div>
      <div class="card-body" >
        {!! Form::model($questionPerPage, ['method' => 'PATCH','route' => ['question-per-pages.update', $questionPerPage->id]]) !!}

        <div class="form-group">
          <label for="question_per_page">Questions Per Page</label>
          {!! Form::text('question_per_page', null, ['class'=>'form-control','id'=>'question_per_page', 'placeholder'=>'Questions Per Page', 'required'=>true]) !!}
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            {!! Form::text('description', null, ['class'=>'form-control','id'=>'description', 'placeholder'=>'Description', 'required'=>true]) !!}
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary brand-btn-color">Save</button>
            <a href="{{route('question-per-pages.index')}}" class="btn btn-default"> Cancel </a>
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
$(document).ready(function() { 

});
</script>
@endpush