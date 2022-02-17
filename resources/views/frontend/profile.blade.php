@extends('layouts.app')

@section('title'){!! "Profile -" !!} @stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container profile-page py-4">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-body">
                            {{-- <div class="row">
                                <div class="col-6"></div>
                            </div> --}}
                            <div class="profile-photo">
                                @if($user->photo)
                                <img class="profile-user-img img-fluid img-circle mr-3" src="{{url('uploads/'.$user->photo)}}" width="120px" alt="PSM Student Profile">
                                @else
                                <img class="profile-user-img img-fluid img-circle mr-3" src="{{url('/assets/images/defaultuser.png')}}" width="120px" alt="PSM Student Profile">
                                @endif
                                <span class="upload-photo" data-toggle="modal" data-target="#uploadPhotoModal"><i class="fas fa-camera"></i></span>
                                <span class="profile-name">{{$user->name}}</span>
                            </div>
                            
                            <div class="change-password-wrapper">
                                <a href="{{url('/profile/edit/'.$user->id)}}" class="btn btn-primary">Edit Profile</a>
                                <a href="{{url('my_password/reset/'.$user->id)}}" class="btn btn-primary">Change Password</a>
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
                                    <th width="200px">Region</th>
                                    <td width="30px">:</td>
                                    <td> {{$user->region->name}} </td>
                                  </tr>
                                  <tr>
                                    <th width="200px">Township</th>
                                    <td width="30px">:</td>
                                    <td> {{$user->township->name}} </td>
                                  </tr>
                                  {{-- <tr>
                                    <th width="200px">City</th>
                                    <td width="30px">:</td>
                                    <td> {{$user->city}} </td>
                                  </tr> --}}
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
                        {{-- <div class="card-footer">
                          <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning">Edit</a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-6 col-ms-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Login Activity</h5>
                            
                            <div class="form-group first-access">
                                <label>First access to site</label><br>
                                {{($first_access)?date('l, j F Y',strtotime($first_access->login)) : '-'}}
                            </div>
                            <div class="form-group last-access">
                                <label>Last access to site</label><br>
                                {{($last_access)?date('l, j F Y', strtotime($last_access->login)) : '-'}}
                            </div>
                            <div class="form-group last-ip">
                                <label>Last IP address</label><br>
                                {{($last_access)? $last_access->ipaddress : '-'}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" role="dialog" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center" id="uploadPhotoModalLabel">Update Profile Picture</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            {!! Form::model($user, ['method' => 'PATCH','route' => ['update_profile_photo', $user->id], 'enctype'=>'multipart/form-data', 'files'=>true]) !!}
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="">Photo:</label> <br>
                    <input type="file" name="photo" class="dropify" id="photo" accept="image/*;capture=camera" data-allowed-file-extensions="jpg jpeg png"/>
                </div>
                
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            {!! Form::close() !!}
        </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    .profile-page .card-body {
        display: table;
        width: 100%;
    }
    .profile-photo, .change-password-wrapper {
        display: table-cell;
        vertical-align: bottom;
        position: relative;
    }
    .change-password-wrapper {
        text-align: right;
    }
    .upload-photo {
        font-size: 1.2rem;
        padding: 3px 8px;
        border-radius: 50%;
        background: #dee2e6;
        position: absolute;
        bottom: -5px;
        left: 105px;
    }
    .upload-photo:hover {
        cursor: pointer;
        color: #1877f2;
    }
    .profile-photo .img-circle {
        border-radius: 50%;
    }
</style>
@endpush