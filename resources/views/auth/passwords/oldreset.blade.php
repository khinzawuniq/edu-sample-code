@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header brand-bg-color text-light">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    {{-- <form method="POST" action="{{ route('password.update') }}"> --}}
                    <form method="POST" action="{{ route('my_password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{request()->get('token')}}">
                        {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}

                        {{-- <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ request()->get('email') ?? old('email') }}" required autocomplete="email" autofocus>
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Email / Phone</label>
                            {{-- <label for="username" class="col-md-4 col-form-label text-md-right">Username</label> --}}

                            <div class="col-md-6">
                                
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ request()->get('username') ?? old('username') }}" required autocomplete="username" placeholder="Enter Email/Phone">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row password-wrapper">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control password @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <span class="btn-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                                
                                {{-- <small style="line-height: 1;" class="mm">The password must have at least 8 characters, at least 1 digit(s), at least 1 lower case letter(s), at least 1 upper case letter(s), at least 1 non-alphanumeric character(s) such as as *, -, or #</small> --}}
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