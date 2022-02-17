@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Permissions</h3>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
      <div class="card-body">
        <div class="float-left">
          <a href="{{route('permissions.create')}}" class="btn btn-success btn-sm btn-create"> New Permission</a>
        </div>
          <table class="table table-striped table-hover datatable">
              <thead>
                  <tr class="wfh-table-bg text-center">
                      <th>No</th>
                      <th>Permission</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach($permissions as $key => $permission)
                <tr>
                  <td align="center" data-column="SN">{{ ++$i }}</td>
                  <td data-column="Permission">{{ $permission->name }}</td>
                  <td align="center" data-column="Action">
                    <a href="{{ route('permissions.edit',$permission->id)}}"><i class="fa fa-edit text-warning"></i></a>
                    <i class="fa fa-trash text-danger deleteData">
                      <form action="{{ route('permissions.destroy', $permission->id) }}" method="post" style="display: none;" class="deleteDataForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit"></button>
                      </form>
                    </i>
                  </td>
                </tr>
                @endforeach
              </tbody>
          </table>
        {{-- @endcan --}}
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

			$('.deleteData').on('click', function(){
        var result = confirm("Confirm delete record?");
        if(result) {
          $(this).find('form').submit();
        }
			});
    
});
</script>
@endpush