@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Blog Categories</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
    {!! Form::open(array('route' => 'blog-categories.store','method'=>'POST')) !!}
      <div class="card-header">
          <div class="card-title">
            Category Create
          </div>
      </div>
      <div class="card-body" >
    
        
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Category Name <span class="text-danger">*</span></label>
                    {!! Form::text('category_name', old('category_name'), ['placeholder' => 'Enter Category Name','class' => 'form-control', 'required'=>true]) !!}
                    @if ($errors->has('category_name'))
                        <span class="text-danger validate-message">{{ $errors->first('category_name') }}</span>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary brand-btn-color">Save</button>
                    <a href="{{route('blog-categories.index')}}" class="btn btn-default"> Cancel </a>
                </div>
            </div>
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

</script>
@endpush