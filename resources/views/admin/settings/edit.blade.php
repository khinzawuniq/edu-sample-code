@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Settings</h1>
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
            Setting Edit
          </div>
      </div>
      <div class="card-body" >
        {!! Form::model($setting, ['method' => 'PATCH', 'route' => ['settings.update', $setting->id]]) !!}

        <div class="row">
          <div class="col-md-6 col-12">
            <label for="image">Default Image</label>
            <div class="form-group">
                <div class="input-group">
                   <span class="input-group-btn">
                   <a id="lfm" data-input="default_image" data-preview="holder" class="btn btn-primary text-white">
                    <i class="far fa-image"></i> Choose
                   </a>
                   </span>
                   <input id="default_image" class="form-control" type="text" name="default_image" value="{{$setting->default_image}}">
                </div>
            </div>
          </div>
          <div class="col-md-6 col-12 text-center border p-1">
            <img src="{{$setting->default_image}}" alt="Default Image" width="100px">
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="email">Default Email *</label>
              {!! Form::email('email', null, ['class'=>'form-control','id'=>'email', 'placeholder'=>'Enter Default Email', 'required'=>true, 'autocomplate'=>'off']) !!}
            </div>    
          </div>
          <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="default_password">Default Password *</label>
              {!! Form::text('default_password', null, ['class'=>'form-control','id'=>'default_password', 'placeholder'=>'Enter Default Password', 'required'=>true, 'autocomplate'=>'off']) !!}
            </div>    
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="first_phone">Primary Phone *</label>
              {!! Form::text('first_phone', null, ['class'=>'form-control','id'=>'first_phone', 'placeholder'=>'Enter Primary Phone', 'required'=>true, 'autocomplate'=>'off']) !!}
            </div>    
          </div>
          <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="second_phone">Secondary Phone *</label>
              {!! Form::text('second_phone', null, ['class'=>'form-control','id'=>'second_phone', 'placeholder'=>'Enter Secondary Phone', 'required'=>true, 'autocomplate'=>'off']) !!}
            </div>    
          </div>
        </div>
        
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label for="map">Google Map *</label>
              {!! Form::textarea('map', null, ['class'=>'form-control','id'=>'map', 'rows'=>4, 'placeholder'=>'Enter IFrame Map', 'required'=>true]) !!}
            </div>    
          </div>
        </div>
        
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label for="email_letter">Email Letter *</label>
              {!! Form::textarea('email_letter', null, ['class'=>'form-control textarea','id'=>'email_letter', 'placeholder'=>'Enter Email Letter', 'required'=>true]) !!}
            </div>    
          </div>
        </div>
        

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary brand-btn-color">Save</button>
            {{-- <a href="{{route('settings.index')}}" class="btn btn-default"> Cancel </a> --}}
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
          ['view', ['fullscreen', 'codeview']],
        ]
    });
});
</script>
@endpush