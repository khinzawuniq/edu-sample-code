@extends('layouts.auth-app')

@section('content')
<div class="container login-page py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">

                <div class="card-body py-5 text-white text-center">
                    <div class="logo-wrapper mb-4">
                        <img src="{{asset('assets/images/psm-logo.png')}}" alt="PSM" width="80px">
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                          @include('flash::message')
                        </div>
                    </div>

                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <input type="hidden" id="auto" name="auto" value="{{(Request::get('username') && Request::get('password')) ? true : ''}}">
                        <input type="hidden" name="web_id" id="web_id">
                        <input type="hidden" name="platform_web" id="platform_web">

                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username',Request::get('username')) }}" required autocomplete="username" placeholder="Email or Phone Number" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row password-wrapper justify-content-center">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" value="{{old('password', Request::get('password'))}}">
                                    <span class="btn-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center mb-4 text-left">
                            <div class="col-md-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-primary brand-btn-color px-5">
                                    {{-- {{ __('Login') }} --}}
                                    Sign In
                                </button>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center mb-1">
                            <a class="btn btn-link password-forgot" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            {{-- @if (Route::has('password.request'))
                                <a class="btn btn-link password-forgot" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif --}}
                        </div>

                        <div class="form-group row justify-content-center mb-0">
                            <p class="text-muted mb-0">
                                Password မေ့နေပါက <br> Forgot Password ကိုနှိပ်ပါ။
                            </p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('/js/device-uuid/device-uuid.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    var uuid = new DeviceUUID().get();
    var du = new DeviceUUID().parse();
    
    $("#web_id").val(uuid);

    if(du.isMac) {
        $("#platform_web").val("Mac");
    }else {
        $("#platform_web").val(du.os);
    }
    

    // var dua = [
    //     du.browser,
    //     du.language,
    //     du.platform,
    //     du.os,
    //     du.cpuCores,
    //     du.isAuthoritative,
    //     du.silkAccelerated,
    //     du.isKindleFire,
    //     du.isDesktop,
    //     du.isMobile,
    //     du.isTablet,
    //     du.isWindows,
    //     du.isLinux,
    //     du.isLinux64,
    //     du.isMac,
    //     du.isiPad,
    //     du.isiPhone,
    //     du.isiPod,
    //     du.isSmartTV,
    //     du.pixelDepth,
    //     du.isTouchScreen
    // ];

    // console.log(dua);
    var autoFill = $('#auto').val();
    if(autoFill){
        $('#loginForm').submit();
    }

    $('.btn-password').click(function(){
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    });
    
</script>
@endpush