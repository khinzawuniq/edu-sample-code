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
            <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#createModal">New Question Group</a>
            <a href="{{url('/courses/detail/'.$course->slug)}}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr class="bg-primary">
                <th>SrNo</th>
                <th>Group Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($group_names as $key=>$group)
            <tr>
                <td data-column="SrNo">{{$key+1}}</td>
                <td data-column="Group Name"> 
                    <a href="{{url('question_group_names/'.$group->id)}}" class="group-name"> {{$group->group_name}} </a> 
                </td>
                <td data-column="Action">
                    {{-- <a href="{{ route('question_group_names.edit', $course_id)}}"><i class="fa fa-edit text-warning"></i></a> --}}
                    <a href="#" id="edit_group" data-toggle="modal" data-target="#editModal" data-groupId="{{$group->id}}" data-groupName="{{$group->group_name}}"><i class="fa fa-edit text-warning"></i></a>
                    <i class="fa fa-trash text-danger deleteData">
                      <form action="{{ route('question_group_names.destroy', $group->id) }}" method="post" style="display: none;" class="deleteDataForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                        <button type="submit"></button>
                      </form>
                    </i>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

{{-- Edit --}}
<div class="modal fade" id="editModal" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="editModalLabel">Edit Question Group</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
            <form action="#" id="groupNameForm">
                <input type="hidden" name="group_id" id="group_id">
                <div class="form-group">
                    <label for="group_name">Group Name</label>
                    <input type="text" name="group_name" id="group_name" class="form-control" autocomplete="off" required placeholder="Group Name">
                </div>

                <button type="button" id="update_group" class="btn btn-success">Save</button>
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancel</button>
            </form>
        </div>
        
        </div>
    </div>
    </div>
{{-- End --}}
{{-- Create --}}
<div class="modal fade" id="createModal" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="createModalLabel">Create Question Group</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="modal-body">
            <form action="#" id="groupNameForm">
                
                <div class="form-group">
                    <label for="name">Group Name</label>
                    <input type="text" name="group_name" id="name" class="form-control" autocomplete="off" required placeholder="Group Name">
                </div>

                <button type="button" id="add_group" class="btn btn-success">Save</button>
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
        var course_id = {{$course->id}};
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

        $("#update_group").on('click', function() {
            var groupId = $("#group_id").val();
            var groupName = $("#group_name").val();
            $.ajax({
                url: '/question_group_names/'+groupId,
                type: 'patch',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    group_name: groupName,
                },
                success: function (data) {
                    if(data.code == 200) {
                        // window.location.reload();
                        location.href = '/question_group_names?course_id='+course_id;
                    }
                }
            });
        });
        
        $("#add_group").on('click', function() {
            var groupName = $("#name").val();
            if(groupName != '') {
                $.ajax({
                    url: '/question_group_names/store-group',
                    type: 'post',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        group_name: groupName,
                    },
                    success: function (data) {
                        if(data.code == 200) {
                            // window.location.reload();
                            location.href = '/question_group_names?course_id='+course_id;
                        }
                    }
                });
            }
        });

        $('#edit_group').on('click', function () {
                
				var button = $(this);
				
				var groupId = button.attr('data-groupId');
				var groupName = button.attr('data-groupName');
                
				$("#group_id").val(groupId);
                $("#group_name").val(groupName);
		});
    });

    // function editGroup(id)
    // {
    //     $.ajax({
    //             url: '/question_group_names/'+id+'/edit',
    //             type: 'get',
    //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //             success: function (data) {
    //                 if(data.code == 200) {
    //                     $("#group_id").val(data.group.id);
    //                     $("#group_name").val(data.group.group_name);
                        
    //                 }
    //             }
    //     });
    // }
</script>
@endpush
