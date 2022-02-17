    @php
      $programmes = \App\Models\CourseCategory::All();
    @endphp

    @if(!empty($programmes))
    <div class="row justify-content-center m-0">
      <div class="col-12 p-0">
        <nav class="navbar navbar-expand-lg bg-brand programmes-menu">
          <ul class="navbar-nav mr-auto ml-auto">
            @foreach($programmes as $p)
            <li class="nav-item">
              <a class="nav-link text-center" href="{{url('/courses/category/'.$p->slug)}}">
                <i class="fas fa-graduation-cap"></i>
                <p class="mb-0">{{$p->name}}</p>
              </a>
            </li>
            @endforeach
          </ul>
        </nav>
      </div>
    </div>
    @endif