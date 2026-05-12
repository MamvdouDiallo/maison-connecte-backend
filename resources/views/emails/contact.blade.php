
@component('mail::message')
# Nouveau message de {{ $name }}

**Email**: {{ $email }}

**Message**:  
{{ $messageContent }}

@component('mail::button', ['url' => 'mailto:'.$email])
Répondre à {{ $name }}
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
