
@component('mail::message')
# 📩 Nouvelle demande de devis

Vous avez reçu une nouvelle demande de devis.  
Voici tous les détails envoyés par le client.

---

## 🟦 Étape 1 — Informations générales
- **Type de service :** {{ $quote->service_type }}
- **Type de résidence :** {{ $quote->residence_type }}
- **Date estimée :** {{ $quote->estimated_date }}

---

## 🟩 Étape 2 — Types de prestations choisies
- Sécurité électronique : **{{ $quote->security_electronic ? 'Oui' : 'Non' }}**
- Maison intelligente : **{{ $quote->smart_home ? 'Oui' : 'Non' }}**
- Installation solaire : **{{ $quote->solar_installation ? 'Oui' : 'Non' }}**
- Finitions premium : **{{ $quote->premium_finishes ? 'Oui' : 'Non' }}**
- Projet complet : **{{ $quote->complete_project ? 'Oui' : 'Non' }}**

---

## 🟧 Étape 2 — Détails du lieu d’intervention
- **Type de propriété :** {{ $quote->property_type }}
- **Adresse :** {{ $quote->address }}
- **Surface :** {{ $quote->surface }}
- **Nombre d'étages :** {{ $quote->floors }}
- **État actuel :** {{ $quote->current_state }}
- **Besoins spécifiques :** {{ $quote->project_needs ?? '---' }}
- **Budget :** {{ $quote->budget }}
- **Date d'intervention souhaitée :** {{ $quote->intervention_date ?? '---' }}

---

## 🟨 Étape 3 — Informations personnelles
- **Nom :** {{ $quote->name }}
- **Téléphone :** {{ $quote->phone }}
- **Email :** {{ $quote->email }}

---

<!-- ## 🟪 🗂️ Fichiers envoyés
@if ($quote->files && count($quote->files) > 0)
@foreach ($quote->files as $file)
- [Télécharger fichier]({{ asset('storage/' . $file) }})
@endforeach
@else
*Aucun fichier joint.*
@endif -->

---

@component('mail::button', ['url' => config('app.url') . '/admin'])
Voir dans l’administration
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
