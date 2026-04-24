# CAHIER DES CHARGES : NOMADO

## 1. Présentation du Projet

**Nom du projet :** Nomado

**Concept :** Site web qui génère automatiquement un voyage complet (pays + hôtel + vol) basé sur le type de voyage souhaité, le budget, la durée et le nombre de passagers. L'utilisateur paie directement sur le site et Nomado s'occupe de tout.

**Objectif :** Simplifier la réservation de voyage en automatisant le choix de la destination et des services selon les préférences et le budget de l'utilisateur.

**Durée du projet :** 8-10 semaines

---

## 2. Comment Ça Marche ?

### Processus Utilisateur :

1. **L'utilisateur s'inscrit et se connecte** au site
2. **L'utilisateur remplit un formulaire unique** :
   - Type de voyage (Aventure, Culture, Plage, Romantique, etc.)
   - Budget total (€)
   - Durée du séjour (en jours)
   - Nombre de passagers
3. **Le système calcule automatiquement** :
   - Répartition du budget (Vols: 30%, Hôtel: 40%, Activités: 20%, Divers: 10%)
4. **Le système recommande** :
   - UN pays correspondant au type de voyage choisi
   - UN hôtel selon le budget calculé pour l'hébergement
   - Prix estimé des vols (calculé automatiquement)
5. **L'utilisateur voit le résultat** avec le prix total
6. **L'utilisateur peut payer** directement sur le site
7. **Le voyage est confirmé** et sauvegardé dans son compte

---

## 3. Rôles Utilisateurs (SIMPLIFIÉ)

### ❌ PAS DE VISITEUR

- Pas de consultation sans compte
- Il faut obligatoirement créer un compte pour utiliser le site

### Utilisateur (Client)

- S'inscrire et se connecter
- Remplir le formulaire de génération de voyage
- Voir la recommandation (pays + hôtel + prix)
- Payer pour confirmer le voyage
- Voir ses voyages payés/confirmés

### Administrateur

- Se connecter avec un compte admin
- Gérer les pays (CRUD)
- Gérer les hôtels (CRUD)
- Voir les réservations des utilisateurs

---

## 4. Fonctionnalités Détaillées

### A. Système de Génération Automatique de Voyage

**Étape 1 : L'utilisateur remplit le formulaire**

```
- Type de voyage : (Aventure, Culture, Plage, Romantique, Nature, Shopping)
- Budget total : (ex: 2000€)
- Durée : (ex: 7 jours)
- Nombre de passagers : (ex: 2 personnes)
```

**Étape 2 : Le système calcule la répartition du budget**

```
Budget total = 2000€

Répartition automatique :
- Vols : 30% = 600€
- Hôtel : 40% = 800€
- Activités : 20% = 400€
- Divers : 10% = 200€
```

**Étape 3 : Le système choisit le pays**

- Chaque pays dans la base de données a un attribut "trip_type"
- Le système cherche les pays qui correspondent au type choisi
- Exemple : Si l'utilisateur choisit "Aventure" → Le système propose Maroc, Népal, Costa Rica...

**Étape 4 : Le système choisit l'hôtel**

- Calcul du budget hôtel par nuit : `Budget hôtel ÷ Nombre de nuits ÷ Nombre de passagers`
- Exemple : 800€ ÷ 7 nuits ÷ 2 personnes = 57€ par personne par nuit
- Le système trouve un hôtel dont le prix est proche de ce budget

**Étape 5 : Le système calcule le prix total**

```
Prix hôtel total = Prix par nuit × Nombre de nuits × Nombre de passagers
Prix vol estimé = Budget vol (30% du total)
Prix total = Prix hôtel + Prix vol
```

### B. Affichage du Résultat

**Page de résultat montre :**

- 🌍 Pays recommandé (nom + photo + description)
- 🏨 Hôtel recommandé (nom + photo + prix par nuit)
- ✈️ Prix estimé des vols
- 💰 Prix total du voyage
- 📝 Détail de la répartition du budget
- ✅ Bouton "Payer maintenant"

### C. Système de Paiement (SIMPLIFIÉ)

**Important : Pas de vrai paiement !**

- On simule juste le paiement
- L'utilisateur clique sur "Payer"
- Le système enregistre le voyage comme "Payé"
- Pas besoin d'intégrer Stripe ou PayPal (trop complexe)

### D. Mes Voyages

**L'utilisateur peut voir :**

- Liste de tous ses voyages
- Statut : "En attente" ou "Payé"
- Détails de chaque voyage (pays, hôtel, prix)

---

## 4. Technologies Utilisées (SIMPLES)

### Frontend

- **HTML5** : Structure des pages
- **CSS3 + Tailwind CSS** : Design et style
- **JavaScript** : Interactions basiques (afficher/cacher, validation formulaire)

### Backend

- **PHP 8** : Logique serveur
- **Laravel** : Framework PHP (utilisation basique)
  - Routes
  - Controllers
  - Models (Eloquent)
  - Blade (templates)

### Base de Données

- **MySQL** : Base de données simple

### Sécurité Basique

