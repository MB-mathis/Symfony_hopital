# 🏥 ARCHITECTURE GLOBALE — HOPITAL_SYMFONY

## 🎯 OBJECTIF DU PROJET

Hopital_Symfony est une application hospitalière permettant la gestion sécurisée des patients, consultations, dossiers médicaux et greffes.

Le système doit garantir :
- confidentialité des données médicales (RGPD)
- contrôle strict des accès utilisateurs
- traçabilité des actions
- cohérence entre Web (Symfony) et Mobile (Flutter)

---

# 🚨 RÈGLE FONDAMENTALE DU PROJET

## ⚠️ AVANT TOUTE ACTION (CODE, MODIFICATION, AJOUT)

LE DÉVELOPPEUR / IA DOIT OBLIGATOIREMENT :

### 🔍 1. ANALYSER L’EXISTANT
Toujours vérifier avant de créer quoi que ce soit :
- Entités existantes
- Repositories existants
- Services existants
- Voters existants
- Controllers existants
- API Platform Resources existantes
- Logique métier déjà implémentée

---

### 🧠 2. PRIORITÉ ABSOLUE : RÉUTILISATION

Avant de créer du nouveau code :
1. Utiliser le code existant
2. Utiliser les services métier existants
3. Utiliser les repositories existants
4. Utiliser les Voters existants
5. En dernier recours seulement : créer du nouveau code

---

### ❌ 3. INTERDICTIONS STRICTES

- Ne jamais dupliquer une logique métier existante
- Ne jamais créer un service si un service existant peut faire le travail
- Ne jamais contourner les Voters de sécurité
- Ne jamais exposer des données non filtrées via API
- Ne jamais créer un Controller si API Platform suffit

---

# 🏗️ ARCHITECTURE TECHNIQUE

## Backend (Symfony)

- Symfony 6+
- Doctrine ORM
- API Platform
- LexikJWTAuthenticationBundle (authentification)
- Architecture MVC + Services métier

### Couches applicatives :
- Entity → modèle de données
- Repository → requêtes base de données
- Service → logique métier
- Voter → sécurité et permissions
- Controller → endpoints web spécifiques (Twig / cas particuliers)
- API Platform → exposition REST mobile/web

---

## Frontend Web

- Symfony Twig
- Bootstrap / Bulma
- Utilisé uniquement pour interface admin / hospitalière

---

## Mobile (Flutter)

- Consomme uniquement l’API Symfony
- Dio HTTP client
- Authentification JWT
- Aucune logique métier critique côté mobile

---

# 🏥 RÈGLES MÉTIER HOSPITALIÈRES

## 👤 Accès aux patients

Un utilisateur peut accéder à un patient uniquement si :

- il est le créateur du patient (`createdBy`)
OU
- il est présent dans `PatientUserShare`

---

## 🧩 CENTRALISATION DE LA LOGIQUE

Cette règle est centralisée dans :

- `PatientShareService::canAccess()`
- `PatientVoter`

---

## 📡 LISTE DES PATIENTS

La liste des patients doit TOUJOURS être filtrée côté backend.

Jamais de filtrage côté Flutter.

---

## 🔐 SÉCURITÉ

- Authentification obligatoire via JWT
- Autorisation via Voters Symfony
- Filtrage des données côté backend uniquement
- Aucun accès direct aux données sensibles sans vérification

---

# 📱 API (CONTRAT MOBILE)

- Endpoint principal : `/api/patients`
- Retourne uniquement les patients autorisés
- Ne doit jamais retourner l’intégralité de la base

---

# 🧠 RÈGLES DE DÉVELOPPEMENT

## ✔ BONNES PRATIQUES

- DRY (Don't Repeat Yourself)
- SOLID principles
- Separation of concerns
- Centralisation de la logique métier dans les services
- Sécurité par défaut (secure by design)

---

## 🧠 RÉFLEXE OBLIGATOIRE AVANT CODAGE

Avant toute modification :

1. Comprendre le besoin métier
2. Vérifier si une solution existe déjà
3. Vérifier Repository / Service / Voter existants
4. Éviter toute duplication
5. Respecter Symfony + API Platform natifs

---

# 🚀 OBJECTIF ARCHITECTURAL FINAL

Le système doit être :

- 🔐 sécurisé (données médicales protégées)
- 🧩 cohérent (logique centralisée)
- 🔁 réutilisable (pas de duplication)
- 📱 compatible mobile (Flutter API-first)
- 🏥 scalable (évolution SaaS hospitalier)

---

# ⚠️ RÈGLE POUR IA / COPILOT

Avant de proposer du code :

👉 TOUJOURS analyser l’existant  
👉 TOUJOURS privilégier la réutilisation  
👉 JAMAIS inventer une nouvelle architecture inutile  
👉 JAMAIS contourner les règles métier existantes