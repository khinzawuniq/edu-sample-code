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

        <div class="row">
          <div class="col-6 text-center">
            <a href="{{url('admin/certificate_templates/landscape')}}" class="btn btn-primary btn-template">Landscape Template</a>
          </div>
          <div class="col-6 text-center">
            <a href="{{url('admin/certificate_templates/portrait')}}" class="btn btn-primary btn-template">Portrait Template</a>
          </div>
        </div>
        
      </div>
  </div>
</section>
<!-- /.content -->

@endsection

@push('styles')
<style>
.btn-template {
  color: #fff;
  background-color: #3490dc;
  border-color: #3490dc;
  border: 2px solid #021f63;
  border-radius: 10px;
  padding: 15px 20px;
}
</style>
@endpush

@push('scripts')
<script>

</script>
@endpush