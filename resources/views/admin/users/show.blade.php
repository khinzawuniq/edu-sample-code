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
              <div class="card-title"> User Detail </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-striped table-hover">
                  <tbody>
                      <tr>
                          <th width="200px">Name</th>
                          <td width="30px">:</td>
                          <td> {{$user->name}} </td>
                      </tr>
                      <tr>
                          <th width="200px">Email</th>
                          <td width="30px">:</td>
                          <td> {{$user->email}} </td>
                      </tr>
                      <tr>
                          <th width="200px">Phone</th>
                          <td width="30px">:</td>
                          <td> {{$user->phone}} </td>
                      </tr>
                      <tr>
                          <th width="200px">Role</th>
                          <td width="30px">:</td>
                          <td> 
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                          </td>
                      </tr>
                  </tbody>
              </table>
              </div>
            </div>
            <div class="card-footer">
              <a href="{{route('users.index')}}" class="btn btn-info">Back</a>
              <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection