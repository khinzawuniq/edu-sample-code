@extends('layouts.admin-app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Knowledge Blogs</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

  <div class="card">
    {!! Form::open(array('route' => 'knowledge-blogs.store','method'=>'POST')) !!}
      <div class="card-header">
          <div class="card-title">
            Campus Create
          </div>
      </div>
      <div class="card-body" >
    
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Blog Category <span class="text-danger">*</span></label>
                    {!! Form::select('blog_category_id', $categories, null,['placeholder' => 'Select Category','class' => 'form-control', 'required'=>true]) !!}
                    @if ($errors->has('blog_category_id'))
						<span class="text-danger validate-message">{{ $errors->first('blog_category_id') }}</span>
					@endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Title <span class="text-danger">*</span></label>
                    {!! Form::text('title', old('title'), ['placeholder' => 'Enter Title','class' => 'form-control', 'required'=>true]) !!}
                    @if ($errors->has('title'))
						<span class="text-danger validate-message">{{ $errors->first('title') }}</span>
					@endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Description </label>
                    {!! Form::textarea('description', old('description'), array('class' => 'form-control textarea', 'placeholder'=>'Enter Description')) !!}
                </div>
            </div>
        </div>
        {{-- <div class="row mb-3">
            <div class="col-12 files-wrapper">
                <input type="hidden" name="file_count" id="file_count" value="1">
                <div class="form-group file-1">
                    <label>Attachment Files</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                        <a data-input="attachment_1" data-preview="holder" class="btn btn-primary text-white lfm">
                         <i class="far fa-image"></i> Choose
                        </a>
                        </span>
                        <input id="attachment_1" class="form-control" type="text" name="attachment[]">
                    </div>
                </div>
            </div>
            <div class="col-12 text-right">
                <button type="button" class="btn btn-success btn-sm" onClick="addFile()"><i class="fas fa-plus-circle"></i> Add More Files</button>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Attachment Files (PDF,Excel,Word,Text File,Power Point)</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                        <a data-input="blog_attachment" data-preview="holder" class="btn btn-primary text-white lfm">
                         <i class="far fa-image"></i> Choose
                        </a>
                        </span>
                        <input id="blog_attachment" class="form-control" type="text" name="blog_attachment">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Image </label>
                    <div class="input-group">
                        <span class="input-group-btn">
                        <a data-input="image" data-preview="holder" class="btn btn-primary text-white lfm">
                         <i class="far fa-image"></i> Choose
                        </a>
                        </span>
                        <input id="image" class="form-control" type="text" name="image">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="url">URL</label>
                    {!! Form::textarea('url', old('url'), ['placeholder' => 'Enter URL','rows'=>3,'class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="">Select Video Upload Type</label>
                <div class="form-group">
                    <label for="video_upload" style="margin-right: 20px;font-weight:300;">
                        <input type="radio" name="video_upload_type" id="video_upload" class="upload-type" value="0"> Video Upload
                    </label>
                    <label for="youtube_upload" style="font-weight:300;">
                        <input type="radio" name="video_upload_type" id="youtube_upload" class="upload-type" value="1"> Youtube URL
                    </label>
                </div>
            </div>

            <div class="col-12 video-type video d-none">
                <div class="form-group">
                    <label>Video</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                        <a data-input="video" data-preview="holder" class="btn btn-primary text-white lfm">
                         <i class="far fa-image"></i> Choose
                        </a>
                        </span>
                        <input id="video" class="form-control" type="text" name="video">
                    </div>
                </div>
            </div>
            <div class="col-12 video-type youtube-url d-none">
                <div class="form-group">
                    <label for="youtube_url">Youtube URL</label>
                    {!! Form::textarea('youtube_url', old('youtube_url'), ['placeholder' => 'Enter Youtube URL','rows'=>3,'class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary brand-btn-color">Save</button>
                    <a href="{{route('knowledge-blogs.index')}}" class="btn btn-default"> Cancel </a>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
      </div>
  </div>

</section>
<!-- /.content -->

@endsection

@push('styles')
<style>

</style>
@endpush

@push('scripts')
<script>
    $(function() {
        $('.lfm').filemanager('file');

        $(".upload-type").click(function() {
            var type = $(this).val();
            if(type == 0) {
                $(".video-type").removeClass('d-none');

                $(".youtube-url").addClass('d-none');
            }else {
                $(".video-type").removeClass('d-none');

                $(".video").addClass('d-none');
            }
        });

    });


    // var countFile = 1;

    // function addFile()
    // {
    //     var countRow = countFile + 1;
    //     $('#file_count').val(countRow);
    //     countFile++;
    //     console.log(countRow);
    //     $(".files-wrapper").append(
    //         '<div class="form-group file-'+countRow+'">'+
    //             '<div class="row">'+
    //                 '<div class="col-10">'+
    //                     '<div class="input-group">'+
    //                         '<span class="input-group-btn">'+
    //                         '<a data-input="attachment_'+countRow+'" data-preview="holder" class="btn btn-primary text-white lfm">'+
    //                             '<i class="far fa-image"></i> Choose'+
    //                         '</a>'+
    //                         '</span>'+
    //                         '<input id="attachment_'+countRow+'" class="form-control" type="text" name="attachment[]">'+
    //                     '</div>'+      
    //                 '</div>'+
    //                 '<div class="col-2"> <button type="button" class="btn btn-danger btn-sm" onClick="removeFile('+countRow+')"><i class="far fa-times-circle"></i></button> </div>'+
    //             '</div>'+
    //         '</div>'
    //     );

    //     $('.lfm').filemanager('file');
    // }

    // function removeFile(row)
    // {
    //     console.log(row);
    //     if(countFile == 1)
    //     {
    //         alert('There has to be at least one line');
    //         return false;
    //     }
    //     else
    //     {
    //         $('.file-'+row).remove();
    //         countFile--;

    //         $('#file_count').val(countFile);
    //     }
    // }

</script>
@endpush