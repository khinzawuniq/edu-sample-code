@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Questions Groups</h1>
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
            Questions Group Edit
          </div>
      </div>
      <div class="card-body" >
        {!! Form::model($question_group, ['method' => 'PATCH','route' => ['question-groups.update', $question_group->id]]) !!}

        <div class="form-group">
          <label for="group_name">Question Group Name</label>
          {!! Form::text('group_name', null, ['class'=>'form-control','id'=>'group_name', 'placeholder'=>'Question Group Name', 'required'=>true]) !!}
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary brand-btn-color">Save</button>
            <a href="{{route('question-groups.index')}}" class="btn btn-default"> Cancel </a>
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