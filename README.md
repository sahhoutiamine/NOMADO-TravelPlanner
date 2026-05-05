# 📋 CAHIER DES CHARGES - NOMADO

## Planificateur de Voyage Intelligent

**Version:** 1.0
**Date:** Mai 2026
**Statut:** En production (Phase 1 complétée)

---

## 1. PRÉSENTATION DU PROJET

### 1.1 Vision Générale

**NOMADO** est une plateforme tout-en-un conçue pour automatiser et simplifier la création, la personnalisation, la budgétisation et le partage de voyages de groupe. La plateforme transforme l'expérience de planification de voyage en offrant une solution intelligente qui génère des itinéraires personnalisés en fonction du budget, des préférences de voyage et du nombre de participants.

### 1.2 Proposition de Valeur

NOMADO répond à plusieurs enjeux critiques :

- **Automatisation de la planification :** Génération instantanée d'itinéraires (filtres intelligents)
- **Gestion budgétaire centralisée :** Budget fixe redistribué dynamiquement selon les choix des utilisateurs
- **Collaboration simplifiée :** Partage de voyages via codes shareable avec gestion des co-voyageurs
- **Paiement sécurisé :** Système de paiement intégré avec état de confirmation et génération de tickets
- **Personnalisation avancée :** Sélection d'hôtels, lieux d'intérêt, activités custom, et planification des vols

### 1.3 Objectifs Stratégiques

- Réduire le temps de planification d'un voyage en groupe de **plusieurs heures à quelques minutes**
- Offrir une **visibilité budgétaire complète** aux voyageurs
- Faciliter la **collaboration entre co-voyageurs** sans complexité administrative
- Générer des **itinéraires optimisés** adaptés à chaque type de voyage
- Fournir une **expérience mobile-first** et responsive

---

## 2. CONTEXTE ET PROBLÉMATIQUE

### 2.1 Défis Identifiés

#### 2.1.1 Complexité de l'Organisation de Groupe

- **Problème :** Coordonner un voyage pour plusieurs personnes implique des mails infinis, des conflits de calendrier, et une fragmentation des informations.
- **Impact :** 40-50% des tentatives de voyage en groupe échouent faute d'organisation.

#### 2.1.2 Gestion Budgétaire Fragmentée

- **Problème :** Les outils existants (Google Sheets, calculatrices) ne permettent pas une redistribution budgétaire fluide et automatique.
- **Impact :** Surcoûts imprévus, disputes financières, excédent budgétaire non optimisé.

#### 2.1.3 Absence de Point Centralisé de Réservation

- **Problème :** Hôtel via Booking, Vols via Skyscanner, Activités via Airbnb Experiences = fragments éparpillés.
- **Impact :** Perte de contrôle, risque d'overbooking, absence de suivi consolidé.

#### 2.1.4 Paramètres de Voyage Non Standardisés

- **Problème :** Différents préférences de type de voyage (aventure, culture, plage, romantique, nature, shopping) mal agrégées.
- **Impact :** Recommandations non pertinentes, frustration utilisateur.

### 2.2 Opportunités

- **Marché croissant :** 35% d'augmentation annuelle des voyages en groupe (données 2024-2026)
- **Demande de simplification :** 78% des utilisateurs cherchent une plateforme « all-in-one »
- **Potentiel de monétisation :** Commissions sur réservations, partenariats hôteliers, Premium features

---

## 3. ACTEURS DU SYSTÈME

### 3.1 Visiteur (Utilisateur Non Authentifié)

**Rôle :** Accès en lecture seule à la plateforme

**Permissions :**

