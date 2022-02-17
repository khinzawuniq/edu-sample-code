@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Certificate Templates</h3>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
      <div class="card-body py-5">

        <div class="back-wrapper text-right">
            <a href="{{url('admin/certificate_templates')}}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        <div class="setting-wrapper mb-4">
            <span class="certificate-setting"><i class="fas fa-cog"></i></span>
        </div>
        
        {{-- {!! Form::open(array('route' => 'certificate_templates.store','method'=>'POST','enctype'=>'multipart/form-data', 'files'=>true)) !!} --}}
        {!! Form::model($certificate, ['method' => 'PATCH','enctype'=>'multipart/form-data', 'files'=>true, 'class'=>'landscape-form d-none', 'id'=>'certificateForm', 'route' => ['certificate_templates.update', $certificate->id]]) !!}

        <input type="hidden" name="certificate_type" id="certificate_type" value="landscape">
        <table class="table table-striped table-bordered">
            <tbody>
              <tr>
                <td>Background Image</td>
                <td>
                  <div class="input-group">
                    <span class="input-group-btn">
                    <a data-input="background_image" data-preview="holder" class="btn btn-primary lfm text-white">
                      <i class="far fa-image"></i> Choose
                    </a>
                    </span>
                    {{-- <input type="text" name="background_image" class="form-control" id="background_image" /> --}}
                    <input type="text" name="background_image" class="form-control" id="background_image" value="{{$certificate->background_image}}" />
                  </div>
                </td>
              </tr>
              <tr>
                <td>Additional Text</td>
                <td>
                  {{-- <input type="text" name="additional_text" id="additional_text" class="form-control" placeholder="This is sample text for Additional text"> --}}
                  <input type="text" name="additional_text" id="additional_text" class="form-control" value="{{$certificate->additional_text}}" placeholder="This is sample text for Additional text">
                </td>
              </tr>
            </tbody>
        </table>

        <div class="row mt-4">
            <div class="col-6">
                {{-- <button class="btn btn-primary btn-position">Customize the Position</button> --}}
            </div>
            <div class="col-6 text-right">
                <button class="btn btn-primary save-btn">Save</button>
            </div>
        </div>

        {!! Form::close() !!}

        <div class="preview-wrapper mt-5">
            <h5 class="mb-3">Certificate Preview</h5>

            <div class="sample-certificate">
                {{-- <a href="{{asset('assets/images/landscape-preview.jpg')}}" data-toggle="lightbox" data-title="Certificate Landscape">
                  <img src="{{asset('assets/images/landscape-preview.jpg')}}" alt="Certificate">
                </a> --}}
                <div class="img-wrapper">
                  <img src="{{url($certificate->background_image)}}" alt="Certificate">
                </div>
                
            </div>
        </div>
        

      </div>
  </div>
</section>
<!-- /.content -->

@endsection

@push('styles')
<style>
.certificate-setting {
    font-size: 2rem;
    cursor: pointer;
    color: #021f63;
}
.certificate-setting:hover {
  color: rgba(1,1,209, 0.7);
}
.dropify-wrapper {
    height: 90px;
}
.sample-certificate img {
    width: 100%;
    max-width: 450px;
}
</style>
@endpush

@push('scripts')
<script>
$(function() {
    $(".certificate-setting").click(function() {
        // $(".save-btn").toggleClass('d-none');
        $("#certificateForm").toggleClass('d-none');
    });

    $('.lfm').filemanager('file');
});
</script>
@endpush