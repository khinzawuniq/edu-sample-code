@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">SlideShows</h1>
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
            SlideShow Edit
          </div>
      </div>
      <div class="card-body" >
        {!! Form::model($slideShow, ['method' => 'PATCH', 'route' => ['slideshows.update', $slideShow->id], 'enctype'=>'multipart/form-data', 'files'=>true]) !!}
        
        <div class="row">
          <div class="col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <label for="slide_name">Slide Name *</label>
              {!! Form::text('slide_name', $slideShow->slide_name, ['class'=>'form-control','id'=>'slide_name', 'placeholder'=>'Enter Slide Name', 'required'=>true, 'autocomplate'=>'off']) !!}
            </div>    
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-sm-6 col-12">
              <label for="slide_photo">Slide Photo *</label>
              <div class="form-group">
                  <div class="input-group">
                     <span class="input-group-btn">
                     <a id="lfm" data-input="slide_photo" data-preview="holder" class="btn btn-primary text-white">
                      <i class="far fa-image"></i> Choose
                     </a>
                     </span>
                     <input id="slide_photo" class="form-control" type="text" name="slide_photo"  value="{{$slideShow->slide_photo}}">
                  </div>
                  <div class="img-wrapper mt-2">
                    <img src="{{url($slideShow->slide_photo)}}" alt="SlideShow" style="width:150px;">
                  </div>
               </div>
          </div>
        </div>

        <div class="form-group mt-3">
          <button type="submit" class="btn btn-primary brand-btn-color">Save</button>
          <a href="{{route('slideshows.index')}}" class="btn btn-default"> Cancel </a>
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

});
</script>
@endpush