@component('mail::message')
Hello {{ $user->name }}!<br>
Verify yourself!

@component('mail::button', ['url' => route('verify', $user->verification_token)])
Verify!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
