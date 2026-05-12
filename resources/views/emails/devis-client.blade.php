
@component('mail::message')
# ✅ Votre demande de devis a été reçue

Bonjour **{{ $devis->name }}**,

Nous avons bien reçu votre demande de devis. Notre équipe l'étudiera dans les plus brefs délais et vous contactera pour vous présenter une offre personnalisée.

---

## 📋 Récapitulatif de votre demande

**Coordonnées :**
- Email : {{ $devis->email }}
- Téléphone : {{ $devis->phone }}

**Projet :**
- Type de propriété : {{ $devis->property_type ?? '—' }}
- Adresse : {{ $devis->address ?? '—' }}
- Surface : {{ $devis->surface ?? '—' }}
- Budget : {{ $devis->budget ?? '—' }}

**Prestations demandées :**
- Sécurité électronique : {{ $devis->security_electronic ? 'Oui' : 'Non' }}
- Maison intelligente : {{ $devis->smart_home ? 'Oui' : 'Non' }}
- Installation solaire : {{ $devis->solar_installation ? 'Oui' : 'Non' }}
- Finitions premium : {{ $devis->premium_finishes ? 'Oui' : 'Non' }}
- Projet complet : {{ $devis->complete_project ? 'Oui' : 'Non' }}

---

Pour toute question, n'hésitez pas à nous contacter.

Merci pour votre confiance,<br>
{{ config('app.name') }}
@endcomponent
