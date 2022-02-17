@extends('layouts.auth-app')

@section('content')
<div class="container email-page py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">

                <div class="card-body py-5 text-white text-center">
                    <div class="logo-wrapper mb-5">
                        <img src="{{asset('assets/images/psm-logo.png')}}" alt="PSM" width="80px">
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.request_phone') }}">
                        @csrf

                        @if(Auth::check()) 
                        <input type="hidden" name="is_change_password" id="is_change_password" value="1">
                        @else
                        <input type="hidden" name="is_reset" id="is_reset" value="1">
                        @endif
                        

                        <div class="form-group row justify-content-center mb-4">

                            <div class="col-md-9">
                                <input id="phone" type="text" class="form-control text-center @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="Phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-primary brand-btn-color">
                                    Request OTP
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
