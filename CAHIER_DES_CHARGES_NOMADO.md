# CAHIER DES CHARGES : NOMADO

## 1. Présentation du Projet

**Nom du projet :** Nomado

**Concept :** Plateforme intelligente de planification de voyages permettant aux utilisateurs de générer automatiquement des plans de voyage personnalisés en fonction de leur budget, du nombre de voyageurs et de la durée du séjour.

**Objectif :** Simplifier et automatiser le processus de planification de voyage en offrant des itinéraires sur mesure, des recommandations d'hébergement et d'activités adaptées au budget de chaque utilisateur.

---

## 2. Analyse des Besoins (Rôles Utilisateurs)

### Visiteur (Non authentifié)
- Consulter la page d'accueil et les destinations populaires
- Voir des exemples d'itinéraires générés
- Accéder aux informations sur le fonctionnement du site
- S'inscrire ou se connecter

### Utilisateur (Voyageur)
- S'authentifier (Login/Register)
- Créer un plan de voyage personnalisé :
  - Définir le budget total
  - Indiquer le nombre de voyageurs
  - Choisir la durée du séjour
  - Spécifier les préférences (type de voyage : aventure, détente, culture, etc.)
- Consulter et modifier les plans de voyage générés
- Sauvegarder ses itinéraires favoris
- Consulter l'historique de ses voyages planifiés
- Exporter l'itinéraire en PDF
- Laisser des avis sur les destinations visitées

### Administrateur
- Gérer la base de données des destinations
- Gérer les hôtels et leurs tarifs
- Gérer les activités et attractions par destination
- Gérer les utilisateurs (CRUD complet)
- Consulter les statistiques d'utilisation
- Modérer les avis utilisateurs
- Configurer les paramètres de génération d'itinéraires

---

## 3. Spécifications Fonctionnelles

### A. Système de Génération d'Itinéraires

**Processus de création :**
1. L'utilisateur remplit un formulaire avec :
   - Budget total (€)
   - Nombre de voyageurs
   - Durée du séjour (en jours)
   - Période souhaitée (dates ou saison)
   - Préférences de voyage (nature, ville, plage, montagne, culture, aventure)
   - Point de départ (optionnel)

2. Le système calcule et génère automatiquement :
   - **Destination optimale** basée sur le budget et les préférences
   - **Répartition budgétaire** :
     - Transport (25-35% du budget)
     - Hébergement (30-40% du budget)
     - Activités (20-30% du budget)
     - Nourriture et divers (15-20% du budget)

### B. Génération de l'Itinéraire Détaillé

**Contenu de l'itinéraire :**
- **Jour par jour :** Planning détaillé pour chaque journée du voyage
- **Hébergement recommandé** : Sélection d'hôtels/logements selon le budget
- **Activités suggérées** : Liste d'activités avec prix estimés
- **Estimations de coûts** : Détail des dépenses prévues
- **Conseils pratiques** : Informations utiles sur la destination

### C. Gestion des Destinations

**Base de données destinations :**
- Nom de la destination (ville/pays)
- Description et caractéristiques
- Budget moyen par jour et par personne
- Saisons recommandées
- Attraits principaux
- Photos et galerie
- Température moyenne par saison
- Niveau de sécurité

### D. Gestion des Hébergements

**Informations hôtels :**
- Nom et catégorie (étoiles)
- Prix par nuit (différentes gammes)
- Localisation (coordonnées GPS)
- Équipements et services
- Photos
- Lien vers le site de réservation

### E. Gestion des Activités

**Base de données activités :**
- Nom de l'activité
- Destination associée
- Type (culture, sport, détente, gastronomie, etc.)
- Prix estimé
- Durée
- Description
- Niveau de difficulté (facile, modéré, difficile)

### F. Système de Sauvegarde et Partage

- Sauvegarder un itinéraire dans "Mes Voyages"
- Modifier un itinéraire sauvegardé
- Partager l'itinéraire par email ou lien
- Exporter en PDF avec design professionnel
- Marquer un voyage comme "réalisé"

### G. Système d'Avis et Retours

