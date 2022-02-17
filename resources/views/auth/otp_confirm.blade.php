@extends('layouts.auth-app')

@section('content')
<div class="container register-confirm-page py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">

                <div class="card-body py-5 text-white text-center">
                    <div class="logo-wrapper mb-4">
                        <img src="{{asset('assets/images/psm-logo.png')}}" alt="PSM" width="80px">
                    </div>

                    <p>
                        အကောင့်အသစ်အတွက် Verification Code ကို <br>
                        {{$data['phone']}} သို့ ပို့လိုက်ပါပြီ။
                    </p>
                    <div class="row">
                        <div class="col-md-12 text-center">
                          @include('flash::message')
                        </div>
                    </div>

                    <form action="{{ route('store_user') }}" method="POST">
                        @csrf

                        <input type="hidden" name="name" id="name" value="{{$data['name']}}">
                        <input type="hidden" name="email" id="email" value="{{$data['email']}}">
                        <input type="hidden" name="phone" id="phone" value="{{$data['phone']}}">
                        <input type="hidden" name="password" id="password" value="{{$data['password']}}">

                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <input id="verification_code" type="text" class="form-control @error('verification_code') is-invalid @enderror" name="verification_code" required autocomplete="off" placeholder="Verification Code" autofocus>

                                @error('verification_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center mb-3">
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-primary brand-btn-color px-5">
                                    {{-- {{ __('Login') }} --}}
                                    Continue
                                </button>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center mb-1">
                            <div class="col-md-9">
                                <button type="button" class="btn btn-secondary px-4" id="timer" disabled></button>
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
        var timer = 60;
        var goTimer = true;
        var interval = setInterval(function(){
            if(goTimer == true) {
                timer = parseInt(timer) - 1;
                $("#timer").text(timer+'s');
            }
            
            if(timer == 0) {
                goTimer = false;
                timer = 60;

                $("#timer").text('Resend OTP').removeAttr('disabled');
            }
        },1000);

        $("#timer").click(function() {
            var phone = $("#phone").val();
            var is_register = $("#is_register").val();

            $.ajax({
                type:'get',
                url:'/resend_otp',
                data:{
                    phone: phone,
                    is_register: is_register,
                },
                success:function(response){
                    goTimer = true;
                    $("#timer").attr('disabled',true);
                }
            });
        });
    });
</script>
@endpush