- Hash des mots de passe (bcrypt)
- Protection CSRF (Laravel intégré)
- Validation des formulaires

---

## 5. Base de Données SIMPLIFIÉE (4 Tables)

### **users** (Table des utilisateurs)

```sql
- id (clé primaire)
- name (nom complet)
- email (unique)
- password (hashé)
- role (ENUM: 'user', 'admin')
- created_at
- updated_at
```

### **countries** (Table des pays)

```sql
- id (clé primaire)
- name (nom du pays: "Maroc", "Espagne", "Thaïlande")
- trip_type (ENUM: 'adventure', 'culture', 'beach', 'romantic', 'nature', 'shopping')
  → C'est le type de voyage qui correspond à ce pays
- description (texte court sur le pays)
- image (URL de l'image du pays)
- created_at
- updated_at
```

**Exemple de données dans countries:**

```
| id | name      | trip_type   | description                           |
|----|-----------|-------------|---------------------------------------|
| 1  | Maroc     | adventure   | Déserts, montagnes, et médinas       |
| 2  | Espagne   | culture     | Architecture, musées, gastronomie    |
| 3  | Maldives  | beach       | Plages paradisiaques et eau turquoise|
| 4  | France    | romantic    | Paris, la ville de l'amour           |
```

### **hotels** (Table des hôtels)

```sql
- id (clé primaire)
- country_id (clé étrangère → countries.id)
- name (nom de l'hôtel)
- price_per_night (prix par nuit par personne en €)
- description (texte court)
- image (URL de l'image)
- created_at
- updated_at
```

**Exemple de données dans hotels:**

```
| id | country_id | name           | price_per_night |
|----|------------|----------------|-----------------|
| 1  | 1          | Riad Marrakech | 50€            |
| 2  | 1          | Atlas Hotel    | 80€            |
| 3  | 2          | Hotel Barcelona| 70€            |
```

### **bookings** (Table des réservations/voyages)

```sql
- id (clé primaire)
- user_id (clé étrangère → users.id)
- country_id (clé étrangère → countries.id)
- hotel_id (clé étrangère → hotels.id)
- trip_type (type de voyage choisi par l'utilisateur)
- budget_total (budget total entré par l'utilisateur)
- duration (durée en jours)
- passengers (nombre de passagers)
- flight_budget (30% du budget total - pour les vols)
- hotel_budget (40% du budget total - pour l'hôtel)
- activities_budget (20% du budget total)
- misc_budget (10% du budget total)
- budget_total (budget final total)
- status (ENUM: 'pending', 'paid')
  → 'pending' = en attente de paiement
  → 'paid' = voyage payé et confirmé
- created_at
- updated_at
```

### Relations Entre les Tables

```
users (1) ----< (N) bookings
countries (1) ----< (N) hotels
countries (1) ----< (N) bookings
hotels (1) ----< (N) bookings
```

**Explication des relations :**

- Un utilisateur peut avoir plusieurs réservations
- Un pays peut avoir plusieurs hôtels
- Un pays peut être réservé plusieurs fois
- Un hôtel peut être réservé plusieurs fois

---

## 6. Fonctionnalités Essentielles (User Stories)

### 🔐 Authentification (PRIORITÉ 1)

**US1** - En tant qu'utilisateur, je veux m'inscrire avec un email et mot de passe pour utiliser le site.

**US2** - En tant qu'utilisateur, je veux me connecter pour accéder aux fonctionnalités.

**US3** - En tant qu'utilisateur, je veux me déconnecter.

---

### ✈️ Génération de Voyage (PRIORITÉ 1)

**US4** - En tant qu'utilisateur, je veux choisir un type de voyage (Aventure, Culture, Plage, etc.).

**US5** - En tant qu'utilisateur, je veux entrer mon budget total, la durée et le nombre de passagers.

**US6** - En tant qu'utilisateur, je veux que le système calcule automatiquement la répartition de mon budget (30% vols, 40% hôtel, 20% activités, 10% divers).

**US7** - En tant qu'utilisateur, je veux voir UN pays recommandé basé sur le type de voyage que j'ai choisi.

**US8** - En tant qu'utilisateur, je veux voir UN hôtel recommandé dans ce pays selon mon budget.

**US9** - En tant qu'utilisateur, je veux voir le prix total de mon voyage (hôtel + vols estimés).

---

### 💳 Paiement (PRIORITÉ 2)

**US10** - En tant qu'utilisateur, je veux pouvoir "payer" mon voyage (simulation de paiement).

**US11** - En tant qu'utilisateur, après paiement, je veux que mon voyage soit marqué comme "Payé".

---

### 📋 Mes Voyages (PRIORITÉ 2)

**US12** - En tant qu'utilisateur, je veux voir la liste de tous mes voyages (en attente et payés).

**US13** - En tant qu'utilisateur, je veux voir les détails d'un voyage (pays, hôtel, prix, statut).

**US14** - En tant qu'utilisateur, je veux supprimer un voyage en attente.

---

### 🛠️ Administration (PRIORITÉ 2)

