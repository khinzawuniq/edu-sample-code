@extends('layouts.app')
@push('styles')
<style>
    .psmModalHeader {
        background: rgba(1,1,209, 0.5);
    }
</style>
@endpush
@section('content')
<div class="container course-page py-4">

    <div class="row">
        <div class="col-12 text-right">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm mb-2">Back</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
            <button class="btn btn-primary" id="add_question" data-toggle="modal" data-target="#newQuestionModal">Add Question</button>
        </div>
        
        <div class="col-md-6 col-sm-6 col-12 text-right">
            
            <div class="row">
                <div class="col-6 pl-0">
                    <div class="form-group">
                        {!! Form::select('change_group', $change_question_groups, old('change_group'), array('class' => 'form-control', 'id'=>'change_group')) !!}
                    </div>
                </div>
                <div class="col-6 pl-0">
                    <div class="form-group">
                        <button class="btn btn-primary" id="change_question_group">Change Question Group</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped datatable">
        <thead>
            <tr class="bg-primary">
                <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                <th>Question</th>
                <th>Mark</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $q)
            <tr>
                <td><input type="checkbox" name="id[]" value="{{ $q->id }}" class="eachData"></td>
                <td data-column="Question"> {{$q->question}} </td>
                <td data-column="Mark"> {{$q->mark}} </td>
                <td data-column="Action">
                    <a href="{{url('admin/questions/'.$q->id.'/edit?question_group_id='.$questionGroupName->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-sm btn-danger" id="delete_question" onClick="deleteQuestion({{$q->id}})" ><i class="far fa-trash-alt"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>

{{-- Question Modal --}}
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
            <form action="{{url('/admin/questions/create')}}" method="get">
                <input type="hidden" name="course_id" id="course_id" value="0">
                <input type="hidden" name="module_id" id="module_id" value="0">
                <input type="hidden" name="exam_id" id="exam_id" value="0">
                <input type="hidden" name="question_group_id" id="question_group_id" value="{{$questionGroupName->id}}">
                <input type="hidden" name="question_group_name" id="question_group_name" value="{{$questionGroupName->group_name}}">

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
{{-- End Question Modal --}}
@endsection

@push('styles')
<style>
    .question-detail-wrapper {
        display: flex;
    }
    .question-detail {
        margin-right: auto;
    }
    .action-wrapper {
        margin-left: auto;
    }
    #DataTables_Table_0_filter {
        display: none;
    }
    
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    var datatable = $('.datatable').DataTable({
				"bInfo" : false,
				"bLengthChange": false,
				"pageLength": 50,
				"ordering": false,
				"autoWidth": false,
				"language": {
					"oPaginate": {
						"sNext": "<i class='fas fa-angle-right'></i>",
						"sPrevious": "<i class='fas fa-angle-left'></i>"
					}
				},
			});

    $("#change_group").select2({
      theme: 'bootstrap4',
    //   placeholder: "Question Group Name",
    });

            // Handle click on "Select all" control
            $('#example-select-all').on('click', function(){
				// Get all rows with search applied
				var rows = datatable.rows({ 'search': 'applied' }).nodes();
				// Check/uncheck checkboxes for all rows in the table
				$('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            // Handle click on checkbox to set state of "Select all" control
            $('.datatable tbody').on('change', 'input[type="checkbox"]', function(){
				// If checkbox is not checked
				if(!this.checked){
					var el = $('#example-select-all').get(0);
					// If "Select all" control is checked and has 'indeterminate' property
					if(el && el.checked && ('indeterminate' in el)){
						// Set visual state of "Select all" control
						// as 'indeterminate'
						el.indeterminate = true;
					}
				}
			});

	$('.eachData').on('click', function() {
				
	});

    $("#change_question_group").on('click', function() {
        var allVals = [];
        $(".eachData:checked").each(function() {
            allVals.push($(this).val());
        });

        if(allVals.length <=0)
        {
            alert("Please select question.");

        }  else {
            var join_selected_values = allVals.join(",");
            // var course_id = {{$data['course_id']}};
            var question_group = {{$questionGroupName->id}};
            var change_group = $("#change_group").val();

            $.ajax({
                url: '/exams/change_question_group/'+question_group,
                type: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                        ids             : join_selected_values,
                        question_group  : question_group,
                        change_group    : change_group,
                    },
                success: function (data) {
                    if(data.code == 200) {
                        location.href = '/question_group_names/'+question_group;
                        // location.href = '/exams/from_question_list/'+exam_id+'?course_id='+course_id+'&module_id='+module_id;
                    }
                }
            });
        }
    });

});

function deleteQuestion(qId)
{
    
    var result = confirm("Are you sure delete!");
    if(result) {
        $.ajax({
                url: '/exams/question_delete/'+qId,
                type: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'id': qId,
                    },
                success: function (data) {
                    if(data.code == 200) {
                        location.href = '/question_group_names/'+qId;
                    }
                }
        });
    }
    
}
</script>
@endpush
