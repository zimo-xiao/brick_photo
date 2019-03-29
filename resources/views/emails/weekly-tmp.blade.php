@component('mail::message')
# $email['title']
***
<br>
@foreach ($email['images'] as $image)
![](data:image/png;base64,{{$image['base64']}})
@component('mail::panel')
{{$image['description']}}
@endcomponent
<br>
***
@endforeach
@component('mail::button', ['url' => $email['url']])
点击进入红砖
@endcomponent
感谢,<br>
红砖图库
@endcomponent