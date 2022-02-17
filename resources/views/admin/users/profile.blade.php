@extends('layouts.admin-app')


@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="profile-photo">
                                <img class="profile-user-img img-fluid img-circle mr-3" src="{{url('/assets/images/defaultuser.png')}}" alt="PSM Student Profile">
                                <span class="profile-name">{{$user->name}}</span>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-ms-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">User Detail</h5>
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
                                  <tr>
                                    <th width="200px">City</th>
                                    <td width="30px">:</td>
                                    <td> {{$user->city}} </td>
                                  </tr>
                                  <tr>
                                    <th width="200px">Address</th>
                                    <td width="30px">:</td>
                                    <td> {{$user->address}} </td>
                                  </tr>
                                  <tr>
                                    <th width="200px">Description</th>
                                    <td width="30px">:</td>
                                    <td> {!!$user->description!!} </td>
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
                </div>
                <div class="col-md-6 col-ms-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Login Activity</h5>
                            
                            <div class="form-group first-access">
                                <label>First access to site</label><br>
                                {{date('l, j F Y',strtotime($first_access->login))}}
                            </div>
                            <div class="form-group last-access">
                                <label>Last access to site</label><br>
                                {{date('l, j F Y', strtotime($last_access->login))}}
                            </div>
                            <div class="form-group last-ip">
                                <label>Last IP address</label><br>
                                {{$last_access->ipaddress}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <!-- /.content -->

@endsection