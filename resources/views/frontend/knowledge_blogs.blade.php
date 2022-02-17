@extends('layouts.app')

@section('title'){!! "Blogs -" !!} @stop
@section('og-title'){!! "Blogs" !!} @stop
@section('og-image'){!! $blogs[0]->image ? asset($blogs[0]->image) : asset($setting->default_image) !!} @stop

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
        @foreach($blogs->chunk(3) as $blogCollection)
        <div class="row blogs-group mb-3">
            @forelse($blogCollection as $blog)
            <div class="col-sm-4 col-12 blog">
                <div class="card mb-3">
                    {{-- <div class="card-body p-0"> --}}
                        
                        <a href="{{url('/blogs/'.$blog->slug)}}">
                        @if($blog->image)
                        <div class="blog-image mb-2"> <img src="{{$blog->image}}" alt="Knowledge Blog" width="100%"> </div>
                        @else
                        <div class="blog-image mb-2"> <img src="{{url($setting->default_image)}}" alt="Knowledge Blog" width="100%"> </div>
                        @endif
                        </a>

                        <div class="blog-content-group">
                            <div class="blog-title font-weight-bold px-2 mb-1"> 
                                <a href="{{url('/blogs/'.$blog->slug)}}">{{$blog->title}} </a>
                            </div>

                            {{-- <div class="description text-justify px-2 mb-2"> {!! Str::limit($blog->description, 90, $end='...') !!} </div> --}}
    
                            <div class="detail-link px-2 text-right">
                                <a href="{{url('/blogs/'.$blog->slug)}}" class="btn btn-warning btn-sm brand-btn-gold">See More... </a>
                            </div>
                        </div>
                        
                        {{-- @if(!empty($blog->url))
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
                        @endif --}}

                        {{-- @if($blog->video)
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
                        @endif --}}
                    {{-- </div> --}}
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
        @endforeach
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

<!-- Modal -->
{{-- @if($blogAd)
<div class="modal fade" id="adsModal" tabindex="-1" role="dialog" aria-labelledby="adsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <a href="{{$blogAd->ads_url}}">
                <img src="{{url($blogAd->ads_image)}}" alt="PSM Ads" class="img-fluid">
            </a>

            <a href="{{$blogAd->ads_url}}" class="btn btn-primary btn-sm" id="ads_url">See More</a>
        </div>
      </div>
    </div>
</div>
@endif --}}

@endsection

@push('styles')

<style>
.ytp-chrome-top {
    display: none;
}
.only-youtube video {
    width: 100%;
}
/* #adsModal .modal-body {
    position: relative;
    padding: 0;
}
#adsModal .close {
    position: absolute;
    right: 20px;
    top: 20px;
    color: #2176bd;
    font-size: 2rem;
    font-weight: 500;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: #fff;
    opacity: 1;
    line-height: .5;
}
#ads_url {
    position: absolute;
    bottom: 20px;
    right: 20px;
} */
</style>
@endpush

@push('scripts')
<script>
$(function() {
    // showAds();
    
    // function showAds()
    // {
    //     jQuery.noConflict();
    //     $("#adsModal").modal('show');
    // }
});
</script>
@endpush