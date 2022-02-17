@extends('layouts.app')

@section('content')
<div class="container enrole-user-page py-4">
    <div class="row mb-2">
        <div class="col-12 text-right">
            <a href="{{url('courses/detail/'.$course->slug)}}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>
    
    @if(count($course->batchGrup) > 0)
    <div class="row mb-3">
        <div class="col-12">
            <div class="float-left mt-1">
                {!! Form::select('batch_group_id', ['0'=>'All']+$batch_groups, old('batch_group_id'), array('placeholder' => 'Filter Batch Group','class' => 'form-control', 'id'=>'filter_batch_group')) !!}
            </div>
            <div class="float-left ml-1 mt-1">
                <input type="text" class="form-control mr-2" placeholder="Search ..." id="searchDatatable">
            </div>

            <form action="#" class="form-inline mt-1 float-right">
                {!! Form::select('batch_group_id', $batch_groups, old('batch_group_id'), array('placeholder' => 'Select Batch Group','class' => 'form-control', 'id'=>'select_batch_group')) !!}

                <button type="button" class="btn btn-primary ml-2" id="apply_batch_group">Apply Batch Group</button>
            </form>
        </div>
    </div>
    @endif

    <table class="table table-striped datatable enrol-table">
        <thead>
            <tr class="bg-info">
                <th> <input type="checkbox" name="master" id="master"> </th>
                <th>SN</th>
                <th>Name</th>
                <th>Email</th>
                @if(count($course->batchGrup) > 0)
                <th>Batch Group</th>
                @endif
                <th>Last access to course</th>
                <th>Learning Duration</th>
                @can('list')
                <th> Action</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($enrol_users as $key=>$enrol)
            <tr class="enrol-row-{{$enrol->id}}">
                <td> <input type="checkbox" class="sub_chk" data-id="{{$enrol->id}}"> </td>
                <td> {{$key+1}} </td>
                <td> {{$enrol->user->name}} </td>
                <td> {{$enrol->user->email}} </td>
                @if(count($course->batchGrup) > 0)
                <td> {{($enrol->batch_group_id)? $enrol->batch_group->group_name:'-'}} </td>
                @endif
                <td> {{($enrol->last_activity)? date('d/m/Y', strtotime($enrol->last_activity)) : '-'}} </td>

                <td> <a class="font-weight-bold text-primary" href="{{url('/durations_list/'.$enrol->course_id.'/'.$enrol->user_id)}}">
                    {{-- {{gmdate('H:i', $enrol->total_second)}} --}}
                    {{$enrol->getLearningDuration($enrol->course_id, $enrol->user_id)}}
                </a> </td>

                @can('list')
                <td  class="action-wrapper-{{$enrol->id}}">
                    @if($enrol->is_active == true)
                      <a href="#" onClick="inactive({{$enrol->id}})" id="inactive_{{$enrol->id}}"><i class="fa fa-eye text-primary"></i></a>
                    @else
                      <a href="#" onClick="active({{$enrol->id}})" id="active_{{$enrol->id}}"><i class="fas fa-eye-slash text-muted"></i></a>
                    @endif

                    @if(empty($enrol->batch_group_id))
                    <button class="btn btn-info btn-sm assign-batch mr-2" title="Assign Batch Group" id="batch_group_{{$enrol->id}}" value="{{$enrol->id}}" data-toggle="modal" data-target="#batchModal"><i class="fas fa-users"></i></button>
                    @else
                    <button class="btn btn-info btn-sm update-assign-batch mr-2" title="Assign Batch Group" id="update_batch_group_{{$enrol->id}}" data-batchid="{{$enrol->batch_group_id}}" value="{{$enrol->id}}" data-toggle="modal" data-target="#updateBatchModal"><i class="fas fa-users"></i></button>
                    @endif

                    <button class="btn btn-warning btn-sm edit-enrol mr-2" title="Edit Enrol User" name="edit_enrol" id="edit_enrol_{{$enrol->id}}" value="{{$enrol->id}}" data-toggle="modal" data-target="#enrolUser"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm delete-enrol" title="Unenrol User" id="delete_enrol_{{$enrol->id}}" data-name="{{$enrol->user_name}}" value="{{$enrol->id}}"><i class="fas fa-times"></i></button>

                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <!-- Modal -->
    <div class="modal fade" id="enrolUser" role="dialog" aria-labelledby="enrolUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="enrolUserLabel">Edit Enrol User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
            {!! Form::open(['route' => 'enrol-user.enrol-update', 'method'=>'PATCH', 'id'=>'enrol_form']) !!}
            <input type="hidden" name="course_id" value="{{$course_id}}">
            <input type="hidden" name="enrol_user_id" id="enrol_user_id">
            <div class="form-group row">
                <label for="enrole_users" class="col-md-3 col-form-label text-md-right">Name</label>

                <div class="col-md-8">
                    {!! Form::text('enrol_user', null, ['class'=>'form-control', 'id'=>'enrol_user','readonly'=>true]) !!}
                    {!! Form::hidden('user_id', null, ['id'=>'user_id']) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="start_date" class="col-md-3 col-form-label text-md-right">Starting From</label>

                <div class="col-md-8">
                    {!! Form::date('start_date', null, ['class'=>'form-control','id'=>'start_date', 'required'=>true]) !!}
                    <small>(mm/dd/yyyy)</small>
                </div>
            </div>

            <div class="form-group row">
                <label for="duration" class="col-md-3 col-form-label text-md-right">Enrolment Duration</label>

                <div class="col-md-8">
                    <select name="duration" id="duration" class="form-control">
                        <option value=""></option>
                        @foreach($durations as $k=>$d)
                        <option value="{{$k}}"> {{$d}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="end_date" class="col-md-3 col-form-label text-md-right">Enrolment End</label>

                <div class="col-md-8">
                    {{ Form::date('end_date', old('end_date'), ['class'=>'form-control','id'=>'end_date']) }}
                    <small>(mm/dd/yyyy)</small>
                </div>
            </div>

            <div class="form-group row">
                <label for="end_date" class="col-md-3 col-form-label text-md-right">Created Date</label>

                <div class="col-md-8">
                    {!! Form::text('created_at', null, ['class'=>'form-control', 'id'=>'created_at','readonly'=>true]) !!}
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-md-3"></div>
                <div class="col-md-8 text-right">
                    <button type="submit" class="btn btn-primary">Enrol Users</button>
                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
                
            </div>

            {!! Form::close() !!}
        </div>
        
        </div>
    </div>
    </div>
    {{-- End Modal --}}

    <!-- Modal -->
    <div class="modal fade" id="batchModal" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="batchModalLabel">Select Batch Group</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="{{url('/admin/enrol-user/batch_group')}}" method="post" id="batch_group_form">
                @csrf
                <input type="hidden" name="enrol_user_id" id="batch_user_id">
                <input type="hidden" name="course_id" id="batch_course_id" value="{{$course_id}}">

                <div class="form-group">
                {!! Form::select('batch_group_id', $batch_groups, old('batch_group_id'), array('placeholder' => 'Select Batch Group','class' => 'form-control', 'id'=>'batch_group_id')) !!}
                </div>

                <div class="form-group">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
            </div>
        </div>
        </div>
    </div>
    
    {{-- Update Batch Group --}}
    <div class="modal fade" id="updateBatchModal" role="dialog" aria-labelledby="updateBatchModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="updateBatchModalLabel">Select Batch Group</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="{{url('/admin/enrol-user/update_batch_group')}}" method="post" id="batch_group_form">
                @csrf
                <input type="hidden" name="enrol_user_id" id="update_batch_user_id">
                <input type="hidden" name="course_id" id="update_batch_course_id" value="{{$course_id}}">

                <div class="form-group">
                {!! Form::select('batch_group_id', $batch_groups, old('batch_group_id'), array('placeholder' => 'Select Batch Group','class' => 'form-control', 'id'=>'update_batch_group_id')) !!}
                </div>

                <div class="form-group">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
            </div>
        </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.enrol-table {
    clear: both;
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
                "paging":   false,
				"ordering": false,
				"autoWidth": false,
			});

    $('#searchDatatable').on('keyup', function () {
		datatable.search(this.value).draw();
	});

    var course_id = {{$course_id}};

    $("#enrole_users").select2({
      theme: 'bootstrap4',
    });
    $("#batch_group_id").select2({
      theme: 'bootstrap4',
      placeholder: 'Select Batch Group',
    });
    $("#update_batch_group_id").select2({
      theme: 'bootstrap4',
      placeholder: 'Select Batch Group',
    });
    $("#select_batch_group").select2({
      theme: 'bootstrap4',
      placeholder: 'Select Batch Group',
    });
    $("#filter_batch_group").select2({
      theme: 'bootstrap4',
      placeholder: 'Filter Batch Group',
    });

    $(".edit-enrol").on('click', function() {
        var enrol_id = $(this).val();
        
        $.ajax({
                type:'GET',
                url: '/admin/get-enrol-user',
                data: {enrol_id: enrol_id},
                success : function(response){
                    console.log(response);
                    if (response.code == 200) {
                        var enrol = response.enrol;
                        
                        $("#enrol_user_id").val(enrol.id);
                        $("#duration").val(enrol.duration);
                        $("#user_id").val(enrol.user_id);
                        $("#enrol_user").val(enrol.user_name);
                        $("#start_date").val(enrol.start_date);
                        $("#end_date").val(enrol.end_date);
                        $("#created_at").val(enrol.created_date);
                        $("#enrolUser").show();
                    }            
                }           
            });
    });
    
    $(".assign-batch").on('click', function() {
        var enrol_id = $(this).val();
        $("#batch_user_id").val(enrol_id);
    });
    
    $(".delete-enrol").on('click', function() {
        var enrol_id = $(this).val();
        var user_name = $(this).attr('data-name');
        
        var result = confirm("Confirm unenrol "+user_name+" ?");
        if(result) {
            $.ajax({
                type:'GET',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/admin/unenrol-user/'+enrol_id,
                // data: {enrol_id: enrol_id},
                success : function(response){
                    console.log(response);
                    if (response.code == 200) {
                        $(".enrol-row-"+enrol_id).remove();
                        toastr.success('Successful unenrol!');
                    }            
                }           
            });
        }
    });
    // Update Batch Group
    $(".update-assign-batch").on('click', function() {
        var enrol_id = $(this).val();
        var batch_id = $(this).attr('data-batchid');

        $("#update_batch_user_id").val(enrol_id);
        $("#update_batch_group_id").val(batch_id).trigger('change');
    });
    
        $('#master').on('click', function(e) {
			if($(this).is(':checked',true))  
			{
				$(".sub_chk").prop('checked', true);  
			} else {  
				$(".sub_chk").prop('checked',false);  
			}  
        });

		$('#apply_batch_group').on('click', function(e) {
            var batch_group_id = $("#select_batch_group").val();

            if(batch_group_id > 0) {
                var allVals = [];
			$(".sub_chk:checked").each(function() {  
				allVals.push($(this).attr('data-id'));
			});  


			if(allVals.length <=0)  
			{  
				alert("Please select row.");
			}  else {  
                var join_selected_values = allVals.join(","); 
               

					$.ajax({
						url: '/admin/enrol-user/apply_group/'+course_id,
						type: 'get',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: {
                            'ids':join_selected_values,
                            'course_id':course_id,
                            'batch_group_id': batch_group_id,
                            },
						success: function (data) {
							window.location.href = '/courses/enrol-users/'+course_id;
						},
						error: function (data) {
							alert(data.responseText);
						}
					});
			}  
            }else {
                alert("Please select batch group!");
            }

		});

    $("#filter_batch_group").change(function() {
        var filter_batch_id = $("#filter_batch_group").val();

        window.location.href = '/courses/enrol-users/'+course_id+'?filter_batch_id='+filter_batch_id;
        
    });
});

    function inactive(id)
      {
        $.ajax({
          url: '/admin/enrol-user/inactive/'+id,
          type: 'get',
          success: function (data) {
            console.log(data);
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
          url: '/admin/enrol-user/active/'+id,
          type: 'get',
          success: function (data) {
            console.log(data);
            if(data.code == 200) {
                $("#active_"+id).remove();
                $(".action-wrapper-"+id).prepend('<a href="#" onClick="inactive('+id+')" id="inactive_'+id+'"><i class="fa fa-eye text-primary"></i></a>');
            }
          }
        });
      }
</script>
@endpush