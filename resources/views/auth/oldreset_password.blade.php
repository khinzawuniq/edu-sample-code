@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header brand-bg-color text-light">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="/password/reset">
                        @csrf

                        {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}
                        {{-- <input type="hidden" name="token" value="{{request()->get('token')}}"> --}}

                        {{-- <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ request()->get('email') ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        {{-- <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                                
                                @if(Session::has('login_username'))
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ Session::get('login_username') ?? old('username') }}" required autocomplete="username" placeholder="Enter Username">
                                @else
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ request()->get('username') ?? old('username') }}" required autocomplete="username" placeholder="Enter Username">
                                @endif

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Email / Phone</label>

                            <div class="col-md-6">
                                
                                @if(Session::has('login_username'))
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ Session::get('login_username') ?? old('username') }}" required autocomplete="username" placeholder="Enter Email/Phone">
                                @else
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ request()->get('username') ?? old('username') }}" required autocomplete="username" placeholder="Enter Email/Phone">
                                @endif

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row password-wrapper">
                            <label for="old_password" class="col-md-4 col-form-label text-md-right"> Old Password </label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="old_password" type="password" class="form-control old_password @error('old_password') is-invalid @enderror" name="old_password" required autocomplete="old_password" autofocus>
                                    <span class="btn-old-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>

                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row password-wrapper">
                            <label for="password" class="col-md-4 col-form-label text-md-right"> New Password </label>
                            
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control password @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <span class="btn-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                                
                                {{-- <small style="line-height: 1;">The password must have at least 8 characters, at least 1 digit(s), at least 1 lower case letter(s), at least 1 upper case letter(s), at least 1 non-alphanumeric character(s) such as as *, -, or #</small> --}}
                                {{-- <small style="line-height: 1;" class="mm"> Password ပေးသည့်အခါ အနည်းဆုံး (၈) လုံး ပေးရပါမည်။ အဆိုပါ (၈) လုံးတွင် အသေးစာလုံးတစ်ခု၊ အကြီးစာလုံးတစ်ခု၊ ကိန်းဂဏန်းတစ်ခု၊ အထူးစာလုံးတစ်ခု ပါရှိရပါမည်။ (ဥပမာ - PsmLms123$) </small> --}}
                                <small class="mm text-left"> Password ပေးသည့်အခါ အနည်းဆုံး (၆) လုံး ပေးရပါမည်။ </small>
                                {{-- @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}
                            </div>
                        </div>

                        <div class="form-group row password-wrapper">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control confirm_password" name="password_confirmation" required autocomplete="new-password">
                                    <span class="btn-confirm-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary brand-btn-color">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('.btn-old-password').click(function(){
            if('password' == $('.old_password').attr('type')){
                $('.old_password').prop('type', 'text');
            }else{
                $('.old_password').prop('type', 'password');
            }
        });
        $('.btn-password').click(function(){
            if('password' == $('.password').attr('type')){
                $('.password').prop('type', 'text');
            }else{
                $('.password').prop('type', 'password');
            }
        });
        $('.btn-confirm-password').click(function(){
            if('password' == $('.confirm_password').attr('type')){
                $('.confirm_password').prop('type', 'text');
            }else{
                $('.confirm_password').prop('type', 'password');
            }
        });
    });
</script>
@endpush