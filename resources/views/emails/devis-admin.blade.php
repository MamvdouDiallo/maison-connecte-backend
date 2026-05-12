
@component('mail::message')
# 📋 Nouvelle demande de devis

Vous avez reçu une nouvelle demande de devis depuis le site.

---

## 👤 Informations client

- **Nom :** {{ $devis->name }}
- **Email :** {{ $devis->email }}
- **Téléphone :** {{ $devis->phone }}

---

## 🏠 Détails du projet

- **Type de propriété :** {{ $devis->property_type ?? '—' }}
- **Adresse :** {{ $devis->address ?? '—' }}
- **Surface :** {{ $devis->surface ?? '—' }}
- **Nombre d'étages :** {{ $devis->floors ?? '—' }}
- **État actuel :** {{ $devis->current_state ?? '—' }}
- **Budget :** {{ $devis->budget ?? '—' }}
- **Date d'intervention souhaitée :** {{ $devis->intervention_date ? $devis->intervention_date->format('d/m/Y') : '—' }}

---

## ✅ Prestations souhaitées

- Sécurité électronique : **{{ $devis->security_electronic ? 'Oui' : 'Non' }}**
- Maison intelligente : **{{ $devis->smart_home ? 'Oui' : 'Non' }}**
- Installation solaire : **{{ $devis->solar_installation ? 'Oui' : 'Non' }}**
- Finitions premium : **{{ $devis->premium_finishes ? 'Oui' : 'Non' }}**
- Projet complet : **{{ $devis->complete_project ? 'Oui' : 'Non' }}**

@if ($devis->project_needs)
---

**Besoins spécifiques :** {{ $devis->project_needs }}
@endif

---

@component('mail::button', ['url' => config('app.url') . '/admin'])
Voir dans l'administration
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
