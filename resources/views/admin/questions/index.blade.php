@extends('layouts.admin-app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="m-0 wfh-text-color font-weight-bold">Questions</h3>
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
            <a class="btn btn-success btn-create" href="#" data-toggle="modal" data-target="#newQuestionModal">New Question</a>
            {{-- <a href="{{route('backend-questions.create')}}" class="btn btn-success btn-create"> Create New</a> --}}
        </div>

          <table class="table table-striped table-hover datatable">
              <thead>
                  <tr class="thead-bg text-center">
                      <th>SN</th>
                      <th>Questions Group Name</th>
                      <th>Question</th>
                      <th>Question Type</th>
                      <th>Mark</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 0; ?>
                @foreach($questions as $key => $q)
                <tr>
                  <td align="center" data-column="SN">{{ ++$i }}</td>
                  <td data-column="Questions Group Name">{{ $q->groupName->group_name }}</td>					
                  <td data-column="Question">{{ $q->question }}</td>
                  <td data-column="Question Type">{{ $q->question_type }}</td>
                  <td align="center" data-column="Mark">{{ $q->mark }}</td>
                  <td align="center" data-column="Action">
                    {{-- <a onclick="statusChange({{$q->id}})" id="active-control{{$q->id}}" class="btn btn-sm btn-light"><i class="{{$q->is_active ? 'fas fa-eye text-primary' : 'fas fa-eye-slash text-muted' }}"></i></a> --}}

                    <a href="{{ route('question-groups.edit',$q->id)}}"><i class="fa fa-edit text-warning"></i></a>
                    <i class="fa fa-trash text-danger deleteData">
                      <form action="{{ route('question-groups.destroy', $q->id) }}" method="post" style="display: none;" class="deleteDataForm">
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
      </div>
  </div>
</section>
<!-- /.content -->

{{-- Question Type Modal --}}
<div class="modal fade" id="newQuestionModal" role="dialog" aria-labelledby="newQuestionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header psmModalHeader">
          <h3 class="modal-title text-white" id="newQuestionModalLabel">A New Question</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
          </button>
      </div>
      
      <div class="modal-body text-center">
          <form action="{{url('/admin/backend-questions/create')}}" method="get">

              <h4 class="mb-4">Choose Question Type</h4>
              <div class="form-group mb-4">
                  <label for="multiple_choice" class="px-2"> <input type="radio" class="question_type" name="question_type" id="multiple_choice" value="multiple_choice" checked> Multiple Choice</label>
                  <label for="true_false" class="px-2"> <input type="radio" class="question_type" name="question_type" id="true_false" value="true_false"> True/False</label>
                  {{-- <label for="matching" class="px-2"> <input type="radio" class="question_type" name="question_type" id="matching" value="matching"> Matching </label> --}}
              </div>

              <div class="form-group">
                  <button type="submit" class="btn btn-primary px-5" id="select_question_type">Select</button>
              </div>
          </form>
      </div>
      
      </div>
  </div>
  </div>
{{-- End Question Type Modal --}}
@endsection

@push('styles')
<style>
.psmModalHeader {
    background: rgba(1,1,209, 0.5);
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
                url:`/admin/backend-questions/${id}/active`,
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