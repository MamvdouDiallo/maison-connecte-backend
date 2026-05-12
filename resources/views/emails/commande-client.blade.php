
@component('mail::message')
# ✅ Votre commande est bien enregistrée

Bonjour **{{ $commande->name }}**,

Nous avons bien reçu votre commande. Notre équipe vous contactera très prochainement pour confirmer les détails et organiser la livraison.

---

## 📦 Récapitulatif de votre commande

@component('mail::table')
| Article | Prix unitaire | Qté | Sous-total |
|:--------|:-------------|:---:|:----------:|
@foreach ($commande->items as $item)
| {{ $item->title }} | {{ $item->price }} | {{ $item->quantity }} | {{ $item->line_total }} |
@endforeach
@endcomponent

**Total : {{ $commande->total }}**

---

@if ($commande->message)
**Votre message :** {{ $commande->message }}

---
@endif

Pour toute question, n'hésitez pas à nous contacter.

Merci pour votre confiance,<br>
{{ config('app.name') }}
@endcomponent
