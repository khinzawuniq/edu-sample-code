@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Roles</h1>
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
            Role Detail
          </div>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-striped table-hover">
                  <tbody>
                      <tr>
                          <th width="200px">Name</th>
                          <td width="30px">:</td>
                          <td> {{$role->name}} </td>
                      </tr>
                      <tr>
                          <th width="200px">Permissions</th>
                          <td width="30px">:</td>
                          <td> 
                            @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $v)
                                    <label class="label label-success">{{ $v->name }},</label>
                                @endforeach
                            @endif
                          </td>
                      </tr>
                  </tbody>
              </table>
            </div>
      </div>
      <div class="card-footer">
        <a href="{{route('roles.index')}}" class="btn btn-info">Back</a>
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
