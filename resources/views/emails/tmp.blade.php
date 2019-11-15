@component('mail::message')
# 来自红砖图库的一封信
***
<br>
你好 **{{$email['name']}}**，
@component('mail::panel')
{{$email['description']}}
@endcomponent
@component('mail::button', ['url' => $email['url']])
点击进入红砖
@endcomponent
感谢,<br>
红砖图库
@endcomponentt