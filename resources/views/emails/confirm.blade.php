@component('mail::message')
Please take a moment to verify yourself!

@component('mail::button', ['url' => route('verify', $user->verification_token)])
Verify
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
