@extends('layouts.auth-app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                

                <div class="card-body py-4 text-white text-center">
                    <div class="logo-wrapper mb-5">
                        <img src="{{asset('assets/images/psm-logo.png')}}" alt="PSM" width="80px">
                    </div>
                    {{-- <form method="POST" action="{{ route('password.update') }}"> --}}
                    <form method="POST" action="{{ route('my_password.update') }}">
                        @csrf

                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <p>You must change your password on this first time sign in.</p>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">

                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? old('email') }}" required readonly>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center password-wrapper">
                            <div class="col-md-9">
                                
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control password @error('password') is-invalid @enderror" name="password" required placeholder="New Password">
                                    <span class="btn-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                                
                                <small class="mm text-left"> Password ပေးသည့်အခါ အနည်းဆုံး (၆) လုံး ပေးရပါမည်။ </small>
                                
                            </div>
                        </div>

                        <div class="form-group row justify-content-center password-wrapper">
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

@push('scripts')
<script type="text/javascript">
    $(function(){
        
    });
</script>
@endpush