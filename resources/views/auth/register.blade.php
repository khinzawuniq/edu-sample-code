@extends('layouts.auth-app')

@section('content')
<div class="container register-page py-5">
                
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">

                <div class="card-body py-4 text-white text-center">

                    <div class="logo-wrapper mb-4">
                        <img src="{{asset('assets/images/psm-logo.png')}}" alt="PSM" width="80px">
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                          @include('flash::message')
                        </div>
                    </div>

                    {{-- <form method="POST" action="{{ route('request_otp') }}"> --}}
                    {{-- <form method="POST" action="{{ route('register') }}"> --}}
                    <form method="POST" action="{{ route('student_register') }}">
                        @csrf

                        <input type="hidden" name="is_register" id="is_register" value="1">

                        <div class="form-group row justify-content-center">
                            {{-- <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label> --}}

                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Name" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> --}}

                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Email" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row justify-content-center">
                            {{-- <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label> --}}

                            <div class="col-md-10">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required placeholder="Phone" autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row password-wrapper justify-content-center">
                            {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> --}}

                            <div class="col-md-10 text-left">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control password @error('password') is-invalid @enderror" name="password" required placeholder="Password" autocomplete="new-password">
                                    <span class="btn-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                                <small class="mm text-left"> Password ပေးသည့်အခါ အနည်းဆုံး (၆) လုံး ပေးရပါမည်။ </small>
                                {{-- <small class="mm text-left">The password must have at least 6 characters.</small> --}}

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row password-wrapper mb-5 justify-content-center">
                            {{-- <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label> --}}

                            <div class="col-md-10">
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control confirm_password" name="password_confirmation" required placeholder="Confirm Password" autocomplete="new-password">
                                    <span class="btn-confirm-password text-secondary"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center mb-0">
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary px-5">
                                    {{ __('Register') }}
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
    .card {
        max-width: 450px;
    }   
</style>
@endpush

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush