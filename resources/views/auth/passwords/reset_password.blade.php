@extends('layouts.auth-app')

@section('content')
<div class="container change-password-page py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header brand-bg-color text-light">{{ __('Reset Password') }}</div> --}}

                <div class="card-body py-4 text-white text-center">

                    <div class="logo-wrapper mb-5">
                        <img src="{{asset('assets/images/psm-logo.png')}}" alt="PSM" width="80px">
                    </div>

                    <form method="POST" action="/password/reset">
                        @csrf

                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <input type="hidden" name="email" value="{{$user->email}}">
                        <input type="hidden" name="phone" value="{{$user->phone}}">
                        {{-- <div class="form-group row justify-content-center">

                            <div class="col-md-9">
                                
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $data['phone'] ?? old('phone') }}" required placeholder="Phone" readonly>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group row password-wrapper justify-content-center">

                            <div class="col-md-9">
                                <div class="input-group">
                                    <input id="old_password" type="password" class="form-control old_password @error('old_password') is-invalid @enderror" name="old_password" required placeholder="Old Password" autocomplete="off" autofocus>
                                    <span class="btn-old-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>

                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row password-wrapper justify-content-center">
                            
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control password @error('password') is-invalid @enderror" name="password" required placeholder="New Password">
                                    <span class="btn-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                                
                                <small class="mm text-left"> Password ပေးသည့်အခါ အနည်းဆုံး (၆) လုံး ပေးရပါမည်။ </small>
                                @error('password')
                                    <span class="invalid-feedback show" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row password-wrapper justify-content-center">

                            <div class="col-md-9">
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control confirm_password" name="password_confirmation" required placeholder="Confirm Password">
                                    <span class="btn-confirm-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                                
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
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

@push('styles')
<style>
    .invalid-feedback.show {
        display: block;
    }
</style>
@endpush

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
        // $('.btn-password').click(function(){
        //     if('password' == $('.password').attr('type')){
        //         $('.password').prop('type', 'text');
        //     }else{
        //         $('.password').prop('type', 'password');
        //     }
        // });
        // $('.btn-confirm-password').click(function(){
        //     if('password' == $('.confirm_password').attr('type')){
        //         $('.confirm_password').prop('type', 'text');
        //     }else{
        //         $('.confirm_password').prop('type', 'password');
        //     }
        // });
    });
</script>
@endpush