- Noter une destination (1-5 étoiles)
- Laisser un commentaire détaillé
- Ajouter des photos du voyage
- Consulter les avis d'autres utilisateurs

---

## 4. Spécifications Techniques

### Frontend
- **HTML5** : Structure sémantique
- **CSS3** : Stylisation
- **Tailwind CSS** : Framework CSS pour design moderne et responsive
- **JavaScript (Vanilla)** : Interactions dynamiques et manipulation du DOM
- **AJAX** : Requêtes asynchrones pour génération d'itinéraires

### Backend
- **PHP 8** : Langage serveur (Programmation Orientée Objet)
- **Laravel 10+** : Framework PHP
  - Routing
  - Controllers
  - Models (Eloquent ORM)
  - Middleware pour authentification
  - Validation des formulaires
  - API RESTful pour communication frontend-backend

### Base de Données
- **MySQL** : Système de gestion de base de données relationnelle
- **Migrations Laravel** : Gestion de la structure de la base

### Sécurité
- **Authentification sécurisée** : Laravel Sanctum ou Breeze
- **Protection CSRF** : Tokens de sécurité
- **Hachage des mots de passe** : Bcrypt
- **Validation des entrées** : Prévention des injections SQL et XSS
- **HTTPS** : Certificat SSL pour connexions sécurisées

### APIs et Services Externes (Optionnel)
- **API Météo** : OpenWeatherMap pour informations climatiques
- **API de Change** : Taux de conversion de devises
- **Google Maps API** : Cartes et géolocalisation
- **API de Vol** : Skyscanner ou Amadeus pour prix de vols (si intégration)

---

## 5. Modélisation de la Base de Données (MCD)

### Tables Principales

#### **users**
```
- id (PK)
- name (VARCHAR)
- email (VARCHAR, UNIQUE)
- password (VARCHAR, hashed)
- role_id (FK -> roles.id)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **roles**
```
- id (PK)
- name (VARCHAR) -> 'admin', 'user'
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **destinations**
```
- id (PK)
- name (VARCHAR)
- country (VARCHAR)
- description (TEXT)
- average_budget_per_day (DECIMAL)
- best_season (VARCHAR)
- safety_level (ENUM: 'low', 'medium', 'high')
- image_url (VARCHAR)
- latitude (DECIMAL)
- longitude (DECIMAL)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **hotels**
```
- id (PK)
- destination_id (FK -> destinations.id)
- name (VARCHAR)
- category (INT) -> Nombre d'étoiles (1-5)
- price_per_night (DECIMAL)
- address (VARCHAR)
- amenities (TEXT)
- image_url (VARCHAR)
- booking_link (VARCHAR)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **activities**
```
- id (PK)
- destination_id (FK -> destinations.id)
- name (VARCHAR)
- type (ENUM: 'culture', 'sport', 'relaxation', 'gastronomy', 'adventure')
- description (TEXT)
- price (DECIMAL)
- duration (INT) -> En heures
- difficulty_level (ENUM: 'easy', 'moderate', 'hard')
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **trips** (Plans de voyage créés)
```
- id (PK)
- user_id (FK -> users.id)
- destination_id (FK -> destinations.id)
- title (VARCHAR)
- budget (DECIMAL)
- number_of_travelers (INT)
- duration (INT) -> Nombre de jours
- start_date (DATE, nullable)
- end_date (DATE, nullable)
- preferences (TEXT) -> JSON avec préférences
- status (ENUM: 'draft', 'saved', 'completed')
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **trip_hotels** (Relation Many-to-Many)
```
- id (PK)
- trip_id (FK -> trips.id)
- hotel_id (FK -> hotels.id)
- number_of_nights (INT)
- total_price (DECIMAL)
```

#### **trip_activities** (Relation Many-to-Many)
```
- id (PK)
- trip_id (FK -> trips.id)
- activity_id (FK -> activities.id)
- day_number (INT) -> Jour de l'itinéraire
- is_selected (BOOLEAN) -> Activité confirmée ou optionnelle
```

