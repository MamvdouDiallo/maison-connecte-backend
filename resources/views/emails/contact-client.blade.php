
@component('mail::message')
# ✅ Votre message a bien été reçu

Bonjour **{{ $contact->name }}**,

Nous avons bien reçu votre message et nous vous répondrons dans les plus brefs délais.

---

**Votre message :**
{{ $contact->message }}

---

Merci pour votre confiance,<br>
{{ config('app.name') }}
@endcomponent
