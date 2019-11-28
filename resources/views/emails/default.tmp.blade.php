<style>
    body {
        --color: {{$intl['siteColor']}};
    }
</style>
@component('mail::message')
# {{$intl['default']['title']}}
***
<br>
{{$intl['default']['hello']}} **{{$email['name']}}**，
@component('mail::panel')
{{$email['description']}}
@endcomponent
@component('mail::button', ['url' => $email['url']])
{{$intl['default']['btn']}}
@endcomponent
{{$intl['default']['thanks']}},<br>
{{$intl['siteName']}}
@endcomponentt