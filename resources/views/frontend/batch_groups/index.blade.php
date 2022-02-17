@extends('layouts.app')
@push('styles')
<style>
    .group-name {
        color: #3490dc;
    }
    .group-name:hover {
        color: #021f63;
    }
</style>
@endpush
@section('content')
<div class="container group-name-page py-4">
    <div class="row mb-3">
        <div class="col-12 text-right">
            <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#createModal">New Batch Group</a>
            <a href="{{url('/courses/detail/'.$course->slug)}}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr class="bg-primary">
                <th>SrNo</th>
                <th>Batch Group Name</th>
                <th>Accessed Module Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($batchGroups as $key=>$batch)
            <tr>
                <td data-column="SrNo">{{$key+1}}</td>
                <td data-column="Batch Group Name"> {{$batch->group_name}} </td>
                <td data-column="Accessed Module Number"> {{count($batch->module)}} </td>
                <td data-column="Action">

                    <a href="#" class="edit_batch" data-batchId="{{$batch->id}}" data-batchName="{{$batch->group_name}}"><i class="fa fa-edit text-warning"></i></a>
                    {{-- <a href="#" data-toggle="modal" data-target="#editModal" data-batchId="{{$batch->id}}" data-batchName="{{$batch->group_name}}"><i class="fa fa-edit text-warning"></i></a> --}}
                    <i class="fa fa-trash text-danger deleteData">
                      <form action="{{ route('batch_groups.destroy', $batch->id) }}" method="post" style="display: none;" class="deleteDataForm">
                        @csrf
                        @method('DELETE')
                        {{-- <input type="hidden" name="course_id" value="{{$course_id}}"> --}}
                        <button type="submit"></button>
                      </form>
                    </i>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

{{-- Create --}}
<div class="modal fade" id="createModal" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="createModalLabel">Create Batch Group</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
            {!! Form::open(array('route' => 'batch_groups.store','method'=>'POST')) !!}
                <input type="hidden" name="course_id" value="{{$course->id}}">
            
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-12">
                        <div class="form-group">
                            <label for="group_name">Group Name</label>
                            <input type="text" name="group_name" id="group_name" class="form-control" autocomplete="off" required placeholder="Group Name">
                        </div>
                    </div>
                </div>

                <p class="mt-4"><strong>Select Module</strong></p>
                <div class="row mb-3">
                    @foreach($modules as $key=>$module)
                        <div class="col-sm-6 col-12 {{($key == 0)?'d-none':''}}">
                            <label for="module_id_{{$module->id}}">
                                <input type="checkbox" name="module_id[]" id="module_id_{{$module->id}}" value="{{$module->id}}" {{($key == 0)?'checked':''}}> {{$module->name}}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{url('/admin/batch_groups/'.$course_id)}}" class="btn btn-light">Cancel</a>
            {!! Form::close() !!}
        </div>
        
        </div>
    </div>
    </div>
{{-- End --}}

{{-- Edit --}}
<div class="modal fade" id="editModal" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="editModalLabel">Edit Batch Group</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
            <form action="{{url('/admin/batch_groups/update')}}" method="post" id="updateBatchForm">
                @csrf
                <input type="hidden" name="batch_id" id="batch_id">
                <input type="hidden" name="course_id" value="{{$course->id}}">

                <div class="form-group">
                    <label for="update_group_name">Group Name</label>
                    <input type="text" name="group_name" id="update_group_name" class="form-control" autocomplete="off" required placeholder="Group Name">
                </div>

                <p class="mt-4"><strong>Select Module</strong></p>
                <div class="row mb-3">
                    @foreach($modules as $key=>$module)
                        <input type="hidden" name="batch_module_id[]" id="batch_module_id_{{$module->id}}">
                        <div class="col-sm-6 col-12 {{($key == 0)?'d-none':''}}">
                            <label for="update_module_id_{{$module->id}}">
                                <input type="checkbox" name="module_id[]" id="update_module_id_{{$module->id}}" value="{{$module->id}}"> {{$module->name}}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" id="update_batch" class="btn btn-success">Save</button>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancel</button>
            </form>
        </div>
        
        </div>
    </div>
    </div>
{{-- End --}}
@endsection
@push('scripts')

<script>
    $(document).ready(function() {
        var course_id = {{$course_id}};

        var datatable = $('.datatable').DataTable({
                    "bInfo" : false,
                    "bLengthChange": false,
                    "pageLength": 20,
                    "ordering": false,
                    "autoWidth": false,
                    "language": {
                        "oPaginate": {
                            "sNext": "<i class='fas fa-angle-right'></i>",
                            "sPrevious": "<i class='fas fa-angle-left'></i>"
                        }
                    },
                });


        jQuery.noConflict();
        $('.edit_batch').on('click', function () {
            console.log('edit');
			var button = $(this);
				
			var batchId = button.attr('data-batchId');
			var batchName = button.attr('data-batchName');
                
			// $("#batch_id").val(batchId);
            // $("#update_group_name").val(batchName);
            jQuery.noConflict();
            $("#editModal").modal('show');

            $.ajax({
                url: '/admin/batch_groups/edit/'+batchId+'/'+course_id,
                type: 'get',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    if(data.code == 200) {
                        $("#batch_id").val(data.batch.id);
                        $("#update_group_name").val(data.batch.group_name);
                        if(data.batch_modules.length > 0) {
                            data.batch_modules.forEach(function(item,index) {
                                var module_id = $("#update_module_id_"+item.module_id).val();
                                if(module_id == item.module_id) {
                                    $("#update_module_id_"+item.module_id).prop('checked', true);
                                    $("#batch_module_id_"+item.module_id).val(item.id);
                                }
                            });
                        }
                    }
                }
            }); 
		});

        // jQuery.noConflict();
        // $('#editModal').on('show.bs.modal', function (event) {

		// 	var button = $(event.relatedTarget)
            
        //     var batchId = button.attr('data-batchId');
		// 	var batchName = button.attr('data-batchName');
            
        //     $.ajax({
        //         url: '/admin/batch_groups/edit/'+batchId+'/'+course_id,
        //         type: 'get',
        //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //         success: function (data) {
        //             console.log(data);
        //             if(data.code == 200) {
        //                 $("#batch_id").val(data.batch.id);
        //                 $("#update_group_name").val(data.batch.group_name);
        //                 if(data.batch_modules.length > 0) {
        //                     data.batch_modules.forEach(function(item,index) {
        //                         var module_id = $("#module_id_"+item.module_id).val();
        //                         if(module_id == item.module_id) {
        //                             $("#module_id_"+item.module_id).prop('checked', true);
        //                             $("#batch_module_id_"+item.module_id).val(item.id);
        //                         }
        //                     });
        //                 }
        //             }
        //         }
        //     }); 
        // });

        // $("#update_batch").on('click', function() {
        //     var batchId = $("#batch_id").val();
        //     var batchName = $("#update_group_name").val();

        //     $.ajax({
        //         url: '/admin/batch_groups/'+batchId,
        //         type: 'post',
        //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //         data: {
        //             batchName: batchName,
        //         },
        //         success: function (data) {
        //             if(data.code == 200) {
        //                 window.location.reload();
        //                 // location.href = '/question_group_names?course_id='+course_id;
        //             }
        //         }
        //     });
        // });


    });


</script>
@endpush
