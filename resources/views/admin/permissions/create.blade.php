@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Permissions</h1>
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
            Permission Create
          </div>
      </div>
      <div class="card-body">
        {{-- @can('permission-create') --}}
        {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    @if(!$roles->isEmpty())
                        <h4>Assign Permission to Roles</h4>

                        @foreach ($roles as $role) 
                            {{-- {{ Form::checkbox('roles[]',  $role->id ) }}
                            {{ Form::label($role->name, ucfirst($role->name)) }}<br> --}}
                            <label for="role_id_{{$role->id}}">
                              <input type="checkbox" name="roles[]" id="role_id_{{$role->id}}" value="{{$role->id}}"> {{ucfirst($role->name)}}
                            </label> <br>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{route('permissions.index')}}" class="btn btn-default"> Cancel </a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        {{-- @endcan --}}
      </div>
  </div>

</section>
<!-- /.content -->

@endsection