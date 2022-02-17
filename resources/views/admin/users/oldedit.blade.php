@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Users</h1>
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
            User Edit
          </div>
      </div>
      <div class="card-body">
        {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id], 'enctype'=>'multipart/form-data', 'files'=>true]) !!}
        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <strong>Username: <span class="text-danger">*</span> </strong>
                    {!! Form::text('username', null, ['placeholder' => 'UserName','class' => 'form-control', 'required'=>true]) !!}
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <strong>Name: <span class="text-danger">*</span></strong>
                    {!! Form::text('name', null, array('placeholder' => 'Full Name','class' => 'form-control', 'required'=>true)) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <strong>Mobile: <span class="text-danger">*</span></strong>
                    {!! Form::text('phone', null, array('placeholder' => 'Phone','class' => 'form-control', 'required'=>true)) !!}
                </div>
          </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <strong>Email: <span class="text-danger">*</span></strong>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'required'=>true)) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
              
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <strong>Role: <span class="text-danger">*</span></strong>
                    {!! Form::select('role', $roles,$userRole, array('class' => 'form-control select2bs4', 'placeholder'=>'Select Role')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <strong>Password: </strong>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                    <small style="line-height: 1;">The password must have at least 8 characters, at least 1 digit(s), at least 1 lower case letter(s), at least 1 upper case letter(s), at least 1 non-alphanumeric character(s) such as as *, -, or #</small>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
              <div class="form-group">
                  <strong>City:</strong>
                  {!! Form::text('city', null, array('placeholder' => 'City','class' => 'form-control')) !!}
              </div>
            </div>
        </div>

        <div class="row">
          <div class="col-12">
              <div class="form-group">
                  <strong>Address:</strong>
                  {!! Form::text('address', null, array('class' => 'form-control', 'placeholder'=>'Address')) !!}
              </div>
          </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    {!! Form::textarea('description', null, array('class' => 'form-control textarea', 'placeholder'=>'Description')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-12">
                <div class="form-group">
                    <label for="">Photo:</label> <br>
                    @if(!empty($user->photo))
                    <input type="file" name="photo" class="dropify" id="photo" data-default-file="{{url('uploads/'.$user->photo)}}" accept="image/*;capture=camera" data-allowed-file-extensions="jpg jpeg png"/>
                    @else
                    <input type="file" name="photo" class="dropify" id="photo" accept="image/*;capture=camera" data-allowed-file-extensions="jpg jpeg png"/>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <br>
                    <label for="">
                        {!! Form::checkbox('is_active', null, (($user->is_active)? 'checked':'') ) !!} Is Active
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary brand-btn-color">Update</button>
                    <a href="{{route('users.index')}}" class="btn btn-default"> Cancel </a>
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
$(document).ready(function() {
    $(".select2bs4").select2({
      theme: 'bootstrap4',
      placeholder: "Select Role"
    });
});

</script>
@endpush