#### **itinerary_days** (Détail jour par jour)
```
- id (PK)
- trip_id (FK -> trips.id)
- day_number (INT)
- title (VARCHAR)
- description (TEXT)
- estimated_cost (DECIMAL)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **reviews** (Avis utilisateurs)
```
- id (PK)
- user_id (FK -> users.id)
- destination_id (FK -> destinations.id)
- rating (INT) -> 1-5 étoiles
- comment (TEXT)
- photos (TEXT) -> JSON avec URLs des photos
- is_approved (BOOLEAN)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

---

## 6. Diagramme des Relations

```
users (1) ----< (N) trips
destinations (1) ----< (N) trips
destinations (1) ----< (N) hotels
destinations (1) ----< (N) activities
destinations (1) ----< (N) reviews
users (1) ----< (N) reviews

trips (N) ----< (N) hotels (via trip_hotels)
trips (N) ----< (N) activities (via trip_activities)
trips (1) ----< (N) itinerary_days
```

---

## 7. User Stories (Backlog Fonctionnel)

### Epic 1 : Authentification et Gestion des Utilisateurs

**US1.1** - En tant que visiteur, je veux pouvoir m'inscrire sur la plateforme pour créer mes plans de voyage.

**US1.2** - En tant qu'utilisateur, je veux me connecter de manière sécurisée pour accéder à mes voyages sauvegardés.

**US1.3** - En tant qu'utilisateur, je veux pouvoir modifier mes informations de profil (nom, email, mot de passe).

**US1.4** - En tant qu'administrateur, je veux gérer tous les utilisateurs (créer, modifier, supprimer).

### Epic 2 : Génération d'Itinéraires

**US2.1** - En tant qu'utilisateur, je veux remplir un formulaire avec mon budget, le nombre de voyageurs et la durée pour obtenir un itinéraire personnalisé.

**US2.2** - En tant qu'utilisateur, je veux voir une destination recommandée basée sur mes critères et préférences.

**US2.3** - En tant qu'utilisateur, je veux consulter un itinéraire détaillé jour par jour avec activités suggérées.

**US2.4** - En tant qu'utilisateur, je veux voir une répartition claire de mon budget (transport, hébergement, activités, nourriture).

**US2.5** - En tant qu'utilisateur, je veux pouvoir régénérer un itinéraire si le premier ne me convient pas.

### Epic 3 : Gestion des Hébergements

**US3.1** - En tant qu'utilisateur, je veux voir des recommandations d'hôtels adaptés à mon budget.

**US3.2** - En tant qu'utilisateur, je veux consulter les détails d'un hôtel (prix, équipements, localisation).

**US3.3** - En tant qu'administrateur, je veux ajouter, modifier ou supprimer des hôtels dans la base de données.

### Epic 4 : Gestion des Activités

**US4.1** - En tant qu'utilisateur, je veux voir des activités suggérées pour chaque jour de mon voyage.

**US4.2** - En tant qu'utilisateur, je veux filtrer les activités par type (culture, sport, détente).

**US4.3** - En tant qu'administrateur, je veux gérer la liste des activités disponibles par destination.

### Epic 5 : Sauvegarde et Gestion des Voyages

**US5.1** - En tant qu'utilisateur, je veux sauvegarder mon itinéraire généré pour le consulter plus tard.

**US5.2** - En tant qu'utilisateur, je veux consulter l'historique de tous mes voyages planifiés.

**US5.3** - En tant qu'utilisateur, je veux modifier un itinéraire sauvegardé (changer dates, activités).

**US5.4** - En tant qu'utilisateur, je veux supprimer un voyage de ma liste.

**US5.5** - En tant qu'utilisateur, je veux marquer un voyage comme "réalisé".

### Epic 6 : Export et Partage

**US6.1** - En tant qu'utilisateur, je veux exporter mon itinéraire en PDF pour l'imprimer.

**US6.2** - En tant qu'utilisateur, je veux partager mon itinéraire par email ou lien.

**US6.3** - En tant qu'utilisateur, je veux générer un lien public pour partager mon voyage avec des amis.

### Epic 7 : Avis et Retours

**US7.1** - En tant qu'utilisateur, je veux laisser un avis sur une destination que j'ai visitée.

