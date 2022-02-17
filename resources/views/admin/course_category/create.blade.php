@extends('layouts.admin-app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Course Category</h1>
      </div>
    </div>
  </div>
</div>
<section class="content">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
              Course Category Create
            </div>
        </div>
        <div class="card-body" >
            {!! Form::open(array('route' => 'course_categories.store','method'=>'POST','enctype'=>'multipart/form-data')) !!}
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="name">Course Category Name:</label>
                        {!! Form::text('name', null, ['placeholder' => 'Course Category Name','class' => 'form-control', 'required'=>true]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <label for="image">Course Category Image</label>
                    <div class="form-group">
                        <div class="input-group">
                           <span class="input-group-btn">
                           <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                            <i class="far fa-image"></i> Choose
                           </a>
                           </span>
                           <input id="thumbnail" class="form-control" type="text" name="image">
                        </div> 
                     </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="description">Description:</label>
                        {!! Form::textarea('description', null, ['placeholder' => 'Description','class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <input type="checkbox" name="is_active" id="is_active"> Suspend ?
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="/admin/category-course-management" class="btn btn-default"> Cancel </a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection