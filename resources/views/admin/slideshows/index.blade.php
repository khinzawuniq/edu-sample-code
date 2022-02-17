@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">SlideShows</h3>
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
            <a href="{{route('slideshows.create')}}" class="btn btn-success btn-create"> New SlideShow</a>
        </div>

          <table class="table table-striped table-hover datatable">
              <thead>
                  <tr class="thead-bg text-center">
                      <th>SN</th>
                      <th>Slide Name</th>
                      <th>Slide Photo</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach($slideShows as $key => $slide)
                <tr>
                  <td align="center" data-column="SN">{{ ++$i }}</td>
                  <td data-column="Slide Name"> {{$slide->slide_name}} </td>
                  <td data-column="Slide Photo" align="center"> {{$slide->slide_photo}} </td>
					
                  <td align="center" data-column="Action">
                    <a onclick="statusChange('{{$slide->id}}')" id="active-slide-control{{$slide->id}}" class="btn btn-sm btn-light"><i class="{{($slide->is_active == 1) ? 'fas fa-eye text-primary' : 'fas fa-eye-slash text-muted' }}"></i></a>

                    <a href="{{ route('slideshows.edit',$slide->id)}}"><i class="fa fa-edit text-warning"></i></a>
                    <i class="fa fa-trash text-danger deleteData">
                      <form action="{{ route('slideshows.destroy', $slide->id) }}" method="post" style="display: none;" class="deleteDataForm">
                        @csrf
                        <button type="submit"></button>
                      </form>
                    </i>
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
table.table tbody td {
  vertical-align: middle
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

			$('.deleteData').on('click', function(){
                var result = confirm("Confirm delete record?");
                if(result) {
                $(this).find('form').submit();
                }
			});

});

      function statusChange(id)
      {
            $.ajax({
                url:`/admin/slideshows-active/${id}`,
                type:'GET',
                success: function(response){
                    if (response.code == 200) {
                        const inactiveHtml = "<i class='fas fa-eye-slash text-muted'></i>";
                        const activeHtml = "<i class='fa fa-eye text-primary'></i>";
                        $('#active-slide-control'+id).html("");
                        
                        if(response.status == 1){
                            $('#active-slide-control'+id).html(activeHtml);
                        }else{
                            $('#active-slide-control'+id).html(inactiveHtml);
                        }
                        
                    }
                }
            })
      }
      
</script>
@endpush