**US7.2** - En tant qu'utilisateur, je veux noter une destination (1-5 étoiles).

**US7.3** - En tant qu'utilisateur, je veux ajouter des photos à mon avis.

**US7.4** - En tant qu'administrateur, je veux modérer les avis avant publication.

**US7.5** - En tant que visiteur, je veux consulter les avis d'autres utilisateurs sur une destination.

### Epic 8 : Administration et Gestion des Destinations

**US8.1** - En tant qu'administrateur, je veux ajouter de nouvelles destinations à la base de données.

**US8.2** - En tant qu'administrateur, je veux modifier les informations d'une destination (budget moyen, description).

**US8.3** - En tant qu'administrateur, je veux supprimer une destination obsolète.

**US8.4** - En tant qu'administrateur, je veux consulter des statistiques sur les destinations les plus populaires.

### Epic 9 : Dashboard et Statistiques

**US9.1** - En tant qu'administrateur, je veux voir le nombre total d'utilisateurs inscrits.

**US9.2** - En tant qu'administrateur, je veux consulter le nombre d'itinéraires générés.

**US9.3** - En tant qu'administrateur, je veux voir les destinations les plus demandées.

**US9.4** - En tant qu'utilisateur, je veux voir mes statistiques personnelles (nombre de voyages planifiés, budget total dépensé).

---

## 8. Contraintes et Exigences Non Fonctionnelles

### Performance
- Temps de génération d'un itinéraire : < 3 secondes
- Temps de chargement des pages : < 2 secondes
- Support de 100+ utilisateurs simultanés

### Compatibilité
- Responsive design (mobile, tablette, desktop)
- Compatible avec les navigateurs modernes (Chrome, Firefox, Safari, Edge)

### Accessibilité
- Contraste suffisant pour la lisibilité
- Navigation au clavier possible
- Textes alternatifs sur les images

### Évolutivité
- Architecture modulaire pour ajout de nouvelles fonctionnalités
- Possibilité d'intégration d'APIs tierces (vols, météo)

---

## 9. Phases de Développement

### Phase 1 : MVP (Minimum Viable Product)
- Authentification utilisateur
- Formulaire de génération d'itinéraire
- Génération basique d'une destination
- Affichage d'itinéraire simple
- Base de données avec 10-20 destinations

### Phase 2 : Fonctionnalités Avancées
- Sauvegarde des voyages
- Recommandations d'hôtels
- Suggestions d'activités détaillées
- Export PDF

### Phase 3 : Fonctionnalités Premium
- Système d'avis et notations
- Partage social
- Dashboard administrateur complet
- Statistiques et analytics

### Phase 4 : Optimisations et Extensions
- Intégration APIs externes (météo, change)
- Optimisation des performances
- Système de recommandations intelligent (IA/ML)
- Application mobile (optionnel)

---

## 10. Livrables Attendus

- Code source complet (Frontend + Backend)
- Base de données avec données de test
- Documentation technique
- Guide utilisateur
- Présentation du projet (slides)
- Démo fonctionnelle déployée

---

## 11. Planning Estimatif

| Phase | Durée | Tâches principales |
|-------|-------|-------------------|
| Analyse et Design | 1 semaine | MCD, Wireframes, Architecture |
| Développement Backend | 3 semaines | Laravel, API, Base de données |
| Développement Frontend | 3 semaines | HTML/CSS/JS, Intégration |
| Tests et Débogage | 1 semaine | Tests fonctionnels, corrections |
| Déploiement | 3 jours | Mise en production |
| **Total** | **8-9 semaines** | |

---

## 12. Critères de Succès

✅ Un utilisateur peut créer un compte et se connecter  
✅ Un itinéraire est généré en fonction du budget et de la durée  
✅ L'itinéraire contient une destination, un hôtel et des activités  
✅ Un utilisateur peut sauvegarder et consulter ses voyages  
✅ L'interface est intuitive et responsive  
✅ Les données sont sécurisées (HTTPS, mots de passe hachés)  
✅ L'administrateur peut gérer destinations, hôtels et activités  

---

**Fin du Cahier des Charges**
