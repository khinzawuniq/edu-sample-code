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
    {!! Form::open(array('route' => 'users.store','method'=>'POST', 'enctype'=>'multipart/form-data', 'files'=>true)) !!}
      <div class="card-header">
          <div class="card-title">
            User Create
          </div>
          {{-- <div class="float-right">
            <label for="is_active" class="mb-0">
                {!! Form::checkbox('is_active', 0, false,['id'=>'is_active']) !!} Suspended Account
            </label>
          </div> --}}
      </div>
      <div class="card-body" >
    
        <div class="row">
            {{-- <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Username <span class="text-danger">*</span> <small>Not allow character spacing.</small> </label>
                    {!! Form::text('username', old('username'), ['placeholder' => 'Username','class' => 'form-control', 'required'=>true]) !!}
                    @if ($errors->has('username'))
						<span class="text-danger validate-message">{{ $errors->first('username') }}</span>
					@endif
                </div>
            </div> --}}
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Name <span class="text-danger">*</span></label>
                    {!! Form::text('name', old('name'), ['placeholder' => 'Full Name','class' => 'form-control', 'required'=>true]) !!}
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
                    {!! Form::select('role', $roles, old('role'), array('class' => 'form-control select2bs4', 'placeholder'=>'Select Role', 'required'=>true)) !!}
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
                    {!! Form::text('nrc', old('nrc'), array('placeholder' => 'NRC','class' => 'form-control', 'required'=>true)) !!}
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
                        <input type="radio" name="gender" id="male" value="M" checked="checked"> Male
                    </label>
                    <label for="female">
                        <input type="radio" name="gender" id="female" value="F"> Female
                    </label>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Date of Birth <small>(mm/dd/yyyy)</small></label>
                    {!! Form::date('dob', old('dob'), array('class' => 'form-control', 'id'=>"dob", 'autocomplete'=>"off")) !!}
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
                            <option value="{{$key}}">{{$quali}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Role <span class="text-danger">*</span></label>
                    {!! Form::select('role', $roles, old('role'), array('class' => 'form-control select2bs4', 'placeholder'=>'Select Role', 'required'=>true)) !!}
                    @if ($errors->has('role'))
                        <span class="text-danger validate-message">{{ $errors->first('role') }}</span>
                    @endif
                </div>
                {{-- <div class="form-group">
                    <label>Password </label>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control' )) !!}
                    <small style="line-height: 1;">The password must have at least 8 characters, at least 1 digit(s), at least 1 lower case letter(s), at least 1 upper case letter(s), at least 1 non-alphanumeric character(s) such as as *, -, or #</small>
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
                    <label>Description</label>
                    {!! Form::textarea('description', old('description'), array('class' => 'form-control textarea', 'placeholder'=>'Description')) !!}
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-sm-6 col-12">
                <div class="form-group">
                    <label for="">Photo</label> <br>
                    <input type="file" name="photo" class="dropify" id="photo" accept="image/*;capture=camera" data-allowed-file-extensions="jpg jpeg png"/>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12"></div>
        </div> --}}
        {{-- <div class="row mt-3">
            <div class="col-12">
                <h4>Additional Info</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-6"><label for="additional_label">Label</label></div>
            <div class="col-6"><label for="additional_value">Value</label></div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                <div class="additional-row-wrapper">
                    <input type="hidden" name="count_row" id="count_row">
                    <div class="row mb-2 row_1">
                        <div class="col-md-5 col-sm-5 col-12">
                            <input type="text" name="additional_label[]" id="additional_label_1" class="form-control">
                        </div>
                        <div class="col-md-5 col-sm-5 col-12">
                            <input type="text" name="additional_value[]" id="additional_value_1" class="form-control">
                        </div>
                        
                    </div>
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Photo (Passport Size)</td>
                            <td> 
                                {{-- <input type="file" name="photo" id="photo">  --}}
                                <input type="file" name="photo" class="dropify" id="photo" accept="image/*;capture=camera,.jpg,.jpeg,.png,.pdf" data-allowed-file-extensions="jpg jpeg png pdf"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="photo" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="photo" class="form-control" type="text" name="photo">
                                </div> --}}
                            </td>
                        </tr>
                        <tr>
                            <td>Citizenship Card (Front & Back)</td>
                            <td> 
                                {{-- <input type="file" name="citizenship_card" id="citizenship_card"> --}}
                                <input type="file" name="citizenship_card" class="dropify" id="citizenship_card" accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="citizenship_card" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="citizenship_card" class="form-control" type="text" name="citizenship_card">
                                </div> --}}
                            </td>
                        </tr>
                        <tr>
                            <td>Passport (First Page)</td>
                            <td> 
                                {{-- <input type="file" name="passport_photo" id="passport_photo"> --}}
                                <input type="file" name="passport_photo" class="dropify" id="passport_photo" accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="passport_photo" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="passport_photo" class="form-control" type="text" name="passport_photo">
                                </div> --}}
                            </td>
                        </tr>
                        <tr>
                            <td>Highest Qualifications</td>
                            <td> 
                                {{-- <input type="file" name="qualification_photo" id="qualification_photo"> --}}
                                <input type="file" name="qualification_photo" class="dropify" id="qualification_photo" accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="passport_photo" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="passport_photo" class="form-control" type="text" name="passport_photo">
                                </div> --}}
                            </td>
                        </tr>
                        <tr>
                            <td>Transcripts</td>
                            <td> 
                                {{-- <input type="file" name="transcript_photo" id="transcript_photo"> --}}
                                <input type="file" name="transcript_photo" class="dropify" id="transcript_photo" accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="transcript_photo" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="transcript_photo" class="form-control" type="text" name="transcript_photo">
                                </div> --}}
                            </td>
                        </tr>
                        <tr>
                            <td>Language Certificate</td>
                            <td> 
                                {{-- <input type="file" name="lang_certificate_photo" id="lang_certificate_photo"> --}}
                                <input type="file" name="lang_certificate_photo" class="dropify" id="lang_certificate_photo" accept="image/*;capture=camera,.pdf,.doc,.docx,.xls,.xlsx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.ppt, .pptx, application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.slideshow" data-allowed-file-extensions="jpg jpeg png pdf doc docx xls xlsx ppt pptx"/>
                                {{-- <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="lang_certificate_photo" data-preview="holder" class="btn btn-primary lfm text-white">
                                     <i class="far fa-image"></i> Choose
                                    </a>
                                    </span>
                                    <input id="lang_certificate_photo" class="form-control" type="text" name="lang_certificate_photo">
                                </div> --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary brand-btn-color">Save</button>
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
    $('.lfm').filemanager('file');

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

    // var countAdditional = 1;
    // var countRow = 0;

    // function setAdditionalRow()
    // {
    //     countRow = countAdditional + 1;
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