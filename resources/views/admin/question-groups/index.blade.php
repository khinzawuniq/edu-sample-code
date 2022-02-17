@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Questions Group</h3>
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
            <a href="{{route('question-groups.create')}}" class="btn btn-success btn-create"> Create New</a>
        </div>
        @endcan

          <table class="table table-striped table-hover datatable">
              <thead>
                  <tr class="thead-bg text-center">
                      <th>SN</th>
                      <th>Questions Group Name</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach($question_groups as $key => $question)
                <tr>
                  <td align="center" data-column="SN">{{ ++$i }}</td>
                  <td align="center" data-column="Questions Group Name">{{ $question->group_name }}</td>					
                  <td align="center" data-column="Action">
                    {{-- <a onclick="statusChange({{$question->id}})" id="active-control{{$question->id}}" class="btn btn-sm btn-light"><i class="{{$question->is_active ? 'fas fa-eye text-primary' : 'fas fa-eye-slash text-muted' }}"></i></a> --}}
                    @can('edit')
                    <a href="{{ route('question-groups.edit',$question->id)}}"><i class="fa fa-edit text-warning"></i></a>
                    @endcan
                    @can('delete')
                    <i class="fa fa-trash text-danger deleteData">
                      <form action="{{ route('question-groups.destroy', $question->id) }}" method="post" style="display: none;" class="deleteDataForm">
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
                url:`/admin/question-groups/${id}/active`,
                type:'GET',
                success: function(response){
                    if (response.code == 200) {
                        const inactiveHtml = "<i class='fas fa-eye-slash text-muted'></i>";
                        const activeHtml = "<i class='fa fa-eye text-primary'></i>";
                        $('#active-control'+id).html("");
                        if(response.status){
                            $('#active-control'+id).html(activeHtml);
                        }else{
                            $('#active-control'+id).html(inactiveHtml);
                        }
                        
                    }
                }
            })
      }
      
</script>
@endpush