- ✓ Consulter la page d'accueil (Welcome page)
- ✓ Consulter le catalogue de destinations (pays, villes, hôtels, lieux d'intérêt)
- ✓ Voir les détails des hôtels et lieux d'intérêt
- ✗ Créer une réservation
- ✗ Accéder aux pages protégées (dashboard, my-bookings)

**Pages Accessibles :**

- `/` (Accueil)
- `/hotels/{id}` (Détail hôtel - lecture seule)
- `/places/{id}` (Détail lieu - lecture seule)

---

### 3.2 Utilisateur / Voyageur (Rôle : user)

**Rôle :** Acteur principal de la plateforme

**Permissions :**

- ✓ Authentification et gestion de profil
- ✓ Générer des itinéraires
- ✓ Créer des réservations (bookings)
- ✓ Personnaliser son voyage (sélection hôtels, places, activités)
- ✓ Payer une réservation
- ✓ Générer et partager des codes d'accès
- ✓ Ajouter des co-voyageurs (participants)
- ✓ Générer un plan détaillé (itinéraire + timeline)
- ✓ Ajouter des activités personnalisées
- ✓ Imprimer un ticket (boarding pass)
- ✗ Accéder à l'administration

**Statuts de Réservation :**

- `pending` : Réservation créée, non payée (modifiable)
- `paid` : Réservation payée, immutable (shareable)

**Limites :**

- Une réservation ne peut être partagée que si :
    - Statut = `paid`
    - `passengers > 1`

---

### 3.3 Administrateur Système (Rôle : admin)

**Rôle :** Gestion complète de la plateforme et des utilisateurs

**Permissions :**

- ✓ Accès au dashboard d'administration
- ✓ Gestion des utilisateurs (CRUD, bannissement)
- ✓ Visualisation de tous les voyages (index)
- ✓ Gestion du catalogue (pays, villes, hôtels, lieux)
- ✓ Activer/désactiver des utilisateurs
- ✓ Édition de contenu (hôtels, lieux, etc.)

**Pages Accessibles :**

- `/admin/dashboard` (Dashboard)
- `/admin/users` (Gestion utilisateurs)
- `/admin/countries` (CRUD Pays)
- `/admin/cities` (CRUD Villes)
- `/admin/hotels` (CRUD Hôtels)
- `/admin/places` (CRUD Lieux d'intérêt)
- `/admin/bookings` (Vue tous les voyages)

---

### 3.4 Administrateur Contenu (Rôle : travlerAdmin)

**Rôle :** Gestion du catalogue de destinations et d'hébergements

**Permissions :**

- ✓ Accès au dashboard d'administration (limité)
- ✓ Gestion du catalogue complet (pays, villes, hôtels, lieux)
- ✓ Création et édition de destinations
- ✓ Visualisation des voyages (index uniquement)
- ✗ Gestion des utilisateurs
- ✗ Bannissement/débannement

**Pages Accessibles :**

- `/admin/dashboard` (Dashboard)
- `/admin/countries` (CRUD Pays)
- `/admin/cities` (CRUD Villes)
- `/admin/hotels` (CRUD Hôtels)
- `/admin/places` (CRUD Lieux d'intérêt)
- `/admin/bookings` (Lecture seule)

**Attributs du TravlerAdmin :**

- Peut éditer/créer des lieux dans des pays/villes spécifiques
- Responsable de la qualité du contenu

---

## 4. FONCTIONNALITÉS PAR ACTEUR

### 4.1 Fonctionnalités - Visiteur

#### 4.1.1 Consultation du Catalogue

- **Cas d'usage :** L'utilisateur explore les destinations disponibles
- **Flux :**
    1. Affichage de la page d'accueil avec présentation générale
    2. Lien vers catalogue de destinations (pays, villes)
    3. Affichage des hôtels et lieux d'intérêt par ville
    4. Détails complets d'un hôtel ou lieu
- **Données affichées :**
    - Hôtels : nom, prix/nuit, description, image, type
    - Lieux : nom, description, image, localisation, prix_min
    - Pays : nom, type_voyage, description, image
    - Villes : nom, pays, type_voyage, description

---

### 4.2 Fonctionnalités - Utilisateur

#### 4.2.1 Authentification et Profil

- **Inscription :** Email, mot de passe, nom
- **Connexion :** Email + mot de passe
- **Profil :** Édition de nom, email, mot de passe
- **Routes:**
    - `GET/POST /register` - Inscription
    - `GET/POST /login` - Connexion
    - `GET /profile` - Édition profil
    - `PATCH /profile` - Mise à jour
    - `DELETE /profile` - Suppression compte

#### 4.2.2 Génération d'Itinéraire (Trip Generator)

- **Cas d'usage :** L'utilisateur décrit ses préférences et obtient des propositions d'itinéraires
- **Route :** `GET/POST /generate`
- **Contrôleur :** `TripGeneratorController@index` / `generate`
- **Flux :**
    1. Affichage du formulaire de génération
    2. Saisie des critères:
        - **Type de voyage** (required) : adventure, culture, beach, romantic, nature, shopping
        - **Budget total** (required) : montant en EUR, min 100
        - **Durée** (required) : nombre de jours, min 1
        - **Nombre de passagers** (required) : min 1
        - **Ville de départ** (required) : sélection dans la liste
        - **Date de départ** (required) : date >= demain (validation côté serveur)
    3. Validation côté serveur et client
    4. Recherche des villes correspondant au type de voyage (excluant la ville de départ)
    5. Recherche des hôtels compatibles avec le budget
    6. Génération de 3 propositions d'itinéraires avec :
        - Hôtel sélectionné
        - Détails de la ville
        - Répartition budgétaire initiale:
            - `hotel_budget = price_per_night × duration × passengers`
            - `remaining = budget_total - hotel_budget`
            - `flight_budget = 0` (calculé lors du paiement)
            - `activities_budget = remaining × 0.7`
            - `misc_budget = remaining × 0.3`
        - Liste des lieux d'intérêt de la ville (triée par min_price ASC)
    7. Affichage de la page de résultats avec critères

- **Logique d'Algorithme :**

    ```
    1. Chercher villes avec trip_type = user_trip_type AND id != departure_city
    2. Pour chaque ville, chercher hôtels WHERE price_per_night <= (budget × 0.7 / duration / passengers)
    3. Si aucun hôtel trouvé, fallback: price_per_night <= (budget / duration / passengers)
    4. Limiter à 3 hôtels (random order)
    5. Si toujours vide, retourner erreur "Aucun voyage trouvé"
    6. Pour chaque hôtel, calculer les budgets et ajouter les lieux de la ville
    ```

- **Validation :**
    - Budget >= 100
    - Duration >= 1
    - Passengers >= 1
    - Departure date >= tomorrow
    - Trip type dans whitelist
    - City exists et est différente de departure_city

**Page :** `resources/views/trip/index.blade.php` (formulaire)
**Page :** `resources/views/results.blade.php` (résultats)

---

#### 4.2.3 Customisation des Résultats (Avant Confirmation)

- **Cas d'usage :** L'utilisateur affine son choix avant de confirmer
- **Page :** `resources/views/results.blade.php`
- **Fonctionnalités :**
    - **Toggle Hôtel :** Switch ON/OFF pour inclure l'hôtel dans le budget
        - Si OFF : `hotel_budget = 0`, `remaining = budget_total`
        - Si ON : `hotel_budget = price_per_night × duration × passengers`
    - **Sélection Hôtel :** Liste scrollable des hôtels de la ville
        - Affichage: nom, prix/nuit, type, description
        - Toggle pour sélectionner/désélectionner
    - **Sélection Lieux d'Intérêt :** Checkboxes avec descriptions
        - Affichage: nom, description, prix_min
        - Sélection multiple
        - Calcul dynamique: `places_budget = sum(min_price × passengers) for selected places`
    - **Budget Recalculation :**
        - `hotel_cost = (price × duration × passengers) if include_hotel else 0`
        - `places_cost = sum(min_price × passengers) for selected places`
        - `remaining = budget_total - hotel_cost - places_cost`
        - `flight_budget = remaining × 0.3`
        - `activities_budget = (remaining × 0.5) - places_cost` (ou `remaining × 0.7-0.5 de remaining`)
        - `misc_budget = remaining × 0.2`
    - **Visual Budget Bars :** 3 barres de progression
        - Accommodation: hotel_budget / budget_total (couleur amber)
        - Experiences: activities_budget / budget_total (couleur emerald)
        - Miscellaneous: misc_budget / budget_total (couleur slate)
        - ~~Flights: flight_budget / budget_total~~ (REMOVED)
    - **Warning Box :** Alert si places_cost > activities_budget
    - **Animations :** Números animados lors de recalculations
    - **Bouton Confirmation :** "Confirm This Trip" → POST `/trip/confirm`

---

#### 4.2.4 Confirmation et Création de Réservation

- **Cas d'usage :** L'utilisateur confirme ses choix et crée une booking
- **Route :** `POST /trip/confirm`
- **Contrôleur :** `TripGeneratorController@confirm`
- **Flux :**
    1. Validation des données du formulaire
    2. Création d'une nouvelle `Booking`:
        - `user_id` = authenticated user
        - `city_id` = destination city
        - `trip_type` = selected type
        - `budget_total`, `duration`, `passengers` = form data
        - `departure_city_id` = departure city
        - `departure_date` = selected date
        - `flight_budget`, `hotel_budget`, `activities_budget`, `misc_budget` = calculated
        - `status` = 'pending'
        - `selected_place_ids` = comma-separated place IDs
        - `include_hotel` = boolean toggle
    3. Attachement du propriétaire via pivot `booking_user` avec `isOwner = true`
    4. Attachement de l'hôtel via pivot `booking_hotel` avec dates:
        - `check_in_date` = departure_date + 1 day
        - `check_out_date` = check_in_date + duration days
    5. Sync des lieux sélectionnés via pivot `booking_place`
    6. Redirection vers `bookings.show` avec message "Voyage enregistré avec succès !"

- **Données Persistées :**
    - Table `bookings` : Infos principales
    - Table `booking_user` : Propriétaire + co-voyageurs
    - Table `booking_hotel` : Relation N:N avec dates de séjour
    - Table `booking_place` : Relation N:N avec lieux sélectionnés

---

#### 4.2.5 Gestion des Réservations (My Bookings)

- **Cas d'usage :** L'utilisateur visualise, gère et partage ses voyages
- **Route :** `GET /my-bookings`
- **Contrôleur :** `MyBookingsController@index`
- **Fonctionnalités :**
    - Affichage de toutes les réservations créées par l'utilisateur
    - Affichage de toutes les réservations partagées où l'utilisateur participe
    - Champ `participants()` via pivot `booking_user`
    - Tri par date récente (latest)
    - Affichage : ville, statut, date départ, participants count, date création
    - Bouton d'accès au détail / Bouton "Rejoindre" (si possédant share_code)

**Page :** `resources/views/bookings/index.blade.php`

---

#### 4.2.6 Détail d'une Réservation et Sélection des Vols

- **Cas d'usage :** L'utilisateur visualise tous les détails de son voyage et sélectionne un vol
- **Route :** `GET /my-bookings/{id}`
- **Contrôleur :** `MyBookingsController@show`
- **Sécurité :** Seul le propriétaire ou les participants peuvent accéder
- **Données Affichées :**
    - Résumé de la réservation (destination, durée, budget, type)
    - Hôtel sélectionné avec détails (adresse, prix/nuit, description)
    - Lieux sélectionnés avec descriptions
    - **Section Vols :** Proposition de 5 compagnies aériennes avec:
        - Compagnie (Emirates, Qatar Airways, Lufthansa, Air France, British Airways)
        - Ville départ → destination
        - Durée du vol (calculée via Haversine + cardinals de pays)
        - Classes disponibles (Economy, Business, First Class)
        - Prix par classe (base_price × multiplier)
        - Formule: `base_price = 100 + (duration_minutes × 0.85) × (1 + (index × 0.05))`
        - Selection: l'utilisateur peut choisir une compagnie et une classe
    - **Bouton "Personnaliser Plans"** → redirect `/my-bookings/{id}/plan`
    - **Bouton "Payer"** → redirect `/my-bookings/{id}/payment`
    - **Bouton "Plan du Voyage"** → link `/my-bookings/{id}/plan`
    - **Bouton "Ticket"** (if paid) → link `/my-bookings/{id}/ticket`

- **Calcul Haversine :**
    - Récupérer cardinals (lat, lng) de departure_country et destination_country
    - Distance = R × arccos(sin(lat1)×sin(lat2) + cos(lat1)×cos(lat2)×cos(lng2-lng1))
    - Flight duration = (distance / 900) + 0.5 hours (pour takeoff/landing)
    - Format: "Xh Ym"

- **Information Affichée :** Lieux, hôtel, flight duration, prix vols

**Page :** `resources/views/bookings/show.blade.php`

---

#### 4.2.7 Mise à Jour Dynamique des Sélections (AJAX)

- **Cas d'usage :** Lors de la personnalisation, recalcul dynamique du budget sans rechargement
- **Route :** `PUT /my-bookings/{id}`
- **Contrôleur :** `MyBookingsController@update`
- **Conditions :**
    - Editable uniquement si `status == 'pending'`
    - Retour 403 si `status != 'pending'`
- **Données Acceptées :**
    - `selected_hotels` (JSON): `[{id, check_in, check_out}, ...]`
    - `include_hotel` (boolean)
    - `selected_place_ids` (string comma-separated)
    - `place_dates` (JSON): place_id => visit_date
    - `airline`, `flight_duration`, `flight_class`, `flight_budget` (optionnels)
    - `budget_total` (optionnel, augmentable seulement)
- **Logique :**
    1. Validation des données
    2. Recalcul des coûts:
        - Hôtel: `price_per_night × max(1, nights) × passengers`
        - Vol: `flight_budget × passengers`
        - Lieux: `sum(min_price × passengers)`
        - Activités custom: somme existante
    3. Redistribution budgétaire:
        - `remaining = budget_total - hotel - flight - places - custom_activities`
        - `misc_budget = remaining × 0.20`
        - `activities_budget = (remaining × 0.80) + custom_activities_cost`
    4. Mise à jour de la booking
    5. Sync des hôtels/lieux/dates
    6. Retour JSON avec budgets recalculés

- **Réponse JSON :**
    ```json
    {
        "success": true,
        "hotel_cost": 1200,
        "places_cost": 500,
        "flight_budget": 300,
        "activities_budget": 1500,
        "misc_budget": 150
    }
    ```

---

#### 4.2.8 Suppression d'une Réservation

- **Cas d'usage :** L'utilisateur supprime un voyage en attente
- **Route :** `DELETE /my-bookings/{id}`
- **Contrôleur :** `MyBookingsController@destroy`
- **Conditions :**
    - Seul le propriétaire peut supprimer
    - Supprimable uniquement si `status == 'pending'`
    - Les voyages payés ne peuvent pas être supprimés
- **Cascade :** Suppression de tous les enregistrements associés (via foreign keys)
- **Redirection :** Vers `/my-bookings` avec message "Voyage supprimé"

---

#### 4.2.9 Gestion des Co-voyageurs et Partage

##### 4.2.9.1 Génération de Code Partageable

- **Cas d'usage :** Le propriétaire génère un code pour inviter des co-voyageurs
- **Route :** `POST /my-bookings/{id}/share-code`
- **Contrôleur :** `MyBookingsController@shareCode`
- **Conditions :**
    - `status == 'paid'` (obligation de paiement)
    - `passengers > 1` (voyage multi-personne)
- **Logique :**
    1. Génération d'un code 6 caractères (format: uppercase alphanumeric)
    2. Vérification d'unicité en base
    3. Stockage dans `booking.share_code`
    4. Retour JSON avec le code
- **Réponse :**
    ```json
    {
        "success": true,
        "code": "ABC123"
    }
    ```

##### 4.2.9.2 Rejoindre un Voyage via Code

- **Cas d'usage :** Un co-voyageur rejoint le voyage avec le code fourni
- **Route :** `POST /my-bookings/join`
- **Contrôleur :** `MyBookingsController@join`
- **Flux :**
    1. Validation: code doit être 6 caractères
    2. Recherche du voyage via `share_code`
    3. Vérifications:
        - Booking existe?
        - Statut = 'paid'?
        - L'utilisateur n'est pas le propriétaire?
        - L'utilisateur n'est pas déjà participant?
    4. Attachement de l'utilisateur via pivot `booking_user` avec `isOwner = false`
    5. Redirection avec message "Vous avez rejoint le voyage !"
- **Gestion d'erreurs :**
    - "Invalid share code."
    - "This trip cannot be joined yet as it is not fully confirmed (payment pending)."
    - "You are already the owner of this trip."
    - "You have already joined this trip."

---

#### 4.2.10 Système de Paiement

##### 4.2.10.1 Page de Paiement

- **Cas d'usage :** L'utilisateur effectue le paiement pour confirmer le voyage
- **Route :** `GET /my-bookings/{id}/payment`
- **Contrôleur :** `PaymentController@show`
- **Flux :**
    1. Affichage d'un formulaire multi-étapes (3 steps):
        - Step 1 : Détails du Voyage (destination, durée, passagers, budget)
        - Step 2 : Vol (sélection compagnie, classe, prix)
        - Step 3 : Hôtel (confirmation, dates, prix)
    2. Chaque step est un "glass card" avec gradient
    3. Indicateur d'étape animé
    4. Pas de rechargement entre steps
    5. À la fin, affichage du prix total et bouton "Confirmer le Paiement"
    6. Les données de paiement sont cosmétiques (pas de vrai traitement)

- **Champs de Paiement (cosmétiques) :**
    - Titulaire de carte
    - Numéro de carte (validation format XX)
    - Date d'expiration (MM/YY)
    - CVV

**Page :** `resources/views/payment/show.blade.php`

##### 4.2.10.2 Confirmation et Création du Paiement

- **Cas d'usage :** Le paiement est traité et enregistré
- **Route :** `POST /my-bookings/{id}/payment`
- **Contrôleur :** `PaymentController@store`
- **Flux :**
    1. Validation des données (start_date, departure_country, departure_city, etc.)
    2. Création d'un enregistrement `Payment`:
        - `user_id` = authenticated user
        - `booking_id` = booking ID
        - `start_date` = date de saisie
        - `departure_country` = pays saisi
        - `departure_city` = ville saisie
        - `is_flight_paid` = true
        - `is_hotel_paid` = true (\* ou séparé selon implémentation)
    3. Mise à jour du statut de la booking:
        - `status = 'paid'`
    4. Redirection vers `/my-bookings/{id}/ticket` avec message "Paiement confirmé !"

- **Modèle Payment :**
    - id, user_id (FK), booking_id (FK), start_date, departure_country, departure_city, is_flight_paid, is_hotel_paid
    - Relations: belongsTo(User), belongsTo(Booking)

---

##### 4.2.10.3 Ticket / Boarding Pass

- **Cas d'usage :** L'utilisateur visualise et imprime son ticket après paiement
- **Route :** `GET /my-bookings/{id}/ticket`
- **Contrôleur :** `PaymentController@ticket`
- **Affichage :**
    - Format boarding pass (printable)
    - Informations:
        - Numéro de référence (booking ID)
        - Passager (user name)
        - Départ (departure_city → destination)
        - Date (departure_date)
        - Hôtel (si include_hotel)
        - Status badge (PAID / PENDING)
        - QR code simulé (pseudo-ticket)
        - Bouton "Imprimer"

- **CSS Print :** Media queries pour impression propre

**Page :** `resources/views/payment/ticket.blade.php`

---

#### 4.2.11 Plan du Voyage (Itinéraire Détaillé)

##### 4.2.11.1 Visualisation du Plan

- **Cas d'usage :** L'utilisateur visualise son itinéraire complet avec timeline
- **Route :** `GET /my-bookings/{id}/plan`
- **Contrôleur :** `TripPlanController@show`
- **Affichage :**
    1. **Trip Summary Card :**
        - Destination
        - Durée
        - Budget total
        - Nombre de participants
    2. **Timeline Interactive :**
        - **Jour 1 :** Départ (Flight) - Nœud bleu
        - **Jour 2 :** Arrivée et check-in hôtel - Nœud amber
        - **Jours 3 à N-1 :** Visites de 1-2 lieux/jour - Nœuds emerald
        - **Jour libre :** Exploration libre - Nœud slate
        - **Dernier jour :** Départ (Flight) - Nœud bleu
    3. **Détails par Jour :**
        - Lieu (si visité)
        - Temps d'arrivée
        - Durée recommandée
        - Prix
    4. **Bouton "Print / PDF"** pour impression de l'itinéraire complet

- **Logique d'Itinéraire :**

    ```
    Jour 1: Flight arrival
    Jour 2: Hotel check-in (if include_hotel = true)
    Jours 3 à N-1: Assign places (1-2 par jour, sorted by min_price ASC)
    Dernier jour: Return flight
    ```

- **Hôtels N:N :** Si plusieurs hôtels sélectionnés, afficher checkout/check-in par hôtel

**Page :** `resources/views/bookings/plan.blade.php`

##### 4.2.11.2 Ajout d'Activités Personnalisées

- **Cas d'usage :** L'utilisateur ajoute des activités custom au-delà des lieux prédéfinis
- **Route :** `POST /my-bookings/{id}/plan/activity`
- **Contrôleur :** `TripPlanController@storeActivity`
- **Flux :**
    1. Validation: `name`, `budget` (required), `date` (optional)
    2. Création `CustomActivity`:
        - `booking_id` = booking ID
        - `name` = activité name
        - `budget` = montant EUR
        - `date` = date optionnelle
    3. Recalcul du `activities_budget` de la booking
    4. Retour JSON ou redirection avec message "Activité ajoutée !"

- **API Response :**
    ```json
    {
        "success": true,
        "activity": {
            "id": 1,
            "name": "Visite Palais",
            "budget": 50,
            "date": "2026-05-10"
        },
        "total_activities_cost": 250
    }
    ```

##### 4.2.11.3 Suppression d'Activités Personnalisées

- **Cas d'usage :** L'utilisateur supprime une activité custom
- **Route :** `DELETE /my-bookings/{id}/plan/activity/{activityId}`
- **Contrôleur :** `TripPlanController@deleteActivity`
- **Conditions :**
    - Seul le propriétaire peut supprimer
    - L'activité doit appartenir à cette booking
- **Réponse :** JSON `{"success": true, "total_activities_cost": 200}`

---

### 4.3 Fonctionnalités - Admin / TravlerAdmin

#### 4.3.1 Dashboard d'Administration

- **Route :** `GET /admin/dashboard`
- **Contrôleur :** `Admin\DashboardController@index`
- **Affichage (Admin & TravlerAdmin) :**
    - Total de voyages créés
    - Total de revenus (budgets payés)
    - Nombre d'utilisateurs actifs
    - Graphiques (destinations les plus populaires, types de voyage)

---

#### 4.3.2 Gestion des Utilisateurs (Admin Uniquement)

- **Route :** `/admin/users` (CRUD complet)
- **Contrôleur :** `Admin\UserController`
- **Actions :**
    - **INDEX :** Liste tous les utilisateurs avec rôle, statut (banni/actif)
    - **SHOW :** Détail d'un utilisateur + ses réservations
    - **EDIT :** Editer nom, email, rôle
    - **UPDATE :** Mise à jour avant édition
    - **DELETE :** Suppression (cascade: delete all bookings)
    - **TOGGLE-BAN :** Bannir/débannir un utilisateur
- **Route :** `PATCH /admin/users/{user}/toggle-ban` → toggle le statut `is_banned`

---

#### 4.3.3 Gestion du Catalogue (Admin & TravlerAdmin)

##### 4.3.3.1 CRUD - Pays

- **Route :** `/admin/countries` (CRUD complet)
- **Contrôleur :** `Admin\CountryController`
- **Champs :**
    - `name` (string, unique)
    - `trip_type` (enum: adventure, culture, beach, romantic, nature, shopping)
    - `description` (text)
    - `image` (URL/path)
    - **`cardinals`** (string, format: "lat,lng") → pour calculs Haversine
- **Actions :** CREATE, READ, UPDATE, DELETE
- **Validation :** Tous les champs required sauf image

##### 4.3.3.2 CRUD - Villes

- **Route :** `/admin/cities` (CRUD complet)
- **Contrôleur :** `Admin\CityController`
- **Champs :**
    - `country_id` (FK)
    - `name` (string)
    - `trip_type` (enum)
    - `description` (text)
    - `image` (URL/path)
- **Actions :** CREATE, READ, UPDATE, DELETE
- **Validation :** Tous les champs required

##### 4.3.3.3 CRUD - Hôtels

- **Route :** `/admin/hotels` (CRUD complet)
- **Contrôleur :** `Admin\HotelController`
- **Champs :**
    - `city_id` (FK)
    - `name` (string)
    - `price_per_night` (decimal)
    - `description` (text)
    - `image` (URL/path)
    - `type` (string: 3-star, 4-star, 5-star, etc.)
- **Actions :** CREATE, READ, UPDATE, DELETE
- **Validation :** Tous les champs required

##### 4.3.3.4 CRUD - Lieux d'Intérêt

- **Route :** `/admin/places` (CRUD complet)
- **Contrôleur :** `Admin\PlaceController`
- **Champs :**
    - `city_id` (FK)
    - `name` (string)
    - `description` (text)
    - `image` (URL/path)
    - `localisation` (string: "Musée", "Parc", etc.)
    - `min_price` (decimal) → prix d'entrée minimum
- **Actions :** CREATE, READ, UPDATE, DELETE
- **Validation :** Tous les champs required

---

#### 4.3.4 Visualisation des Réservations (Admin & TravlerAdmin)

- **Route :** `GET /admin/bookings`
- **Contrôleur :** `Admin\BookingController@index`
- **Affichage :**
    - Toutes les réservations de tous les utilisateurs
    - Filtres: Statut (pending/paid), Type de voyage, Période
    - Tableau avec colonnes: User, Destination, Durée, Budget, Statut, Participants
    - **TravlerAdmin :** Lecture seule
    - **Admin :** Possibilité de modifier/supprimer

---

## 5. RÈGLES MÉTIER CLÉS (Business Rules)

### 5.1 Règles de Réservation

| Règle      | Description                                                                            | Contexte          |
| ---------- | -------------------------------------------------------------------------------------- | ----------------- |
| **RB-001** | Une réservation ne peut être créée que par un utilisateur authentifié                  | Authentification  |
| **RB-002** | Chaque réservation a exactement UN propriétaire (`isOwner = true` dans `booking_user`) | Propriété         |
| **RB-003** | Un utilisateur peut créer plusieurs réservations                                       | Multi-trips       |
| **RB-004** | Une réservation ne peut être modifiée que si son statut = 'pending'                    | Édition contrôlée |
| **RB-005** | Une réservation ne peut être payée qu'une fois (passage de 'pending' à 'paid')         | Paiement unique   |
| **RB-006** | Une réservation peut être supprimée uniquement si statut = 'pending'                   | Sécurité données  |
| **RB-007** | Une réservation payée ne peut pas être modifiée                                        | Immuabilité       |

### 5.2 Règles de Partage

| Règle      | Description                                                                     | Contexte            |
| ---------- | ------------------------------------------------------------------------------- | ------------------- |
| **RB-008** | Seules les réservations payées (`status = 'paid'`) peuvent être partagées       | Sécurité financière |
| **RB-009** | Un code partageable (6 caractères) est généré une seule fois par réservation    | Unicité             |
| **RB-010** | Seules les réservations avec `passengers > 1` peuvent être partagées            | Logique métier      |
| **RB-011** | Un co-voyageur est attaché avec `isOwner = false` lors de son adhésion via code | Rôle                |
| **RB-012** | Un utilisateur ne peut rejoindre le même voyage qu'une fois                     | Unicité participant |
| **RB-013** | Le propriétaire ne peut pas "rejoindre" son propre voyage                       | Auto-exclusion      |
| **RB-014** | Le code partageable est unique en base de données                               | Contrainte unique   |

### 5.3 Règles Budgétaires

| Règle      | Description                                                                                                | Contexte       |
| ---------- | ---------------------------------------------------------------------------------------------------------- | -------------- |
| **RB-015** | Le budget total (`budget_total`) est fixe et défini lors de la création                                    | Budget rigide  |
| **RB-016** | Les sous-budgets (flight, hotel, activities, misc) se redistribuent dynamiquement                          | Flexibilité    |
| **RB-017** | Budget formula: `hotel = price/night × duration × passengers` (si include_hotel)                           | Calcul         |
| **RB-018** | Budget formula: `activities = (remaining × 0.8) + custom_activities_cost`                                  | Redistribution |
| **RB-019** | Budget formula: `misc = remaining × 0.2`                                                                   | Redistribution |
| **RB-020** | Les lieux sélectionnés réduisent le budget activities (`places_cost = sum(min_price × passengers)` déduit) | Calcul         |
| **RB-021** | Les activités custom augmentent le total dépensé et réduisent misc/activities                              | Inclusion      |
| **RB-022** | Le budget ne peut pas être dépassé (validation côté application)                                           | Sécurité       |

### 5.4 Règles de Voyage

| Règle      | Description                                                                                                               | Contexte       |
| ---------- | ------------------------------------------------------------------------------------------------------------------------- | -------------- |
| **RB-023** | Un voyage doit avoir une destination (`city_id`) différente de la ville de départ                                         | Logique        |
| **RB-024** | Une date de départ doit être >= demain (J+1)                                                                              | Validation     |
| **RB-025** | La durée minimale d'un voyage est 1 jour                                                                                  | Validation     |
| **RB-026** | Le nombre de passagers minimum est 1                                                                                      | Validation     |
| **RB-027** | Le budget minimum est 100 EUR                                                                                             | Validation     |
| **RB-028** | Chaque type de voyage (trip_type) correspond à des villes spécifiques                                                     | Filtrage       |
| **RB-029** | Un hôtel n'est attaché à une réservation que si `include_hotel = true`                                                    | Conditionalité |
| **RB-030** | Les dates de check-in/out sont calculées automatiquement (check_in = departure_date + 1, check_out = check_in + duration) | Auto-calcul    |

### 5.5 Règles d'Accès et Sécurité

| Règle      | Description                                                                             | Contexte         |
| ---------- | --------------------------------------------------------------------------------------- | ---------------- |
| **RB-031** | Un utilisateur ne peut voir que ses propres réservations + celles où il est participant | Sécurité données |
| **RB-032** | Seul l'admin peut voir toutes les réservations de tous les utilisateurs                 | Accès données    |
| **RB-033** | Seul l'admin peut modifier/supprimer les utilisateurs                                   | Gestion système  |
| **RB-034** | TravlerAdmin n'a accès qu'au CRUD du catalogue, pas à la gestion utilisateurs           | Séparation rôles |
| **RB-035** | Les utilisateurs bannis (`is_banned = true`) perdent l'accès à la plateforme            | Contrôle accès   |

### 5.6 Règles de Paiement

| Règle      | Description                                                                        | Contexte        |
| ---------- | ---------------------------------------------------------------------------------- | --------------- |
| **RB-036** | Un paiement ne peut être effectué que par le propriétaire de la réservation        | Propriété       |
| **RB-037** | Après paiement, le statut passe de 'pending' à 'paid'                              | Transition état |
| **RB-038** | Un paiement crée un enregistrement `Payment` lié à la réservation et l'utilisateur | Traçabilité     |
| **RB-039** | Les données de paiement (carte) ne sont pas stockées (simulation)                  | Sécurité        |

---

## 6. PROCESSUS PRINCIPAL (WORKFLOW)

### 6.1 Lifecycle de Voyage - Vue Macroscopique

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    NOMADO - VOYAGE LIFECYCLE                            │
└─────────────────────────────────────────────────────────────────────────┘

1. DISCOVERY
   ├─ Visiteur explore catalogue
   └─ Utilisateur authentifié démarre génération

2. GENERATION & CUSTOMIZATION
   ├─ Submit préférences (type, budget, durée, date, départ)
   ├─ Système génère 3 propositions d'itinéraires
   ├─ Utilisateur customise (toggle hôtel, sélection lieux, recalcul budget)
   └─ Confirmation de choix

3. BOOKING CREATION
   ├─ Enregistrement réservation (status = 'pending')
   ├─ Attachement propriétaire + hôtel + lieux
   └─ Redirection vers détails booking

4. FLIGHT SELECTION & PERSONALIZATION
   ├─ Sélection compagnie/classe de vol
   ├─ Visualisation timeline (itinéraire)
   ├─ Ajout activités custom (optionnel)
   └─ Accès au plan détaillé

5. PAYMENT
   ├─ Accès formulaire paiement (3 steps)
   ├─ Confirmation données (destination, vol, hôtel)
   ├─ Traitement du paiement
   └─ Transition statut 'pending' → 'paid'

6. SHARING & COLLABORATION
   ├─ Génération code partageable (si passengers > 1)
   ├─ Partage code avec co-voyageurs
   ├─ Co-voyageurs rejoignent via code
   └─ Visualisation commune de la réservation

7. TRIP EXECUTION
   ├─ Visualisation plan (timeline + activités)
   ├─ Impression ticket (boarding pass)
   ├─ Voyage réalisé!
   └─ Post-voyage (optional: avis, photos)
```

---

### 6.2 Flux Détaillé : Génération d'Itinéraire

```
USER FLOWS DÉTAIL: Trip Generator

START: GET /generate
├─ View: trip.index → formulaire saisie
├─ Remplissage:
│  ├─ Trip Type (select): adventure|culture|beach|romantic|nature|shopping
│  ├─ Budget Total (input): number >= 100
│  ├─ Duration (input): days >= 1
│  ├─ Passengers (input): number >= 1
│  ├─ Departure City (select): liste villes disponibles
│  ├─ Departure Date (input date): >= tomorrow
│  └─ Submit button: POST /generate
│
├─ VALIDATION (côté client + serveur):
│  ├─ Budget >= 100 ✓
│  ├─ Duration >= 1 ✓
│  ├─ Passengers >= 1 ✓
│  ├─ Departure Date >= J+1 ✓
│  ├─ Trip Type dalam whitelist ✓
│  └─ Departure City exists ✓
│
├─ ALGO MATCHING:
│  1. SELECT cities WHERE trip_type = X AND id != departure_city_id
│  2. FOR EACH city:
│     ├─ maxHotelPerNight = (budget × 0.7) / duration / passengers
│     ├─ SELECT hotels WHERE city_id IN (...) AND price <= maxHotelPerNight
│     ├─ IF empty: fallback to price <= budget / duration / passengers
│     └─ LIMIT 3 (random order)
│  3. FOR EACH hotel:
│     ├─ hotel_cost = price × duration × passengers
│     ├─ remaining = budget - hotel_cost
│     ├─ flight_budget = 0
│     ├─ activities_budget = remaining × 0.7
│     ├─ misc_budget = remaining × 0.3
│     ├─ SELECT places FOR city (ORDER BY min_price ASC)
│     └─ APPEND to trips array
│
├─ RESULT: Array[trip1, trip2, trip3] OR ERROR "Aucun voyage trouvé"
│
├─ VIEW: results.blade.php
│  ├─ Display 3 trip proposals
│  ├─ EACH TRIP CARD:
│  │  ├─ Hotel toggle switch
│  │  ├─ Hotel selector (scrollable list)
│  │  ├─ Places checkboxes
│  │  ├─ Budget bars (Accommodation, Experiences, Misc)
│  │  ├─ Warning box (if places > activities)
│  │  ├─ Animated numbers
│  │  └─ "Confirm This Trip" button
│  │
│  ├─ DYNAMICJS:
│  │  ├─ selectHotel(): toggle hotel + recalculate
│  │  ├─ togglePlace(): select/deselect + recalculate
│  │  ├─ updateTrip(): AJAX PUT /bookings/{id} → recalc budgets
│  │  └─ animateNumber(): animate budget numbers
│  │
│  └─ Form (hidden):
│     ├─ city_id, hotel_id, duration, passengers
│     ├─ budget_total, flight_budget, hotel_budget, activities_budget, misc_budget
│     ├─ trip_type, departure_city_id, departure_date
│     ├─ selected_place_ids (comma-separated)
│     ├─ include_hotel (boolean)
│     └─ Submit: POST /trip/confirm
│
├─ ACTION: Click "Confirm This Trip"
│  ├─ POST /trip/confirm
│  ├─ BACKEND: CREATE Booking
│  │  ├─ INSERT INTO bookings (user_id, city_id, ..., status='pending')
│  │  ├─ ATTACH user as owner (booking_user: isOwner=true)
│  │  ├─ ATTACH hotel with check-in/out dates (booking_hotel)
│  │  └─ SYNC selected places (booking_place)
│  └─ REDIRECT: GET /my-bookings/{id} ✓
│
└─ END: Booking created, status='pending'
```

---

### 6.3 Flux Détaillé : Paiement & Partage

```
USER FLOWS DÉTAIL: Payment & Sharing

STEP 1: PAYMENT INITIATION
├─ Click: "Payer" on bookings.show
├─ Redirect: GET /my-bookings/{id}/payment
├─ View: payment/show.blade.php (3-step form)
│  ├─ Step 1: Trip Details (read-only)
│  ├─ Step 2: Flight Selection (compagnie, classe, prix)
│  ├─ Step 3: Hotel Confirmation (dates, prix, hôtel)
│  └─ Submit: "Confirm Payment" → POST /my-bookings/{id}/payment

STEP 2: PAYMENT PROCESSING
├─ POST /my-bookings/{id}/payment
├─ Validation:
│  ├─ start_date (required|date)
│  ├─ departure_country (required|string)
│  ├─ departure_city (required|string)
│  └─ [Card fields cosmetic]
├─ BACKEND:
│  ├─ CREATE Payment (user_id, booking_id, start_date, ...)
│  ├─ UPDATE Booking → status = 'paid'
│  └─ RETURN JSON: {"success": true} OR redirect
└─ REDIRECT: GET /my-bookings/{id}/ticket

STEP 3: TICKET DISPLAY & SHARING
├─ Page: /my-bookings/{id}/ticket
├─ Show: Boarding pass (printable)
│  ├─ Reference number, passenger, flight info
│  ├─ Hotel confirmation (if include_hotel)
│  ├─ Status badge (PAID)
│  └─ "Print" button (media print CSS)

STEP 4: SHARING (if passengers > 1)
├─ Back to: GET /my-bookings/{id}
├─ Click: "Generate Share Code"
├─ AJAX: POST /my-bookings/{id}/share-code
│  ├─ CHECK: status='paid' ✓
│  ├─ CHECK: passengers > 1 ✓
│  ├─ GENERATE: code = uppercase alphanum 6 chars
│  ├─ STORE: booking.share_code = code
│  └─ RETURN: {"success": true, "code": "ABC123"}
├─ Display: Shareable code + copy button

STEP 5: CO-TRAVELER JOINING
├─ Co-traveler receives code (via chat, email, etc.)
├─ Opens: GET /my-bookings
├─ Submits: POST /my-bookings/join (form or AJAX)
│  ├─ Input: share_code = "ABC123"
│  ├─ BACKEND:
│  │  ├─ FIND booking WHERE share_code = "ABC123"
│  │  ├─ CHECK: booking.status = 'paid' ✓
│  │  ├─ CHECK: booking.user_id != current_user ✓
│  │  ├─ CHECK: !booking.participants.contains(current_user) ✓
│  │  ├─ ATTACH: user to booking_user (isOwner=false)
│  │  └─ RETURN: redirect /my-bookings/{id}
│  └─ Co-traveler now sees shared booking in /my-bookings list

STEP 6: SHARED BOOKING VIEW
├─ Both owner + co-travelers access: GET /my-bookings/{id}
├─ Display:
│  ├─ Own participation status (Owner / Participant)
│  ├─ Hotel, flights, places, budget (shared view)
│  ├─ Participants list (name, joined date)
│  └─ Plan view: GET /my-bookings/{id}/plan

└─ END: Trip shared successfully!
```

---

### 6.4 Flux Détaillé : Trip Plan & Itinéraire

```
USER FLOWS DÉTAIL: Trip Planning & Timeline

STEP 1: PLAN VISUALIZATION
├─ Click: "View Trip Plan" on bookings.show
├─ Navigate: GET /my-bookings/{id}/plan
├─ View: bookings/plan.blade.php
│
├─ DISPLAY COMPONENTS:
│  1. Trip Summary Card:
│     ├─ Destination city
│     ├─ Duration (X days)
│     ├─ Total budget
│     └─ Participants count
│
│  2. Interactive Timeline:
│     ├─ Node 1 (Blue): Flight departure - "Jour 1: Départ"
│     ├─ Node 2 (Amber): Hotel arrival - "Jour 2: Arrivée + Check-in"
│     ├─ Nodes 3 to N-1 (Emerald): Places visits - "Jour X: Lieu Y"
│     ├─ Free days (Slate): "Jour X: Exploration libre"
│     └─ Final Node (Blue): Return flight - "Dernier jour: Retour"
│
│  3. Daily Details (expandable):
│     ├─ Time window
│     ├─ Activity type (place/free/flight)
│     ├─ Location name (if applicable)
│     ├─ Estimated duration
│     └─ Budget impact

STEP 2: ALGORITHM FOR TIMELINE
├─ Jour 1: Flight (Blue node)
├─ Jour 2: Hotel check-in (Amber node) [if include_hotel = true]
├─ Jours 3 to Duration-1:
│  ├─ Get selected places (already in booking.places via pivot)
│  ├─ FOR EACH place:
│  │  ├─ Assign visit_date (incremental days)
│  │  ├─ IF multiple places: 2 per day max
│  │  └─ IF no place for day: mark as "Free exploration"
│  └─ Emerald nodes for places, Slate for free days
├─ Dernier jour: Flight return (Blue node)
└─ Total timeline = duration days

STEP 3: CUSTOM ACTIVITIES
├─ Button: "+ Add Custom Activity"
├─ Form popup or section:
│  ├─ Name (string)
│  ├─ Budget (decimal)
│  ├─ Date (optional)
│  └─ Submit
├─ AJAX: POST /my-bookings/{id}/plan/activity
│  ├─ BACKEND: CREATE CustomActivity (booking_id, name, budget, date)
│  ├─ Recalc: booking.activities_budget -= custom_budget
│  └─ RETURN: {"success": true, "total_cost": XXX}
│
├─ Display: Activity added to timeline
│  ├─ OR: In separate "Custom Activities" list
│  └─ Delete button: DELETE /my-bookings/{id}/plan/activity/{activityId}

STEP 4: PRINT / EXPORT
├─ Button: "Print / Download PDF"
├─ Trigger: window.print() or PDF generation
├─ CSS: @media print {
│        ├─ Hide buttons
│        ├─ Show full timeline
│        ├─ Optimize for A4 layout
│        └─ }
├─ Output:  Printable itinerary document
└─ User: Prints or saves as PDF

└─ END: Trip plan visualized complete!
```

---

## 7. STACK TECHNIQUE

### 7.1 Backend

**Framework:** Laravel 11 (PHP)

- **Architecture:** MVC (Model-View-Controller)
- **ORM:** Eloquent
- **Migrations:** Artisan migrations
- **Authentication:** Laravel Breeze + Email verification
- **Authorization:** Middleware + Gate/Policy

**Schéma des Routes:**

```
/                               → Welcome (guest)
/register, /login               → Auth (guest)
/dashboard                      → Redirect (user role)
/generate                       → Trip generator (user)
/my-bookings                    → Bookings list (user)
/my-bookings/{id}              → Booking details + flight selection (user)
/my-bookings/{id}/payment      → Payment form (user)
/my-bookings/{id}/ticket       → Boarding pass (user)
/my-bookings/{id}/plan         → Trip itinerary (user)
/my-bookings/{id}/plan/activity → Custom activities (user)
/admin/dashboard               → Admin dashboard (admin, travlerAdmin)
/admin/users                   → User management (admin)
/admin/countries               → Catalog management (admin, travlerAdmin)
/admin/cities                  → Catalog management (admin, travlerAdmin)
/admin/hotels                  → Catalog management (admin, travlerAdmin)
/admin/places                  → Catalog management (admin, travlerAdmin)
```

**Database:**

- MySQL 8.0+
- Migrations versionées (auto-exécutées)
- Foreign keys avec ON DELETE CASCADE
- Indexes sur FK et champs frequently queried

### 7.2 Frontend

**Templating:** Blade (Laravel)

- Fichiers: `resources/views/*.blade.php`
- Layouts: `resources/views/layouts/app.blade.php`
- Components: `resources/views/components/*.blade.php`

**Styling:** Tailwind CSS + Custom CSS

- Colors: primary (sky-600), indigo, emerald, slate palettes
- Glass cards: `background: rgba(255,255,255,0.85)`
- Animations: slideRight, slideLeft, slideUp (cubic-bezier)

**JavaScript:**

- Vanilla JS (no framework required)
- AJAX calls via `fetch()` API
- DOM manipulation for dynamic updates
- `animateNumber()` function for budget animations
- `selectHotel()`, `togglePlace()`, `updateTrip()` for interactions

**Assets Pipeline:**

- Vite (bundler moderne)
- CSS & JS minified en production
- Source maps en développement

### 7.3 Déploiement & Infrastructure

**Serveur Web:** Apache/Nginx

- `.htaccess` ou Nginx config pour routing Blade
- Cache busting sur assets (Vite)

**Base de Données:**

- MySQL 8.0+ ou MariaDB
- Backups quotidiennes
- Indexes pour performance

**Environnement:**

- `.env` pour configuration
- Variables: `APP_ENV`, `APP_DEBUG`, `DB_*`, `MAIL_*`
- Secrets: API keys, DB credentials (jamais en git)

**Sécurité:**

- CSRF tokens (Laravel CSRF middleware)
- XSS protection (Blade escaping)
- SQL injection protection (Eloquent)
- Rate limiting sur endpoints sensibles
- HTTPS obligatoire en production

---

## 8. MODÈLE DE DONNÉES

### 8.1 Entités Principales

#### 8.1.1 User

```
TABLE: users
├─ id (PK, auto-increment)
├─ name (varchar 255)
├─ email (varchar 255, unique)
├─ email_verified_at (timestamp, nullable)
├─ password (varchar 255, hashed)
├─ role (enum: user|admin|travlerAdmin, default:user)
├─ is_banned (boolean, default:false)
├─ remember_token (varchar 100, nullable)
├─ created_at (timestamp)
└─ updated_at (timestamp)

RELATIONS:
├─ hasMany(Booking) - réservations créées
├─ belongsToMany(Booking, booking_user) - réservations partagées
└─ hasMany(Payment) - paiements effectués
```

**Modèle Laravel:**

```php
class User {
  public function bookings() { return $this->hasMany(Booking::class); }
  public function sharedBookings() { return $this->belongsToMany(Booking::class, 'booking_user')->withPivot('isOwner'); }
  public function payments() { return $this->hasMany(Payment::class); }
  public function isAdmin() { return $this->role === 'admin'; }
  public function isTravlerAdmin() { return $this->role === 'travlerAdmin'; }
}
```

---

#### 8.1.2 Booking

```
TABLE: bookings
├─ id (PK, auto-increment)
├─ user_id (FK → users.id, NOT NULL, cascade delete)
├─ city_id (FK → cities.id, NOT NULL, cascade delete)
├─ departure_city_id (FK → cities.id, nullable, cascade delete)
├─ trip_type (varchar 50: adventure, culture, beach, romantic, nature, shopping)
├─ budget_total (decimal 10.2, NOT NULL)
├─ duration (int, NOT NULL, min 1)
├─ passengers (int, NOT NULL, min 1)
├─ departure_date (date, nullable)
├─ flight_budget (decimal 10.2, default 0)
├─ hotel_budget (decimal 10.2, default 0)
├─ activities_budget (decimal 10.2, default 0)
├─ misc_budget (decimal 10.2, default 0)
├─ status (enum: pending|paid, default:pending)
├─ share_code (varchar 6, nullable, unique)
├─ selected_place_ids (text, nullable) ← comma-separated IDs (JSON compatible)
├─ include_hotel (boolean, default:true)
├─ flight_airline (varchar 100, nullable)
├─ flight_class (varchar 50, nullable: economy|business|first)
├─ flight_duration (varchar 50, nullable: "XhYm" format)
├─ created_at (timestamp)
└─ updated_at (timestamp)

INDEX:
├─ user_id (FK lookup)
├─ city_id (FK lookup)
├─ status (filtering)
├─ share_code (unique)
└─ created_at (sorting)

RELATIONS:
├─ belongsTo(User) - propriétaire
├─ belongsTo(City) - destination
├─ belongsTo(City, departure_city_id) - départ
├─ hasOne(Payment) - paiement associé
├─ belongsToMany(Hotel, booking_hotel) - hôtels sélectionnés avec pivot dates
├─ belongsToMany(User, booking_user) - participants avec pivot isOwner
├─ belongsToMany(Place, booking_place) - lieux sélectionnés avec pivot visit_date
└─ hasMany(CustomActivity) - activités personnalisées
```

**Modèle Laravel:**

```php
class Booking {
  protected $fillable = [
    'user_id', 'city_id', 'trip_type', 'departure_city_id',
    'budget_total', 'duration', 'passengers', 'departure_date',
    'flight_budget', 'hotel_budget', 'activities_budget', 'misc_budget',
    'status', 'selected_place_ids', 'include_hotel',
    'flight_airline', 'flight_class', 'flight_duration', 'share_code'
  ];

  public function user() { return $this->belongsTo(User::class); }
  public function city() { return $this->belongsTo(City::class); }
  public function departureCity() { return $this->belongsTo(City::class, 'departure_city_id'); }
  public function hotels() { return $this->belongsToMany(Hotel::class, 'booking_hotel')->withPivot('check_in_date', 'check_out_date')->withTimestamps(); }
  public function participants() { return $this->belongsToMany(User::class, 'booking_user')->withPivot('isOwner')->withTimestamps(); }
  public function places() { return $this->belongsToMany(Place::class, 'booking_place')->withPivot('visit_date')->withTimestamps(); }
  public function customActivities() { return $this->hasMany(CustomActivity::class); }
  public function payment() { return $this->hasOne(Payment::class); }
  public function getCustomActivitiesBudgetAttribute() { return $this->customActivities()->sum('budget'); }
}
```

---

#### 8.1.3 Hotel

```
TABLE: hotels
├─ id (PK, auto-increment)
├─ city_id (FK → cities.id, NOT NULL, cascade delete)
├─ name (varchar 255, NOT NULL)
├─ price_per_night (decimal 10.2, NOT NULL)
├─ description (text, nullable)
├─ image (text, nullable) ← URL ou path
├─ type (varchar 50: 3-star, 4-star, 5-star, etc.)
├─ created_at (timestamp)
└─ updated_at (timestamp)

INDEX:
├─ city_id (FK lookup, frequently filtered)
└─ price_per_night (sorting)

RELATIONS:
├─ belongsTo(City)
└─ belongsToMany(Booking, booking_hotel) - réservations
```

---

#### 8.1.4 Place (Lieu d'Intérêt)

```
TABLE: places
├─ id (PK, auto-increment)
├─ city_id (FK → cities.id, NOT NULL, cascade delete)
├─ name (varchar 255, NOT NULL)
├─ description (text, nullable)
├─ image (text, nullable) ← URL ou path
├─ localisation (varchar 100: Museum, Park, Beach, Restaurant, etc.)
├─ min_price (decimal 10.2, NOT NULL) ← entry price or activity cost
├─ created_at (timestamp)
└─ updated_at (timestamp)

INDEX:
├─ city_id (FK lookup)
└─ min_price (sorting by budget)

RELATIONS:
├─ belongsTo(City)
└─ belongsToMany(Booking, booking_place) - réservations
```

---

#### 8.1.5 City

```
TABLE: cities
├─ id (PK, auto-increment)
├─ country_id (FK → countries.id, NOT NULL, cascade delete)
├─ name (varchar 255, NOT NULL)
├─ trip_type (varchar 50: adventure, culture, beach, romantic, nature, shopping)
├─ description (text, nullable)
├─ image (text, nullable)
├─ created_at (timestamp)
└─ updated_at (timestamp)

INDEX:
├─ country_id (FK lookup)
└─ trip_type (filtering)

RELATIONS:
├─ belongsTo(Country)
├─ hasMany(Hotel)
├─ hasMany(Place)
└─ hasMany(Booking)
```

---

#### 8.1.6 Country

```
TABLE: countries
├─ id (PK, auto-increment)
├─ name (varchar 255, NOT NULL, unique)
├─ trip_type (varchar 50: adventure, culture, beach, romantic, nature, shopping)
├─ description (text, nullable)
├─ image (text, nullable)
├─ cardinals (varchar 255) ← "lat,lng" format for Haversine calculation
├─ created_at (timestamp)
└─ updated_at (timestamp)

INDEX:
├─ name (unique)
└─ trip_type (filtering)

RELATIONS:
└─ hasMany(City)
```

---

#### 8.1.7 Payment

```
TABLE: payments
├─ id (PK, auto-increment)
├─ user_id (FK → users.id, NOT NULL, cascade delete)
├─ booking_id (FK → bookings.id, NOT NULL, unique, cascade delete)
├─ start_date (date, NOT NULL)
├─ departure_country (varchar 255, nullable)
├─ departure_city (varchar 255, nullable)
├─ is_flight_paid (boolean, default:false)
├─ is_hotel_paid (boolean, default:false)
├─ created_at (timestamp)
└─ updated_at (timestamp)

INDEX:
├─ user_id (FK lookup)
├─ booking_id (FK lookup, unique)

RELATIONS:
├─ belongsTo(User)
└─ belongsTo(Booking)
```

---

#### 8.1.8 CustomActivity

```
TABLE: booking_custom_activities
├─ id (PK, auto-increment)
├─ booking_id (FK → bookings.id, NOT NULL, cascade delete)
├─ name (varchar 255, NOT NULL)
├─ budget (decimal 10.2, NOT NULL)
├─ date (date, nullable)
├─ created_at (timestamp)
└─ updated_at (timestamp)

INDEX:
└─ booking_id (FK lookup)

RELATIONS:
└─ belongsTo(Booking)
```

---

### 8.2 Tables Pivot (Relations N:N)

#### 8.2.1 booking_hotel

```
TABLE: booking_hotel
├─ id (PK, auto-increment)
├─ booking_id (FK → bookings.id, NOT NULL, cascade delete)
├─ hotel_id (FK → hotels.id, NOT NULL, cascade delete)
├─ check_in_date (date, nullable)
├─ check_out_date (date, nullable)
├─ created_at (timestamp)
└─ updated_at (timestamp)

INDEX:
├─ booking_id
└─ hotel_id

CONSTRAINT:
└─ Composite unique: (booking_id, hotel_id) ← Une réservation, un hôtel
```

---

#### 8.2.2 booking_user

```
TABLE: booking_user
├─ id (PK, auto-increment)
├─ booking_id (FK → bookings.id, NOT NULL, cascade delete)
├─ user_id (FK → users.id, NOT NULL, cascade delete)
├─ isOwner (boolean, default:false) ← true pour propriétaire, false pour participants
├─ created_at (timestamp)
└─ updated_at (timestamp)

INDEX:
├─ booking_id
└─ user_id

CONSTRAINT:
└─ Composite unique: (booking_id, user_id) ← Un voyage, un utilisateur (une seule adhésion)
```

---

#### 8.2.3 booking_place

```
TABLE: booking_place
├─ id (PK, auto-increment)
├─ booking_id (FK → bookings.id, NOT NULL, cascade delete)
├─ place_id (FK → places.id, NOT NULL, cascade delete)
├─ visit_date (date, nullable) ← optionnel, pour planification fine
├─ created_at (timestamp)
└─ updated_at (timestamp)

INDEX:
├─ booking_id
└─ place_id

CONSTRAINT:
└─ Composite unique: (booking_id, place_id)
```

---

### 8.3 Diagramme Entité-Relation Simplifié

```
        ┌─────────────┐
        │   COUNTRY   │
        ├─────────────┤
        │ id (PK)     │
        │ name        │
        │ cardinals   │
        └──────┬──────┘
               │ 1:N
               │
        ┌──────▼──────┐
        │    CITY     │
        ├─────────────┤
        │ id (PK)     │
        │ country_id  │
        │ name        │
        │ trip_type   │
        └──────┬──────┘
             ┌─┴─┐
          1:N│   │1:N
    ┌────────▼┐ ┌┴────────┐
    │ HOTEL   │ │  PLACE  │
    ├─────────┤ ├─────────┤
    │id (PK)  │ │id (PK)  │
    │city_id  │ │city_id  │
    │name     │ │name     │
    │price    │ │min_price│
    └────┬────┘ └────┬────┘
         │            │
         │   N:N      │   N:N
         │ (pivot)    │ (pivot)
         │  dates     │  visit_date
    ┌────▼────────────▼────┐
    │    BOOKING           │
    ├──────────────────────┤
    │id (PK)               │
    │user_id (FK)─────────────────┐
    │city_id (FK)                 │
    │departure_city_id            │
    │trip_type                    │
    │budget_total                 │
    │duration, passengers         │
    │status (pending|paid)        │
    │share_code (unique)          │
    │selected_place_ids           │
    │include_hotel                │
    │✖─────────────────────────┐  │
    │                       ┌──▼──▼──────┐
    │        N:N (isOwner)  │  USER      │
    │  ┌──────────────────────├───────────┤
    │  │                      │id (PK)    │
    │  │    N:1               │name       │
    │  │  ┌─────────────────────email     │
    │  │  │                    │password  │
    │  └──┼──ORD───1──────────│role      │
    │     │  (pivot: dates)    │is_banned │
    │     │  N:N              └──────────┘
    │     ▼
    │   PAYMENT
    │   ├─────────────┐
    │   │id (PK)      │
    │   │booking_id   │
    │   │user_id      │
    │   │start_date   │
    │   │is_flight_paid
    │   │is_hotel_paid│
    │   └─────────────┘
    │
    │   1:N
    │   ▼
    │ CUSTOM_ACTIVITY
    │ ├─────────────────┐
    │ │id (PK)          │
    │ │booking_id (FK)  │
    │ │name             │
    │ │budget           │
    │ │date             │
    │ └─────────────────┘
    └──────────────────────
```

---

## 9. GLOSSAIRE ET TERMINOLOGIE

| Terme                     | Définition                                                                   |
| ------------------------- | ---------------------------------------------------------------------------- |
| **Booking**               | Réservation de voyage créée par un utilisateur                               |
| **Trip Type**             | Catégorie de voyage (aventure, culture, plage, romantique, nature, shopping) |
| **Participant**           | Utilisateur invité à un voyage (via share_code)                              |
| **Propriétaire**          | Créateur d'une réservation (isOwner = true)                                  |
| **Share Code**            | Code unique 6 caractères pour inviter des co-voyageurs                       |
| **Pivot**                 | Table intermédiaire pour relations N:N (booking_user, booking_hotel, etc.)   |
| **Haversine**             | Formule géodésique pour calculer distance entre deux coordonnées             |
| **Cardinals**             | Coordonnées géographiques (latitude, longitude) d'un pays                    |
| **Customization**         | Personnalisation des sélections (hôtel, lieux, activités)                    |
| **Budget Redistribution** | Calcul automatique des sous-budgets selon les choix utilisateur              |
| **Status**                | État d'une réservation (pending = en attente, paid = payée)                  |

---

## 10. SPÉCIFICATIONS ADDITIONNELLES

### 10.1 Sécurité

- ✓ Authentification via Laravel Breeze (email + mot de passe)
- ✓ Vérification d'email obligatoire
- ✓ Middleware `auth` et `verified` sur toutes routes protégées
- ✓ Middleware `role:admin` et `role:travlerAdmin` pour admin panels
- ✓ CSRF protection (tokens Laravel)
- ✓ XSS protection (Blade auto-escaping)
- ✓ SQL injection protection (Eloquent ORM)
- ✓ Password hashing (bcrypt Laravel)
- ✓ Rate limiting optionnel sur endpoints sensibles
- ✓ Bannissement d'utilisateurs (`is_banned` flag)

### 10.2 Performance

- ✓ Eager loading de relations (N+1 problem prevention)
- ✓ Indexes sur FK et champs filtrés
- ✓ Pagination de listes longues
- ✓ Cache HTTP headers (`Cache-Control`, `ETag`)
- ✓ CDN pour images (optionnel)
- ✓ Vite pour minification assets
- ✓ Database query optimization (EXPLAIN ANALYZE)

### 10.3 Validation

**Côté Client :**

- HTML5 validations (required, min, max, type, pattern)
- JavaScript validations avant envoi

**Côté Serveur :**

- Laravel `validate()` avec rules explicites
- Messages d'erreur multilingues
- Custom rules si besoin

**Données Critiques :**

- Budget >= 100, <= arbitrary max
- Duration >= 1
- Passengers >= 1
- Email unique
- Dates >= tomorrow
- Trip type dans whitelist

### 10.4 Intégration Externe (Future)

- **Payment Gateway :** Stripe, PayPal pour véritables paiements
- **Email Service :** Sending confirmations, share notifications
- **SMS API :** Share code via SMS
- **Maps API :** Intégration Google Maps pour lieux
- **Flight API :** Vrai calcul tarif vols (Skyscanner, Kiwi.com)
- **Weather API :** Prévisions météo par destination/date
- **Analytics :** Google Analytics, Mixpanel

### 10.5 Localisation (i18n)

- **Langues supportées :** FR (Français principal), EN (English)
- **Ressources :** `resources/lang/{locale}/` files
- **Dates :** Format français (DD/MM/YYYY)
- **Devise :** EUR (€)

### 10.6 Accessibilité

- ✓ Sémantique HTML5 (aria-labels, roles)
- ✓ Contrast ratios WCAG AA minimum
- ✓ Keyboard navigation
- ✓ Screen reader compatibility
- ✓ Alt text pour images

---

## 11. DÉFINITION DE FAIT (Definition of Done)

Une fonctionnalité est considérée comme "faite" si :

- ✓ Code écrit et révisé
- ✓ Tests unitaires + intégration > 80% coverage
- ✓ Pas de bugs critiques
- ✓ Performance: < 200ms response time (p95)
- ✓ Sécurité: OWASP Top 10 vérifiée
- ✓ Accessibilité: WCAG AA
- ✓ Documentation code (docstrings, comments)
- ✓ Documentation utilisateur (help center)
- ✓ Tests E2E en environnement staging
- ✓ Approbation QA
- ✓ Déploiement en production
- ✓ Monitoring & alertes en place
- ✓ Feedback utilisateurs collecté

---

## 12. ROADMAP PRÉVISIONNEL

### Phase 1 ✅ (Complétée - Mai 2026)

- Système de génération d'itinéraires
- Customization des résultats
- Gestion des réservations (CRUD)
- Système de paiement (simulé)
- Sharing avec co-voyageurs
- Plan de voyage & itinéraire
- Admin panel pour catalogue

### Phase 2 (Prochainement)

- Intégration paiement réel (Stripe)
- Système de paiement partiel (split payment)
- Notifications email & SMS
- Wishlist / Favoris de voyages
- Reviews & ratings post-voyage
- Détection fraude & sécurité avancée
- Export itinéraire (PDF, iCal)

### Phase 3 (Future)

- API pour intégrations tierces
- Application mobile (iOS/Android)
- Chatbot IA pour recommandations
- Système de groupe / team management
- Partnerships avec hotels/airlines
- Loyalty program / points
- Analytics & dashboards pour utilisateurs

---

## 13. MÉTRIQUES DE SUCCÈS

| Métrique                      | Cible                                     |
| ----------------------------- | ----------------------------------------- |
| **Time to Book**              | < 2 minutes (du début à confirmation)     |
| **User Satisfaction**         | > 4.5/5 stars                             |
| **Booking Completion Rate**   | > 70% (vis-à-vis generation)              |
| **Sharing Adoption**          | > 50% des bookings multi-person partagées |
| **Payment Success Rate**      | > 95%                                     |
| **System Uptime**             | > 99.9%                                   |
| **Page Load Time**            | < 1.5s (p95)                              |
| **Mobile Traffic**            | > 60%                                     |
| **Repeat Users**              | > 40%                                     |
| **Customer Support Response** | < 24h                                     |

---

## 14. CONTACT & ESCALADE

**Équipe Produit :**

- Product Manager: [Contact]
- Tech Lead: [Contact]
- UX/UI Designer: [Contact]

**Liens Utiles :**

- Repository GitHub: [URL]
- Documentation: [Wiki]
- Issue Tracker: [GitHub Issues]
- CI/CD Pipeline: [GitHub Actions / Jenkins]
- Production Dashboard: [URL]
- Support: support@nomado.app

---

**Document Généré:** Mai 2026
**Version:** 1.0
**Statut:** Validé & Approuvé

---

## Appendices

### A. Exemple d'Itinéraire Généré

```json
{
    "trip": {
        "destination": "Barcelona, Spain",
        "departure": "Paris, France",
        "start_date": "2026-05-15",
        "duration_days": 5,
        "passengers": 2,
        "budget_total": 1500.0,
        "hotel": {
            "name": "Hotel Barcelona City",
            "price_per_night": 150.0,
            "check_in": "2026-05-16",
            "check_out": "2026-05-20",
            "total_cost": 600.0
        },
        "places": [
            {
                "id": 1,
                "name": "Sagrada Familia",
                "type": "Museum",
                "min_price": 26.0,
                "visit_date": "2026-05-17",
                "total_cost": 52.0
            },
            {
                "id": 2,
                "name": "Park Güell",
                "type": "Park",
                "min_price": 14.0,
                "visit_date": "2026-05-18",
                "total_cost": 28.0
            }
        ],
        "flights": {
            "outbound": {
                "airline": "Air France",
                "departure": "09:15",
                "arrival": "11:45",
                "duration": "1h 30m",
                "price_per_person": 180.0,
                "class": "economy"
            },
            "return": {
                "airline": "Air France",
                "departure": "14:00",
                "arrival": "16:30",
                "duration": "1h 30m",
                "price_per_person": 180.0,
                "class": "economy"
            }
        },
        "budget_breakdown": {
            "flights": 720.0,
            "accommodation": 600.0,
            "experiences": 80.0,
            "activities": 100.0,
            "miscellaneous": 0.0,
            "total": 1500.0
        }
    }
}
```

### B. Formule Budget Recalculation

```
budget_total = FIXED (EUR)
hotel_cost = price_per_night × duration × passengers (if include_hotel else 0)
flight_cost = flight_budget × passengers
places_cost = SUM(place.min_price × passengers for selected places)
custom_activities_cost = SUM(custom_activity.budget for all activities)

remaining = budget_total - hotel_cost - flight_cost - places_cost - custom_activities_cost

activities_budget = (remaining × 0.80) + custom_activities_cost
misc_budget = remaining × 0.20

Total spend = hotel_cost + flight_cost + places_cost + activities_budget + misc_budget
```

---

**Fin du Cahier des Charges.**
