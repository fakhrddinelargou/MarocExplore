@component('mail::message')
# Hello!

Click on the button below to change your password.

@component('mail::button', ['url' => $url])
Change Your Password
@endcomponent

@component('mail::panel')
This link is going to expire after 15 mins!
@endcomponent

Thank You,<br>

@endcomponent