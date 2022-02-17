@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Roles</h3>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
      <div class="card-body">
        @can('create')
        <div class="float-left">
          <a href="{{route('roles.create')}}" class="btn btn-success btn-sm btn-create">New Role</a>
        </div>
        @endcan
          <table class="table table-striped table-hover datatable">
              <thead>
                  <tr class="wfh-table-bg text-center">
                      <th>SN</th>
                      <th>Role</th>
                      <th>Permission</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach($roles as $key => $role)
                <tr>
                  <td align="center" data-column="SN">{{ ++$i }}</td>
                  <td data-column="Role">{{ $role->name }}</td>
                  <td data-column="Permission">
                    @if(!empty($rolePermissions))
                      @foreach($rolePermissions as $v)
                        @if($v->role_id == $role->id)
                            {{ $v->name }},
                        @endif
                      @endforeach
                    @endif
                  </td>
                  <td align="center" data-column="Action">
                    {{-- <a href="{{ route('roles.show',$role->id)}}"><i class="fa fa-eye"></i></a> --}}
                    @can('edit')
                    <a href="{{ route('roles.edit',$role->id)}}"><i class="fa fa-edit text-warning"></i></a>
                    @endcan

                    @can('delete')
                    @if($role->name != "Super Admin")
                    <i class="fa fa-trash text-danger deleteData">
                      <form action="{{ route('roles.destroy', $role->id) }}" method="post" style="display: none;" class="deleteDataForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit"></button>
                      </form>
                    </i>
                    @endif
                    @endcan

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
