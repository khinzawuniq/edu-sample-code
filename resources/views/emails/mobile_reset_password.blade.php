@component('mail::message')
# Dear {{$content->name}},

Your verification code is "{{$content->verify_code}}".

Thanks,<br>
{{ config('app.name') }}
@endcomponent
