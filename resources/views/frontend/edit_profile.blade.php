@extends('layouts.app')

@section('title'){!! "Edit Profile -" !!} @stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container profile-edit-page py-4">
        <div class="card">
            {!! Form::model($user, ['method' => 'PATCH','route' => ['profile_update', $user->id], 'enctype'=>'multipart/form-data', 'files'=>true]) !!}
            <div class="card-header">
                <h3 class="card-title">
                    Edit Profile
                </h3>
            </div>
            <div class="card-body">
                
                <div class="row">
                    
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <strong>Name: <span class="text-danger">*</span></strong>
                            {!! Form::text('name', null, array('placeholder' => 'Full Name','class' => 'form-control', 'required'=>true)) !!}
                            @if ($errors->has('name'))
                                <span class="text-danger validate-message">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            {!! Form::email('email', old('email'), array('placeholder' => 'Email','class' => 'form-control', 'required'=>true)) !!}
                            @if ($errors->has('email'))
                                <span class="text-danger validate-message">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Mobile <span class="text-danger">*</span></label>
                            {!! Form::text('phone', old('phone'), array('placeholder' => 'Phone','class' => 'form-control', 'required'=>true)) !!}
                            @if ($errors->has('phone'))
                                <span class="text-danger validate-message">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Second Phone</label>
                            {!! Form::text('second_phone', old('second_phone'), array('placeholder' => 'Second Phone','class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>NRC <span class="text-danger">*</span></label>
                            {!! Form::text('nrc', old('nrc'), array('placeholder' => 'NRC','class' => 'form-control')) !!}
                            @if ($errors->has('nrc'))
                                <span class="text-danger validate-message">{{ $errors->first('nrc') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Passport</label>
                            {!! Form::text('passport', old('passport'), array('placeholder' => 'Passport','class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <label for="">Gender</label>
                        <div class="form-group">
                            <label for="male" style="margin-right: 20px">
                                <input type="radio" name="gender" id="male" value="M" {{($user->gender == "M")? 'checked' : '' }}> Male
                            </label>
                            <label for="female">
                                <input type="radio" name="gender" id="female" value="F" {{($user->gender == "F")? 'checked' : '' }}> Female
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Date of Birth <small>(mm/dd/yyyy)</small></label>
                            {!! Form::date('dob', ($user->dob)? date('Y-m-d', strtotime($user->dob)) : old('dob'), array('class' => 'form-control', 'id'=>"dob", 'autocomplete'=>"off")) !!}
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="highest_qualification">Highest Qualification</label>
                            <select name="highest_qualification" id="highest_qualification" class="form-control">
                                <option value="">Choose</option>
                                @foreach($qualifications as $key=>$quali)
                                @if($key == $user->highest_qualification)
                                    <option value="{{$key}}" selected>{{$quali}}</option>
                                @else
                                    <option value="{{$key}}">{{$quali}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        {{-- <div class="form-group">
                            <label>Role <span class="text-danger">*</span></label>
                            {!! Form::select('role', $roles,$userRole, array('class' => 'form-control select2bs4', 'placeholder'=>'Select Role', 'required'=>true)) !!}
                            @if ($errors->has('role'))
                                <span class="text-danger validate-message">{{ $errors->first('role') }}</span>
                            @endif
                        </div> --}}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Guardian Name </label>
                            {!! Form::text('guardian_name', old('guardian_name'), array('placeholder' => 'Guardian Name','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Guardian Contact No</label>
                            {!! Form::text('guardian_contact_no', old('guardian_contact_no'), array('placeholder' => 'Guardian Contact No','class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Region/State</label>
                            {!! Form::select('region_id', $regions, old('region_id'), array('placeholder' => 'Region','class' => 'form-control', 'id'=>'region_id')) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Township</label>
                            {!! Form::select('township_id', $townships, old('township_id'), array('placeholder' => 'Township','class' => 'form-control', 'id'=>'township_id')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Permanent Address</label>
                            {!! Form::text('address', old('address'), array('class' => 'form-control', 'placeholder'=>'Address')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Correspondence Address</label>
                            {!! Form::text('correspondence_address', old('correspondence_address'), array('class' => 'form-control', 'placeholder'=>'Correspondence Address')) !!}
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
                    </div>
                </div>


                {{-- <div class="row">
                    <div class="col-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Filename</th>
                                    <th>Upload</th>
                                    <th>Current File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Photo (Passport Size)</td>
                                    <td> 
                                        
                                        <input type="file" name="photo" class="dropify" id="photo" @if(!empty($user->photo)) data-default-file="{{url('uploads/'.$user->photo)}}" @endif accept="image/*;capture=camera,.pdf" data-allowed-file-extensions="jpg jpeg png pdf"/>
                                        
                                    </td>
                                    <td> @if($user->photo) <img src="{{url('uploads/'.$user->photo)}}" alt="PSM User" width="80px"> @endif </td>
                                </tr>
                                <tr>
                                    <td>Citizenship Card (Front & Back)</td>
                                    <td> 
                                        
                                        <input type="file" name="citizenship_card" class="dropify" id="citizenship_card" @if(!empty($user->citizenship_card)) data-default-file="{{url('uploads/user_files/'.$user->citizenship_card)}}" @endif accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                        
                                    </td>
                                    <td> 
                                        @if($user->citizenship_card)
                                            @php
                                                $citizenship_extension = explode('.',$user->citizenship_card);
                                            @endphp
                                            @if($citizenship_extension[1] == "pdf")
                                                <a href="{{url('uploads/user_files/'.$user->citizenship_card)}}" target="_blank" title="citizenship card" download="{{url('uploads/user_files/'.$user->citizenship_card)}}"><img src="{{asset('assets/images/PDF_file_icon.png')}}" alt="PSM User" width="80px"> </a>
                                            @else
                                                <img src="{{url('uploads/user_files/'.$user->citizenship_card)}}" alt="PSM User" width="50px"> 
                                            @endif
                                        @endif 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Passport (First Page)</td>
                                    <td> 
                                        
                                        <input type="file" name="passport_photo" class="dropify" id="passport_photo" @if(!empty($user->passport_photo)) data-default-file="{{url('uploads/user_files/'.$user->passport_photo)}}" @endif accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                        
                                    </td>
                                    <td> 
                                        @if($user->passport_photo)
                                            @php
                                                $passport_extension = explode('.',$user->passport_photo);
                                            @endphp
                                            @if($passport_extension[1] == "pdf")
                                                <a href="{{url('uploads/user_files/'.$user->passport_photo)}}" target="_blank" title="passport photo" download="{{url('uploads/user_files/'.$user->passport_photo)}}"><img src="{{asset('assets/images/PDF_file_icon.png')}}" alt="PSM User" width="80px">  </a>
                                            @else
                                                <img src="{{url('uploads/user_files/'.$user->passport_photo)}}" alt="PSM User" width="50px"> 
                                            @endif
                                        @endif 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Highest Qualifications</td>
                                    <td> 
                                        
                                        <input type="file" name="qualification_photo" class="dropify" id="qualification_photo" @if(!empty($user->qualification_photo)) data-default-file="{{url('uploads/user_files/'.$user->qualification_photo)}}" @endif accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                        
                                    </td>
                                    <td>
                                        @if($user->qualification_photo)
                                            @php
                                                $qualification_extension = explode('.',$user->qualification_photo);
                                            @endphp
                                            @if($qualification_extension[1] == "pdf")
                                                <a href="{{url('uploads/user_files/'.$user->qualification_photo)}}" target="_blank" title="passport photo" download="{{url('uploads/user_files/'.$user->qualification_photo)}}"><img src="{{asset('assets/images/PDF_file_icon.png')}}" alt="PSM User" width="80px">  </a>
                                            @else
                                                <img src="{{url('uploads/user_files/'.$user->qualification_photo)}}" alt="PSM User" width="50px"> 
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Transcripts</td>
                                    <td> 
                                        
                                        <input type="file" name="transcript_photo" class="dropify" id="transcript_photo" @if(!empty($user->transcript_photo)) data-default-file="{{url('uploads/user_files/'.$user->transcript_photo)}}" @endif accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                        
                                    </td>
                                    <td> 
                                        @if($user->transcript_photo)
                                            @php
                                                $transcript_extension = explode('.',$user->transcript_photo);
                                            @endphp
                                            @if($transcript_extension[1] == "pdf")
                                                <a href="{{url('uploads/user_files/'.$user->transcript_photo)}}" target="_blank" title="passport photo" download="{{url('uploads/user_files/'.$user->transcript_photo)}}"><img src="{{asset('assets/images/PDF_file_icon.png')}}" alt="PSM User" width="80px">  </a>
                                            @else
                                                <img src="{{url('uploads/user_files/'.$user->transcript_photo)}}" alt="PSM User" width="50px"> 
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Language Certificate</td>
                                    <td> 
                                        
                                        <input type="file" name="lang_certificate_photo" class="dropify" id="lang_certificate_photo" @if(!empty($user->lang_certificate_photo)) data-default-file="{{url('uploads/user_files/'.$user->lang_certificate_photo)}}" @endif accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                        
                                    </td>
                                    <td> 
                                        @if($user->lang_certificate_photo)
                                            @php
                                                $lang_certificate_extension = explode('.',$user->lang_certificate_photo);
                                            @endphp
                                            @if($lang_certificate_extension[1] == "pdf")
                                                <a href="{{url('uploads/user_files/'.$user->lang_certificate_photo)}}" target="_blank" title="passport photo" download="{{url('uploads/user_files/'.$user->lang_certificate_photo)}}"><img src="{{asset('assets/images/PDF_file_icon.png')}}" alt="PSM User" width="80px">  </a>
                                            @else
                                                <img src="{{url('uploads/user_files/'.$user->lang_certificate_photo)}}" alt="PSM User" width="50px"> 
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col-12">
                        <div class="form-group text-right">
                            <a href="{{route('profile', $user->id)}}" class="btn btn-secondary"> Cancel </a>
                            <button type="submit" class="btn btn-primary brand-btn-color">Update</button>
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
    $('.textarea').summernote({
        height: 100,
        width:'100%',
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link']],
        ]
    });

    $("#region_id").select2({
      theme: 'bootstrap4',
      placeholder: "Select Region"
    });
    $("#township_id").select2({
      theme: 'bootstrap4',
      placeholder: "Select Township"
    });

    $("#region_id").on('change', function() {
        var region_id = $("#region_id").val();

        $.ajax({
          url: '/admin/get_township/',
          type: 'get',
          data: {
                'region_id': region_id,
            },
          success: function (data) {
              console.log(data);
            $('#township_id').empty();
            $('#township_id').select2({
                theme: 'bootstrap4',
                placeholder: "Select Township",
                data: data,
            });
          }
        });
    });

});

</script>
@endpush