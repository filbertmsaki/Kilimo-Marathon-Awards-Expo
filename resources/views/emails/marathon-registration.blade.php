@component('mail::message')
# Thanks for registering to Kilimo Marathon, Awards & EXPO

Dear {{$email}},

We look forward to communicating more with you. For more information visit our Website.

@component('mail::button', ['url' => 'http://kilimomarathon.co.tz/'])
Kilimo Marathon, Awards & EXPO
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent