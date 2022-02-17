@extends('layouts.app')

@section('title'){!! "Knowledge Blogs -" !!} @stop
@section('og-title'){!! "Knowledge Blogs" !!} @stop

@section('content')

<div class="container main-content-bg blogs-page pt-4">

    <div class="blogs-wrapper">
        <div class="row">
            @can('create')
            <div class="col-sm-12 col-12 text-right mb-4">
                <a href="{{url('/admin/knowledge-blogs/create')}}" class="btn btn-primary btn-sm">New Blog</a>
            </div>
            @endcan
        </div>
        <div class="row justify-content-center blogs-group">
            @forelse($blogs as $blog)
            <div class="col-sm-4 col-12 blog">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="blog-title font-weight-bold mb-2"> {{$blog->title}} </div>
                        <div class="description mb-2"> {!! $blog->description !!} </div>
                        
                        @if(!empty($blog->url))
                        <div class="url mb-2"> 
                           <a class="text-primary" href="{{$blog->url}}" target="_blank">{{$blog->url}} </a>
                        </div>
                        @endif

                        @if(count($blog->attachments) > 0)
                        <div class="attachment-wrapper mb-2">
                            @foreach($blog->attachments as $attach)
                                <div class="files"> <a href="{{$attach->attachment}}" download class="file-name"> 
                                    @if (strpos($attach->attachment, '.pdf') !== false)
                                        <i class="fileIcon fas fa-file-pdf"></i>
                                    @endif
                                    @if (strpos($attach->attachment, '.txt') !== false)
                                        <i class="fileIcon fas fa-file-alt"></i>
                                    @endif
                
                                    @if ((strpos($attach->attachment, '.doc') !== false) || (strpos($attach->attachment, '.docx') !== false))
                                    <i class="fileIcon fas fa-file-word"></i>
                                    @endif
                
                                    @if ((strpos($attach->attachment, '.xls') !== false) || (strpos($attach->attachment, '.xlsx') !== false))
                                    <i class="fileIcon fas fa-file-excel"></i>
                                    @endif
                
                                    @if ((strpos($attach->attachment, '.ppt') !== false) || (strpos($attach->attachment, '.pptx') !== false))
                                    <i class="fileIcon fas fa-file-powerpoint"></i>
                                    @endif
                                    {{basename($attach->attachment)}} 
                                </a> </div>
                            @endforeach
                        </div>
                        @endif

                        @if($blog->image)
                        <div class="blog-image mb-2"> <img src="{{$blog->image}}" alt="Knowledge Blog" width="100%"> </div>
                        @endif

                        @if($blog->video)
                        <div class="blog-video mb-2">
                            <video controls width="100%" data-setup='{"fluid": true}'>
                                <source src="{{$blog->video}}" type="video/mp4">
                            </video>
                        </div>
                        @endif

                        @if($blog->youtube_url)
                        <div class="blog-video only-youtube">
                            {!! $blog->youtube_url !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body"> 
                        <h3 class="text-center">Empty Knowledge Blog!</h3>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-sm-12 col-12">
                {{$blogs->links()}}
            </div>
        </div>
    </div>

    <div class="bottom-bg-wrapper">
        <img src="{{asset('/assets/images/course-bottom-bg.png')}}" alt="Courses Background Image">
    </div>

</div>
@endsection

@push('styles')
{{-- <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" /> --}}
<style>
.ytp-chrome-top {
    display: none;
}
.only-youtube video {
    width: 100%;
}
</style>
@endpush

@push('scripts')
{{-- <script src="http://vjs.zencdn.net/ie8/1.1.0/videojs-ie8.min.js"></script>
<script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
<script src="{{ asset('js/Youtube.min.js') }}"></script> --}}
<script>


</script>
@endpush