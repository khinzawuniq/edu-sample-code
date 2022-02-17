@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Settings</h3>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
      <div class="card-body">

          <table class="table table-striped table-hover datatable">
              <thead>
                  <tr class="thead-bg text-center">
                      <th>SN</th>
                      <th>Default User Password</th>
                      <th>Email</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>

                @foreach($settings as $key=>$setting)
                <tr>
                  <td align="center" data-column="SN">{{ $key+1 }}</td>
                  <td data-column="Default User Password"> {{$setting->default_password}} </td>
                  <td data-column="Email" align="center"> {!! $setting->email !!} </td>
                  <td align="center" data-column="Action">
                    <a href="{{ route('settings.edit',$setting->id)}}"><i class="fa fa-edit text-warning"></i></a>
                  </td>
                </tr>
                @endforeach
                
              </tbody>
          </table>
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
$(function () {

      var datatable = $('.datatable').DataTable({
				"bInfo" : false,
                "searching": false,
				"bLengthChange": false,
				"pageLength": 10,
				"ordering": false,
				"autoWidth": false,
				"language": {
					"oPaginate": {
						"sNext": "<i class='fas fa-angle-right'></i>",
						"sPrevious": "<i class='fas fa-angle-left'></i>"
					}
				},
			});

});
      
</script>
@endpush