@component('mail::message')

{{$content['description']}}

Thanks,<br>
{{$content['name']}}, <br>
{{$content['phone']}}, <br>
{{$content['email']}}
@endcomponent
