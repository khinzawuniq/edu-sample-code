@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Campus Address</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
    {!! Form::model($campusAddress, ['method' => 'PATCH','route' => ['campus_address.update', $campusAddress->id]]) !!}
        <div class="card-header">
            <div class="card-title">
                Campus Edit
            </div>
        </div>
        <div class="card-body">
            
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Campus Name <span class="text-danger">*</span></label>
                        {!! Form::text('campus_name', old('campus_name'), ['placeholder' => 'Campus Name','class' => 'form-control', 'required'=>true]) !!}
                        @if ($errors->has('campus_name'))
                            <span class="text-danger validate-message">{{ $errors->first('campus_name') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Address <span class="text-danger">*</span></label>
                        {!! Form::textarea('address', old('address'), array('class' => 'form-control', 'rows'=>3, 'placeholder'=>'Address', 'required')) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Phone <span class="text-danger">*</span></label>
                        {!! Form::text('phone', old('phone'), array('placeholder' => 'Phone','class' => 'form-control', 'required'=>true)) !!}
                        @if ($errors->has('phone'))
                            <span class="text-danger validate-message">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
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
                <div class="col-12">
                    <div class="form-group">
                        <label for="is_active" class="mb-0">
                            {!! Form::checkbox('is_active', null, (($campusAddress->is_active)? '':'checked') ) !!} Suspend ?
                        </label>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary brand-btn-color">Update</button>
                        <a href="{{route('campus_address.index')}}" class="btn btn-default"> Cancel </a>
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

</script>
@endpush