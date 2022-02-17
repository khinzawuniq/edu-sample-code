@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<div class="container course-page py-4">

    <div class="row">
        <div class="col-12 text-right">
            <a href="{{url('/courses/detail/'.$exam->course->slug.'?module_id='.$exam->module_id)}}" class="btn btn-secondary btn-sm mb-2">Back</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5> {{$exam->course->course_name}} </h5>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        {!! Form::select('question_group_id', $question_groups, old('question_group_id'), array('class' => 'form-control', 'id'=>'question_group_id')) !!}    
                    </div>
                </div>
                <div class="col-6 pl-0">
                    <div class="form-group">
                        {!! Form::select('change_group', $change_question_groups, old('change_group'), array('class' => 'form-control', 'id'=>'change_group')) !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-sm-6 col-12 text-right">
            <button class="btn btn-primary btn-sm" id="change_question_group">Change Question Group</button>
            <button class="btn btn-primary btn-sm" id="add_question">Add Question</button>
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
            {{-- @foreach($questions as $q)
            <tr>
                <td><input type="checkbox" name="id[]" value="{{ $q->id }}" class="eachData"></td>
                <td style="display:none" data-column="Question Group Name"> {{$q->question_group_name}} </td>
                <td data-column="Question"> {{$q->question}} </td>
                <td data-column="Mark"> {{$q->mark}} </td>
            </tr>
            @endforeach --}}
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

    $("#question_group_name").select2({
      theme: 'bootstrap4',
    //   placeholder: "Question Group Name",
    });
    $("#change_group").select2({
      theme: 'bootstrap4',
    //   placeholder: "Question Group Name",
    });

    var datatable = '';

    $("#question_group_id").on('change', function() {
        var question_group_id = $("#question_group_id").val();
        console.log(question_group_id);

        if(question_group_id == '') {
            $(".datatable tbody").html('');
        }else {

            $.ajax({
            url: '/exams/get_question_group_name',
            type: 'get',
            dataType: 'json',
            data: {
                    'question_group_id': question_group_id,
                },
            success: function (data) {
                console.log(data);
                if(data) {
                    datatable = $('.datatable').DataTable({
                        destroy: true,
                        responsive:true,
                        bInfo: false,
                        bLengthChange: false,
                        pageLength: 50,
                        data: data,
                        searching: false,
                        columns : [
                            {data: 'id', searchable : false},
                            {data: 'question', searchable : false},
                            {data: 'mark', searchable : false},
                            {data: 'q_id', searchable : false},
                        ],
                        columnDefs: [{
                            'targets': 0,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-body-center',
                            'render': function (data, type, full, meta){
                                return '<input type="checkbox" name="id[]" class="eachData" value="' + data + '">';
                            }
                        },
                        {
                            'targets': 3,
                            'render': function (data, type, full, meta){
                                return '<a href="/admin/questions/'+data+'/edit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>'+
                                '<a href="#" class="btn btn-sm btn-danger" id="delete_question" onClick="deleteQuestion('+data+')" ><i class="far fa-trash-alt"></i></a>';
                            }
                        }],
                    });
                }else {
                    $(".datatable tbody").html('');
                }
            }
            });

        }
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

    $("#add_question").on('click', function() {
        var allVals = [];
        $(".eachData:checked").each(function() {
            allVals.push($(this).val());
        });

        if(allVals.length <=0)
        {
            alert("Please select question.");
        }  else {
            var join_selected_values = allVals.join(",");
            var exam_id = {{$exam->id}};
            var course_id = {{$exam->course_id}};
            var module_id = {{$exam->module_id}};

            $.ajax({
                url: '/exams/get_questions/'+exam_id,
                type: 'get',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'ids':join_selected_values,
                    },
                success: function (data) {
                    if(data.code == 200) {
                        location.href = '/courses/detail/'+course_id+'?module_id='+module_id;
                    }
                }
            });
        }
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
            var exam_id = {{$exam->id}};
            var course_id = {{$exam->course_id}};
            var module_id = {{$exam->module_id}};
            var question_group = $("#question_group_id").val();
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
                        location.href = '/exams/from_question_list/'+exam_id+'?course_id='+course_id+'&module_id='+module_id;
                    }
                }
            });
        }
    });

});

function deleteQuestion(qId)
{
    var examId = {{$exam->id}};
    var courseId = {{$exam->course_id}};
    var moduleId = {{$exam->module_id}};

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
                        location.href = '/exams/from_question_list/'+examId+'?course_id='+courseId+'&module_id='+moduleId;
                    }
                }
        });
    }
    
}
</script>
@endpush
