<div class="container main-slide p-0">
    <div class="row justify-content-center m-0">
        <div class="col-md-12 p-0">
            <div id="carouselExampleControls" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                  
                  @foreach($slideshows as $key=>$slide)

                    <div class="carousel-item {{($key==0)?'active':''}}">
                      <img class="d-block w-100" src="{{url($slide->slide_photo)}}" alt="PSM INTERNATIONAL COLLEGE">
                      <div class="carousel-caption d-md-block text-left">
                          <h4 class="download-mobile slide-label"> <a href="#">DOWNLOAD MOBILE APPS</a> </h4>
                          <h5 class="payment slide-label"> <a href="{{url('/payments')}}">PAYMENT</a> </h5>
                      </div>
                    </div>

                  @endforeach

                  {{-- <div class="carousel-item active">
                    <img class="d-block w-100" src="{{asset('/assets/images/slide1.png')}}" alt="PSM INTERNATIONAL COLLEGE">
                    <div class="carousel-caption d-none d-md-block text-left">
                        <h4 class="download-mobile slide-label"> <a class="text-white" href="#">Download Mobile Apps</a> </h4>
                        <h5 class="payment slide-label"> <a class="text-white" href="{{url('/payments')}}">Payment</a> </h5>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="{{asset('/assets/images/slide2.png')}}" alt="PSM INTERNATIONAL COLLEGE">
                    <div class="carousel-caption d-none d-md-block text-left">
                      <h4 class="download-mobile slide-label"> <a class="text-white" href="#">Download Mobile Apps</a> </h4>
                      <h5 class="payment slide-label"> <a class="text-white" href="{{url('/payments')}}">Payment</a> </h5>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="{{asset('/assets/images/slide3.png')}}" alt="PSM INTERNATIONAL COLLEGE">
                    <div class="carousel-caption d-none d-md-block text-left">
                      <h4 class="download-mobile slide-label"> <a class="text-white" href="#">Download Mobile Apps</a> </h4>
                      <h5 class="payment slide-label"> <a class="text-white" href="{{url('/payments')}}">Payment</a> </h5>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="{{asset('/assets/images/slide4.png')}}" alt="PSM INTERNATIONAL COLLEGE">
                    <div class="carousel-caption d-none d-md-block text-left">
                      <h4 class="download-mobile slide-label"> <a class="text-white" href="#">Download Mobile Apps</a> </h4>
                      <h5 class="payment slide-label"> <a class="text-white" href="{{url('/payments')}}">Payment</a> </h5>
                    </div>
                  </div> --}}
                </div>

                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  {{-- <span class="carousel-control-prev-icon carousel-nav" aria-hidden="true"></span> --}}
                  <span class="carousel-nav d-flex align-items-center justify-content-center" aria-hidden="true">&lsaquo;</span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  {{-- <span class="carousel-control-next-icon carousel-nav" aria-hidden="true"></span> --}}
                  <span class="carousel-nav d-flex align-items-center justify-content-center" aria-hidden="true">&rsaquo;</span>
                  <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    @include('frontend.categories')
    {{-- @php
      $programmes = \App\Models\CourseCategory::All();
    @endphp

    @if(!empty($programmes))
    <div class="row justify-content-center m-0">
      <div class="col-12 p-0">
        <nav class="navbar navbar-expand-lg bg-brand programmes-menu">
          <ul class="navbar-nav mr-auto ml-auto">
            @foreach($programmes as $p)
            <li class="nav-item">
              <a class="nav-link text-center" href="{{url('/courses/category/'.$p->id)}}">
                <i class="fas fa-graduation-cap"></i>
                <p class="mb-0">{{$p->name}}</p>
              </a>
            </li>
            @endforeach
          </ul>
        </nav>
      </div>
    </div>
    @endif --}}

</div>