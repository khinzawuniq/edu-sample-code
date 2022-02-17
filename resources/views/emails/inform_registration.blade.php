@component('mail::message')
# Inform Registration

Dear {{$content->name}},

{{-- You have registered in PSM INTERNATIONAL COLLEGE. --}}
{!! $setting->email_letter !!}

Your Login Account:<br>
Username: {{$content->email}}<br>
Password: {{$password}}<br> 
Link    : <a href="{{$link}}">{{$link}}</a> <br> <br>

{{-- Please after reset password you can login. <br>

@component('mail::button', ['url' => $link])
Click Here To Reset Password
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
