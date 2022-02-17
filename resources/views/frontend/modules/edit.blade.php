@extends('layouts.app')
@push('styles')
@endpush
@section('content')
<div class="container course-page">
    <div class="card">
        <div class="card-header">
        <h2>Summary of <strong>{{$courseModule->name}}</strong></h2>
        </div>
        <div class="card-body">
            {!! Form::model($courseModule, ['method' => 'PATCH','enctype'=>'multipart/form-data', 'files'=>true,'route' => ['course_modules.update', $courseModule->id]]) !!}
                
            <div class="form-group">
                <label for="name">Module name</label>
            <input type="text" name="name" id="name" class="form-control" autocomplete="off" required placeholder="Module Name" value="{{$courseModule->name}}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control psmeditor" autocomplete="off" cols="30" rows="10" placeholder="Module Description">{{$courseModule->description}}</textarea>
            </div>
             <button type="submit" class="btn btn-success">Save & Display</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@push('scripts')
 <script>
             $('.psmeditor').summernote({
            height: 200,
            width:'100%',
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
        ]
        });
 </script>
@endpush