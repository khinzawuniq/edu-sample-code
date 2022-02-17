@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Gradings</h3>
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
            <a href="{{route('gradings.create')}}" class="btn btn-success btn-create"> New Grading</a>
        </div>
        @endcan

          <table class="table table-striped table-hover datatable">
              <thead>
                  <tr class="thead-bg text-center">
                      <th>SN</th>
                      <th>Awarding Body</th>
                      <th>Passing Mark</th>
                      <th>Number of Grading</th>
                      <th>Grade Description</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach($grading_group as $key => $grading)
                  @php 
                    $number_grading = 0;
                    $grading_description = '';

                    foreach($gradings as $g) {
                      if($g->ref_no == $grading->ref_no) {
                        $number_grading = $number_grading + 1;
                        $grading_description = $g->grading_from .'-'. $g->grading_to . $g->grading_description;
                      }
                    }
                  @endphp
                  
                <tr>
                  <td align="center" data-column="SN">{{ ++$i }}</td>
                  
                  <td data-column="Awarding Body"> {{$grading->awarding_body}} </td>
                  <td data-column="Passing Mark" align="center"> {{$grading->passing_mark}} </td>
                  <td data-column="Number of Grading" align="center"> 
                    {{$number_grading}}
                  </td>
                  <td data-column="Grade Description">
                    @foreach($gradings as $g)
                      @if($g->ref_no == $grading->ref_no)
                        {{ $g->grading_from }} - {{ $g->grading_to }} {{ $g->grading_description }} <br>
                      @endif
                    @endforeach
                  </td>
					
                  <td align="center" data-column="Action">
                    <a onclick="statusChange('{{$grading->ref_no}}')" id="active-grading-control{{$grading->ref_no}}" class="btn btn-sm btn-light"><i class="{{($grading->is_active == 1) ? 'fas fa-eye text-primary' : 'fas fa-eye-slash text-muted' }}"></i></a>
                    @can('edit')
                    <a href="{{ route('gradings.edit',$grading->ref_no)}}"><i class="fa fa-edit text-warning"></i></a>
                    @endcan
                    @can('delete')
                    <i class="fa fa-trash text-danger deleteData">
                      <form action="{{ route('gradings.destroy', $grading->ref_no) }}" method="post" style="display: none;" class="deleteDataForm">
                        @csrf
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

      function statusChange(ref_no)
      {
            $.ajax({
                url:`/admin/grading-active/${ref_no}`,
                type:'GET',
                success: function(response){
                    if (response.code == 200) {
                        const inactiveHtml = "<i class='fas fa-eye-slash text-muted'></i>";
                        const activeHtml = "<i class='fa fa-eye text-primary'></i>";
                        $('#active-grading-control'+ref_no).html("");
                        console.log(response.status);
                        if(response.status == 1){
                            $('#active-grading-control'+ref_no).html(activeHtml);
                        }else{
                            $('#active-grading-control'+ref_no).html(inactiveHtml);
                        }
                        
                    }
                }
            })
      }
      
</script>
@endpush