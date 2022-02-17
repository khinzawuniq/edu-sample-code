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
            Permission Edit
          </div>
      </div>
      <div class="card-body">
        {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}
        
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
          <div class="col-12">
            <div class="form-group">
              @if(!$roles->isEmpty())
                  <h4>Assign Permission to Roles</h4>
                  @foreach ($roles as $role) 

                    @php $check_value = '' @endphp

                    @foreach($permission_roles as $per_role)
                        @if($role->id == $per_role->role_id)
                          @php $check_value = "checked"; @endphp
                          {{-- <input type="checkbox" name="role_permission_id[]" id="per_role_{{$per_role->role_id}}" value="{{$per_role->role_id}}" checked="checked" style="display:none;"> --}}
                        @endif
                    @endforeach
                    <label for="role_id">
                      <input type="checkbox" name="roles[]" id="role_id_{{$role->id}}" value="{{$role->id}}" {{$check_value}}> {{ucfirst($role->name)}}
                    </label> <br>
                  @endforeach
              @endif
            </div>
          </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{route('permissions.index')}}" class="btn btn-default"> Cancel </a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
      </div>
  </div>

</section>
<!-- /.content -->

@endsection

{{-- @push('scripts')
<script>
$(document).ready(function() {
  @foreach ($roles as $role)
    var roleId = {{$role->id}};
    $("#role_id_"+roleId).change(function() {
      var checkValue = $(this).val();
      if($("#role_id_"+checkValue).prop('checked') == false) {
        $("#per_role_"+checkValue).removeAttr("checked", "checked");
      }else {
        $("#per_role_"+checkValue).attr("checked", "checked");
      }
    });
  @endforeach
});
</script>
@endpush --}}