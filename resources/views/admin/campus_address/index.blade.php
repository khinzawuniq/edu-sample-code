@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Campus Address</h3>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
      <div class="card-body">
        <div class="header-group w-100" style="display:inline-block;">
          <div class="float-left">
            @can('create')
            <a href="{{route('campus_address.create')}}" class="btn btn-success btn-create"> New Campus</a>
            @endcan
          </div>
        </div>

          <table class="table table-striped table-hover datatable w-100">
              <thead>
                  <tr class="thead-bg text-center">
                      <th>SN</th>
                      <th>Campus</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach($campus_address as $camp)
                <tr class="row-{{$camp->id}}">
                  <td align="center" data-column="SN">{{ ++$i }}</td>
                  <td data-column="Campus">{{ $camp->campus_name }}</td>
                  <td data-column="Address">{{ $camp->address }}</td>
                  <td data-column="Phone">{{ $camp->phone }}</td>
                  <td data-column="Email">{{ $camp->email }}</td>

                  <td align="center" data-column="Action" class="action-wrapper-{{$camp->id}}">
                    @if($camp->is_active == true)
                      <a href="#" onClick="inactive({{$camp->id}})" id="inactive_{{$camp->id}}"><i class="fa fa-eye"></i></a>
                    @else
                      <a href="#" onClick="active({{$camp->id}})" id="active_{{$camp->id}}"><i class="fas fa-eye-slash text-muted"></i></a>
                    @endif
                    
                    @can('edit')
                    <a href="{{ route('campus_address.edit',$camp->id)}}" class="ml-1"><i class="fa fa-edit text-warning"></i></a>
                    @endcan

                    @can('delete')
                    <i class="fa fa-trash text-danger deleteData ml-1" onClick="deleteCampus({{$camp->id}})">
                      <form id="camp_form_{{$camp->id}}" action="{{ route('campus_address.destroy', $camp->id) }}" method="post" style="display: none;" class="deleteDataForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit"></button>
                      </form>
                    </i>
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
#DataTables_Table_0_filter {
  display: none;
}
.select2 {
  margin-right: 10px;
}
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

		// $('.deleteData').on('click', function(){
        //     var result = confirm("Confirm delete record?");
        //     if(result) {
        //     $(this).find('form').submit();
        //     }
		// });

});

    function deleteCampus(id)
    {
        var result = confirm("Confirm delete record?");
        if(result) {
        $("#camp_form_"+id).submit();
        }
    }

      function inactive(id)
      {
        $.ajax({
          url: '/admin/campus_address/inactive/'+id,
          type: 'get',
          success: function (data) {
            
              if(data.code == 200) {
                $("#inactive_"+id).remove();
                $(".action-wrapper-"+id).prepend('<a href="#" onClick="active('+id+')" id="active_'+id+'"><i class="fas fa-eye-slash text-muted"></i></a>');
              }
          }
        });
      }
      
      function active(id)
      {
        $.ajax({
          url: '/admin/campus_address/active/'+id,
          type: 'get',
          success: function (data) {
            
            if(data.code == 200) {
                $("#active_"+id).remove();
                $(".action-wrapper-"+id).prepend('<a href="#" onClick="inactive('+id+')" id="inactive_'+id+'"><i class="fa fa-eye"></i></a>');
            }
          }
        });
      }

</script>
@endpush