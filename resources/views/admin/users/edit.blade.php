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
    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id], 'enctype'=>'multipart/form-data', 'files'=>true]) !!}
      <div class="card-header">
          <div class="card-title">
            User Edit
          </div>

          {{-- <div class="float-right">
            <label for="is_active" class="mb-0">
                {!! Form::checkbox('is_active', null, (($user->is_active)? 'checked':'') ) !!} Suspended Account
            </label>
          </div> --}}
      </div>
      <div class="card-body">
        
        <div class="row">
            {{-- <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <strong>Username: <span class="text-danger">*</span> <small>Not allow character spacing.</small></strong>
                    {!! Form::text('username', null, ['placeholder' => 'UserName','class' => 'form-control', 'required'=>true]) !!}
                    @if ($errors->has('username'))
						<span class="text-danger validate-message">{{ $errors->first('username') }}</span>
					@endif
                </div>
            </div> --}}
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

        {{-- <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    {!! Form::email('email', old('email'), array('placeholder' => 'Email','class' => 'form-control', 'required'=>true)) !!}
                    @if ($errors->has('email'))
						<span class="text-danger validate-message">{{ $errors->first('email') }}</span>
					@endif
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Role <span class="text-danger">*</span></label>
                    {!! Form::select('role', $roles,$userRole, array('class' => 'form-control select2bs4', 'placeholder'=>'Select Role', 'required'=>true)) !!}
                    @if ($errors->has('role'))
						<span class="text-danger validate-message">{{ $errors->first('role') }}</span>
					@endif
                </div>
            </div>
        </div> --}}

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
                <div class="form-group">
                    <label>Role <span class="text-danger">*</span></label>
                    {!! Form::select('role', $roles,$userRole, array('class' => 'form-control select2bs4', 'placeholder'=>'Select Role', 'required'=>true)) !!}
                    @if ($errors->has('role'))
						<span class="text-danger validate-message">{{ $errors->first('role') }}</span>
					@endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Password </label>
                    <div class="input-group password-wrapper">
                        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control password' )) !!}
                        <span class="btn-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                        @if ($errors->has('password'))
						    <span class="text-danger validate-message">{{ $errors->first('password') }}</span>
					    @endif
                    </div>
                    <small style="line-height: 1;"> Password ပေးသည့်အခါ အနည်းဆုံး (၆) လုံး ပေးရပါမည်။ </small>
                    {{-- <small style="line-height: 1;"> Password ပေးသည့်အခါ အနည်းဆုံး (၈) လုံး ပေးရပါမည်။ အဆိုပါ (၈) လုံးတွင် အသေးစာလုံးတစ်ခု၊ အကြီးစာလုံးတစ်ခု၊ ကိန်းဂဏန်းတစ်ခု၊ အထူးစာလုံးတစ်ခု ပါရှိရပါမည်။ (ဥပမာ - PsmLms123$) </small> --}}
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12"> </div>
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

        {{-- <div class="row">
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
        </div> --}}

        {{-- <div class="row mt-3">
            <div class="col-12">
                <h4>Additional Info</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-5"><label for="additional_label">Label</label></div>
            <div class="col-5"><label for="additional_value">Value</label></div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                <div class="additional-row-wrapper">
                    @if(count($additional_users) > 0)
                        <input type="hidden" name="count_row" id="count_row" value="{{count($additional_users)}}">
                        @foreach($additional_users as $key=>$addi)
                            <div class="row mb-2 row_{{$key+1}}">
                                <input type="hidden" name="additional_id[]" value="{{$addi->id}}">
                                <div class="col-md-5 col-sm-5 col-12">
                                    <input type="text" value="{{$addi->additional_label}}" name="additional_label[]" id="additional_label_{{$key+1}}" class="form-control">
                                </div>
                                <div class="col-md-5 col-sm-5 col-12">
                                    <input type="text" value="{{$addi->additional_value}}" name="additional_value[]" id="additional_value_{{$key+1}}" class="form-control">
                                </div>
                                <div class="col-md-2 col-sm-2 col-12">
                                    @if($key+1 != 1) <button type="button" class="btn btn-danger btn-sm" onClick="removeAdditionalRow({{$key+1}})">x</button> @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <input type="hidden" name="count_row" id="count_row" value="1">
                        <div class="row mb-2 row_1">
                            <div class="col-md-5 col-sm-5 col-12">
                                <input type="text" name="additional_label[]" id="additional_label_1" class="form-control">
                            </div>
                            <div class="col-md-5 col-sm-5 col-12">
                                <input type="text" name="additional_value[]" id="additional_value_1" class="form-control">
                            </div>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn btn-success btn-xs" onClick="setAdditionalRow()">Add New Info</button>
            </div>
        </div> --}}

        <div class="row">
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
                                {{-- <input type="file" name="photo" id="photo">  --}}
                                <input type="file" name="photo" class="dropify" id="photo" @if(!empty($user->photo)) data-default-file="{{url('uploads/'.$user->photo)}}" @endif accept="image/*;capture=camera,.pdf" data-allowed-file-extensions="jpg jpeg png pdf"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="photo" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="photo" class="form-control" type="text" name="photo" value="{{$user->photo}}">
                                </div> --}}
                            </td>
                            <td> @if($user->photo) <img src="{{url('uploads/'.$user->photo)}}" alt="PSM User" width="80px"> @endif </td>
                        </tr>
                        <tr>
                            <td>Citizenship Card (Front & Back)</td>
                            <td> 
                                {{-- <input type="file" name="citizenship_card" id="citizenship_card">  --}}
                                <input type="file" name="citizenship_card" class="dropify" id="citizenship_card" @if(!empty($user->citizenship_card)) data-default-file="{{url('uploads/user_files/'.$user->citizenship_card)}}" @endif accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="citizenship_card" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="citizenship_card" class="form-control" type="text" name="citizenship_card"  value="{{$user->citizenship_card}}">
                                </div> --}}
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
                                {{-- <input type="file" name="passport_photo" id="passport_photo"> --}}
                                <input type="file" name="passport_photo" class="dropify" id="passport_photo" @if(!empty($user->passport_photo)) data-default-file="{{url('uploads/user_files/'.$user->passport_photo)}}" @endif accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="passport_photo" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="passport_photo" class="form-control" type="text" name="passport_photo" value="{{$user->passport_photo}}">
                                </div> --}}
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
                                {{-- <input type="file" name="qualification_photo" id="qualification_photo">  --}}
                                <input type="file" name="qualification_photo" class="dropify" id="qualification_photo" @if(!empty($user->qualification_photo)) data-default-file="{{url('uploads/user_files/'.$user->qualification_photo)}}" @endif accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="passport_photo" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="passport_photo" class="form-control" type="text" name="passport_photo" value="{{$user->qualification_photo}}">
                                </div> --}}
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
                                {{-- <input type="file" name="transcript_photo" id="transcript_photo">  --}}
                                <input type="file" name="transcript_photo" class="dropify" id="transcript_photo" @if(!empty($user->transcript_photo)) data-default-file="{{url('uploads/user_files/'.$user->transcript_photo)}}" @endif accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="transcript_photo" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="transcript_photo" class="form-control" type="text" name="transcript_photo" value="{{$user->transcript_photo}}">
                                </div> --}}
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
                                {{-- <input type="file" name="lang_certificate_photo" id="lang_certificate_photo">  --}}
                                <input type="file" name="lang_certificate_photo" class="dropify" id="lang_certificate_photo" @if(!empty($user->lang_certificate_photo)) data-default-file="{{url('uploads/user_files/'.$user->lang_certificate_photo)}}" @endif accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="lang_certificate_photo" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="lang_certificate_photo" class="form-control" type="text" name="lang_certificate_photo" value="{{$user->lang_certificate_photo}}">
                                </div> --}}
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
.dropify-wrapper {
    height: 90px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // $(".select2bs4").select2({
    //   theme: 'bootstrap4',
    //   placeholder: "Select Role"
    // });
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

    $('.btn-password').click(function(){
        if('password' == $('.password').attr('type')){
            $('.password').prop('type', 'text');
        }else{
            $('.password').prop('type', 'password');
        }
    });

});

    // var countAdditional = ($('#count_row').val() - 0);

    // function setAdditionalRow()
    // {
    //     var countRow = countAdditional + 1;
    //     $('#count_row').val(countRow);
    //     countAdditional++;

    //     $(".additional-row-wrapper").append(
    //         '<div class="row mb-2 row_'+countRow+'">'+
    //             '<div class="col-md-5 col-sm-5 col-12">'+
    //                 '<input type="text" name="additional_label[]" id="additional_label_'+countRow+'" class="form-control">'+
    //             '</div>'+
    //             '<div class="col-md-5 col-sm-5 col-12">'+
    //                 '<input type="text" name="additional_value[]" id="additional_value_'+countRow+'" class="form-control">'+
    //             '</div>'+
    //             '<div class="col-md-2 col-sm-2 col-12">'+
    //                 '<button type="button" class="btn btn-danger btn-sm" onClick="removeAdditionalRow('+countRow+')">x</button>'+
    //             '</div>'+
    //         '</div>'
    //     );
    // }

    // function removeAdditionalRow(row)
    // {
    //     if(countAdditional == 1)
    //     {
    //         alert('There has to be at least one line');
    //         return false;
    //     }
    //     else
    //     {
    //         $('.row_'+row).remove();
    //         countAdditional--;
    //     }
    // }
</script>
@endpush