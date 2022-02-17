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
    
    <div class="row mb-3">
        <div class="col-md-4 col-sm-4 col-6">
            <label>Selected Questions <span class="bg-success ml-3" id="total_question">0</span> </label>
        </div>
        <div class="col-md-4 col-sm-4 col-6">
            <label>Total Marks <span class="bg-grey ml-3" id="total_mark">0</span> </label>
        </div>
        <div class="col-md-4 col-sm-4 col-6">
            <button class="btn btn-primary" id="save_question">Save and Continue</button>
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
                <td><input type="checkbox" name="id[]" value="{{ $q->id }}" data-mark="{{$q->mark}}" class="eachData"></td>
                <td data-column="Question"> {{$q->question}} </td>
                <td data-column="Mark"> {{$q->mark}} </td>
                <td data-column="Action">
                    <a href="{{url('admin/questions/'.$q->id.'/edit?question_group_id='.$q->question_group_id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-sm btn-danger" id="delete_question" onClick="deleteQuestion({{$q->id}},{{$data['group_id'].','.$data['course_id'].','.$data['module_id'].','.$data['exam_id']}})" ><i class="far fa-trash-alt"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>

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
    #total_question, #total_mark {
        font-size: 1rem;
        border: 2px solid #333;
        border-radius: 10px;
        padding: 10px 15px;
        color: #fff;
        text-align: center;
    }
    .bg-grey {
        background-color: #aaa;
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

            // var allVals = [];
            // var totalMark = 0;

            // Handle click on "Select all" control
            $('#example-select-all').on('click', function(){
				// Get all rows with search applied
				var rows = datatable.rows({ 'search': 'applied' }).nodes();
				// Check/uncheck checkboxes for all rows in the table
				$('input[type="checkbox"]', rows).prop('checked', this.checked);

                var allVals = [];
                var totalMark = 0;
                $(".eachData:checked").each(function() {  
                    allVals.push($(this).val());
                    var mark = $(this).attr('data-mark');
                    totalMark = parseInt(totalMark) + parseInt(mark);
                });
                $("#total_question").text(allVals.length);
                $("#total_mark").text(totalMark);
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
				
                var allVals = [];
                var totalMark = 0;
                $(".eachData:checked").each(function() {  
                    allVals.push($(this).val());
                    var mark = $(this).attr('data-mark');
                    totalMark = parseInt(totalMark) + parseInt(mark);
                });
                // if($(".eachData").is(':checked')) {
                //     allVals.push($(this).val());
                //     var mark = $(this).attr('data-mark');
                //     totalMark = parseInt(totalMark) + parseInt(mark);
                // }else {

                // }
                
                $("#total_question").text(allVals.length);
                $("#total_mark").text(totalMark);

			});

    $("#save_question").on('click', function() {
        var allVals = [];
        $(".eachData:checked").each(function() {  
            allVals.push($(this).val());
        });

        if(allVals.length <=0)  
		{  
			alert("Please select row.");  
		}else {

            var join_selected_values = allVals.join(",");
            var course_id   = {{$data['course_id']}};
            var module_id   = {{$data['module_id']}};
            var exam_id     = {{$data['exam_id']}};
            var group_id    = {{$data['group_id']}};
            var slug        = "{{$course->slug}}";

            $.ajax({
                url: '/question_group_names/'+group_id+'/save-questions',
                type: 'get',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    ids : join_selected_values,
                    course_id : course_id,
                    module_id : module_id,
                    exam_id : exam_id,
                },
                success: function (data) {
                    // console.log(data);
                    if(data.code == 200) {
                        location.href = '/courses/detail/'+slug+'?module_id='+module_id;
                        // location.href = '/exams/question_list/'+exam_id+'?course_id='+course_id+'&module_id='+module_id;
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });
        }  
    });
});

function deleteQuestion(qId, group_id, course_id, module_id, exam_id)
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
                        location.href = '/question_group_names/'+group_id+'/select-group?course_id='+course_id+'&module_id='+module_id+'&exam_id='+exam_id;
                    }
                }
        });
    }
    
}
</script>
@endpush
