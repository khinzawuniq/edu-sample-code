@extends('layouts.app')
@push('styles')
    <style>
        .psmModalHeader {
            background: rgba(1,1,209, 0.5);
        }
    </style>
@endpush
@section('content')
<div class="container enrole-user-page py-4">
    <div class="row mb-3">
        <div class="col-12 text-right">
            <button type="button" onclick="window.history.back()" class="btn btn-secondary btn-sm">Back</button>
        </div>
    </div>
    <table class="table table-striped datatable">
        <thead>
            <tr class="bg-info">
                <th>Name</th>
                <th>Assignment Submission Date</th>
                <th>File</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $key => $assignment)
            <tr>
                <td>{{$assignment->student->name}}</td>
                <td>{{$assignment->submission_date}}</td>
            <td><a style="text-decoration:underline" href="{{asset('uploads/assignments/'.$assignment->assignment_file)}}" download="">{{$assignment->assignment_file}}</a></td>
            <td><button class="btn-success btn btn-sm" onclick="setAssignment({{$assignment->id}})" data-toggle="modal" data-target="#submission"><i class="fas fa-check"></i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="submission" tabindex="-1" aria-labelledby="submissionLabel" aria-hidden="true">
        <div class="modal-dialog">
        <form action="/admin/grade-assingment" method="post">
            @csrf
          <div class="modal-content">
            <div class="modal-header psmModalHeader">
              <h5 class="modal-title text-white" id="submissionLabel">Grade Assignment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="assignment_id" id="assignment_id" value="">
                    <div class="form-group">
                        <label for="mark">Mark</label>
                        <input type="number" name="mark" id="mark" min="1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="remark">Remarks</label>
                        <textarea name="remark" id="remark" cols="30" rows="5" class="form-control"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        function setAssignment(id){
            $('#assignment_id').val(id);
        }
    </script>
@endpush
