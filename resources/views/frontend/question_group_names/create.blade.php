@extends('layouts.app')
@push('styles')

@endpush
@section('content')
<div class="container group-name-page py-4">
    <div class="card">
        <div class="card-header">
        <h4>Create Question Group</h4>
        </div>
        <div class="card-body">
            {!! Form::open(array('route' => 'question_group_names.store','method'=>'POST')) !!}
                
            <input type="hidden" name="course_id" value="{{$course->id}}">
           
            <div class="row">
                <div class="col-md-8 col-sm-8 col-12">
                    <div class="form-group">
                        <label for="group_name">Group Name</label>
                        <input type="text" name="group_name" id="group_name" class="form-control" autocomplete="off" required placeholder="Group Name">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{url('/courses/detail/'.$course->slug)}}" class="btn btn-light">Cancel</a>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script>
$(document).ready(function() {
    $(function(){
        
    });
});
</script>
@endpush
