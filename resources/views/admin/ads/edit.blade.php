@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Ads</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
    {!! Form::model($blogAd, ['method' => 'PATCH','route' => ['ads.update', $blogAd->id]]) !!}
        <div class="card-header">
            <div class="card-title">
                Ads Edit
            </div>
        </div>
        <div class="card-body">
            
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Ads Image</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                            <a data-input="ads_image" data-preview="holder" class="btn btn-primary text-white lfm">
                             <i class="far fa-image"></i> Choose
                            </a>
                            </span>
                            <input id="ads_image" class="form-control" type="text" name="ads_image" value="{{$blogAd->ads_image}}" required>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Ads URL <span class="text-danger">*</span></label>
                        {!! Form::text('ads_url', old('ads_url'), ['placeholder' => 'Enter URL','class' => 'form-control', 'required'=>true]) !!}
                        @if ($errors->has('ads_url'))
                            <span class="text-danger validate-message">{{ $errors->first('ads_url') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
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
$(function() {
    $('.lfm').filemanager('file');
});
</script>
@endpush