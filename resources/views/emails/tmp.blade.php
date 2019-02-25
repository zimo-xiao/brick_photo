@component('mail::message')
# {{$email['title']}}

{{$email['description']}}

@component('mail::button', ['url' => $email['url']])
点击进入红砖
@endcomponent

Thanks,<br>
红砖图库
@endcomponent