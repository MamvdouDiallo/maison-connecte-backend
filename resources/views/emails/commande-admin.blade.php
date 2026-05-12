
@component('mail::message')
# 🛒 Nouvelle commande reçue

Vous avez reçu une nouvelle commande panier.

---

## 👤 Informations client

- **Nom :** {{ $commande->name }}
- **Email :** {{ $commande->email }}
- **Téléphone :** {{ $commande->phone }}
@if ($commande->message)
- **Message :** {{ $commande->message }}
@endif

---

## 📦 Articles commandés

@component('mail::table')
| Article | Prix unitaire | Qté | Sous-total |
|:--------|:-------------|:---:|:----------:|
@foreach ($commande->items as $item)
| {{ $item->title }} | {{ $item->price }} | {{ $item->quantity }} | {{ $item->line_total }} |
@endforeach
@endcomponent

**Total : {{ $commande->total }}**

---

@component('mail::button', ['url' => config('app.url') . '/admin'])
Voir dans l'administration
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
