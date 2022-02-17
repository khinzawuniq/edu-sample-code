@extends('layouts.app')

@section('title'){!! $blog->title." -" !!} @stop
@section('og-title'){!! $blog->title." -" !!} @stop
@section('og-image'){!! $blog->image ? asset($blog->image) : asset($setting->default_image) !!} @stop
@section('meta-description'){{ $blog->description }} @stop 

@section('content')

<div class="container main-content-bg blog-detail-page pt-4">

    <div class="blogs-wrapper">
        <div class="card blogs-group mb-5">
            <div class="card-body">

                @if($blog->video)
                <div class="blog-video mb-3">
                    <video controls width="100%" data-setup='{"fluid": true}'>
                        <source src="{{$blog->video}}" type="video/mp4">
                    </video>
                </div>
                @endif

                @if($blog->youtube_url)
                <div class="blog-video only-youtube mb-3">
                    {!! $blog->youtube_url !!}
                </div>
                @endif

                @if(empty($blog->video) && empty($blog->youtube_url))
                    @if($blog->image)
                    <div class="blog-image mb-3"> <img src="{{$blog->image}}" alt="Knowledge Blog" width="100%"> </div>
                    @else
                    <div class="blog-image mb-3"> <img src="{{url($setting->default_image)}}" alt="Knowledge Blog" width="100%"> </div>
                    @endif
                @endif

                <div class="blog-title font-weight-bold mb-3"> {{$blog->title}} </div>
                <div class="description text-justify mb-3"> {!! $blog->description !!} </div>
                
                @if(!empty($blog->url))
                <div class="url mb-2"> 
                   <a class="text-primary" href="{{$blog->url}}" target="_blank">{{$blog->url}} </a>
                </div>
                @endif

                <div class="attachment-wrapper mb-2">
                    @php
                        $downloadFiles = explode(',',$blog->blog_attachment);
                    @endphp
                    
                    @foreach($downloadFiles as $attach)
                        <div class="files"> <a href="{{$attach}}" download class="file-name"> 
                            @if (strpos($attach, '.pdf') !== false)
                                <i class="fileIcon fas fa-file-pdf"></i>
                            @endif
                            @if (strpos($attach, '.txt') !== false)
                                <i class="fileIcon fas fa-file-alt"></i>
                            @endif
        
                            @if ((strpos($attach, '.doc') !== false) || (strpos($attach, '.docx') !== false))
                            <i class="fileIcon fas fa-file-word"></i>
                            @endif
        
                            @if ((strpos($attach, '.xls') !== false) || (strpos($attach, '.xlsx') !== false))
                            <i class="fileIcon fas fa-file-excel"></i>
                            @endif
        
                            @if ((strpos($attach, '.ppt') !== false) || (strpos($attach, '.pptx') !== false))
                            <i class="fileIcon fas fa-file-powerpoint"></i>
                            @endif
                            {{basename($attach)}} 
                        </a> </div>
                    @endforeach
                </div>

                {{-- @if(count($blog->attachments) > 0)
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

            </div>
        </div>

        <div class="related-blog">
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="related-blog-title text-center">Related Blogs</h3>
                </div>
            </div>
            <div class="row">
                @foreach($related_blogs as $b)
                <div class="col-md-3 col-sm-6 col-12 blog">
                    <div class="card mb-3">
                        <a href="{{url('/blogs/'.$b->slug)}}">
                            @if($b->image)
                            <div class="blog-image mb-2"> <img src="{{$b->image}}" alt="Knowledge Blog" width="100%"> </div>
                            @else
                            <div class="blog-image mb-2"> <img src="{{url($setting->default_image)}}" alt="Knowledge Blog" width="100%"> </div>
                            @endif
                        </a>
                        <div class="blog-content-group">
                            <div class="blog-title font-weight-bold px-2 mb-1"> 
                                <a href="{{url('/blogs/'.$b->slug)}}">{{$b->title}} </a>
                            </div>
    
                            <div class="detail-link px-2 text-right">
                                <a href="{{url('/blogs/'.$b->slug)}}" class="btn btn-warning btn-sm brand-btn-gold">See More... </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bottom-bg-wrapper">
        <img src="{{asset('/assets/images/course-bottom-bg.png')}}" alt="Courses Background Image">
    </div>

</div>

<!-- Modal -->
@if($blogAd)
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
@endif

@endsection

@push('styles')
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
<script>
$(function() {
    
    showAds();
    
    function showAds()
    {
        jQuery.noConflict();
        $("#adsModal").modal('show');
    }

});
</script>
@endpush