**US15** - En tant qu'admin, je veux me connecter avec un compte administrateur.

**US16** - En tant qu'admin, je veux voir la liste de tous les pays.

**US17** - En tant qu'admin, je veux ajouter un nouveau pays avec son type de voyage (trip_type).

**US18** - En tant qu'admin, je veux modifier les informations d'un pays.

**US19** - En tant qu'admin, je veux supprimer un pays.

**US20** - En tant qu'admin, je veux voir la liste des hôtels par pays.

**US21** - En tant qu'admin, je veux ajouter un hôtel à un pays avec son prix par nuit.

**US22** - En tant qu'admin, je veux modifier un hôtel existant.

**US23** - En tant qu'admin, je veux supprimer un hôtel.

**US24** - En tant qu'admin, je veux voir toutes les réservations des utilisateurs.

---

## 7. Planning Réaliste sur 8 Semaines

### Semaine 1-2 : Préparation et Setup

- ✅ Installer Laravel
- ✅ Créer la base de données (4 tables : users, countries, hotels, bookings)
- ✅ Design simple avec Tailwind CSS
- ✅ Créer les migrations Laravel

### Semaine 3-4 : Authentification

- ✅ Système d'inscription (Register)
- ✅ Système de connexion (Login)
- ✅ Logout
- ✅ Protection des routes (middleware)

### Semaine 5-6 : Fonctionnalité Principale (Génération de Voyage)

- ✅ Formulaire de génération (type, budget, durée, passagers)
- ✅ Logique de répartition du budget (30%, 40%, 20%, 10%)
- ✅ Algorithme de sélection du pays selon trip_type
- ✅ Algorithme de sélection de l'hôtel selon budget
- ✅ Calcul du prix total
- ✅ Page de résultat avec détails
- ✅ Simulation de paiement
- ✅ Sauvegarde de la réservation

### Semaine 7 : Administration

- ✅ Page admin pour gérer les pays (CRUD)
- ✅ Page admin pour gérer les hôtels (CRUD)
- ✅ Affichage des réservations

### Semaine 8 : Finalisation

- ✅ Tests complets
- ✅ Corrections de bugs
- ✅ Amélioration du design
- ✅ Ajout de données test (10-15 pays, 30-40 hôtels)
- ✅ Préparation de la présentation

---

## 8. Exemple de Données à Créer dans la Base

### Table Countries (Exemples)

| id  | name      | trip_type | description                        |
| --- | --------- | --------- | ---------------------------------- |
| 1   | Maroc     | adventure | Désert du Sahara, Atlas, Marrakech |
| 2   | Népal     | adventure | Himalaya, trekking, temples        |
| 3   | Espagne   | culture   | Gaudi, musées, flamenco            |
| 4   | Italie    | culture   | Rome, Renaissance, gastronomie     |
| 5   | Maldives  | beach     | Plages de rêve, eau turquoise      |
| 6   | Thaïlande | beach     | Îles paradisiaques, temples        |
| 7   | France    | romantic  | Paris, châteaux de la Loire        |
| 8   | Grèce     | romantic  | Santorin, coucher de soleil        |

### Table Hotels (Exemples pour le Maroc)

| id  | country_id | name           | price_per_night |
| --- | ---------- | -------------- | --------------- |
| 1   | 1          | Riad Marrakech | 50€             |
| 2   | 1          | Atlas Mountain | 70€             |
| 3   | 1          | Desert Camp    | 45€             |
| 4   | 1          | Luxury Palace  | 150€            |

---

## 9. Exemple de Flux Complet

### Scénario : Ahmed veut voyager

1. **Ahmed s'inscrit** sur Nomado
2. **Ahmed se connecte** avec son compte
3. **Ahmed va sur "Générer un voyage"**
4. **Ahmed remplit le formulaire :**
   - Type : "Aventure"
   - Budget : 1500€
   - Durée : 5 jours
   - Passagers : 2 personnes
5. **Le système calcule :**
   - Vols : 450€ (30%)
   - Hôtel : 600€ (40%)
   - Activités : 300€ (20%)
   - Divers : 150€ (10%)
6. **Le système cherche :**
   - Pays avec trip_type = "adventure" → Trouve : Maroc, Népal, Costa Rica
   - Choisit au hasard → **Maroc**
7. **Le système cherche un hôtel au Maroc :**
   - Budget par nuit par personne : 600€ ÷ 5 jours ÷ 2 = 60€/nuit
   - Trouve "Riad Marrakech" à 50€/nuit → Parfait !
8. **Ahmed voit le résultat :**
   - Pays : Maroc
   - Hôtel : Riad Marrakech (50€/nuit)
   - Prix total hôtel : 50€ × 5 × 2 = 500€
   - Prix vols estimés : 450€
   - **Prix total : 950€**
9. **Ahmed clique sur "Payer maintenant"**
10. **Le système enregistre :**
    - Nouvelle réservation dans la table `bookings`
    - Statut : "paid"
11. **Ahmed peut voir sa réservation dans "Mes Réservations"**

---

**FIN DU CAHIER DES CHARGES**

---
