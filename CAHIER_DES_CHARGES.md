# 📋 CAHIER DES CHARGES - NOMADO
## Planificateur de Voyage Intelligent

**Version:** 1.1 (Backlog Refined)
**Date:** Mai 2026
**Statut:** En production (Phase 1 complétée)

---

## 1. PRÉSENTATION DU PROJET

### 1.1 Vision Générale

**NOMADO** est une plateforme tout-en-un conçue pour automatiser et simplifier la création, la personnalisation, la budgétisation et le partage de voyages de groupe. La plateforme transforme l'expérience de planification de voyage  en offrant une solution intelligente qui génère des itinéraires personnalisés en fonction du budget, des préférences de voyage et du nombre de participants.

### 1.2 Proposition de Valeur

NOMADO répond à plusieurs enjeux critiques :

- **Automatisation de la planification :** Génération instantanée d'itinéraires basée sur des filtres intelligents.
- **Gestion budgétaire centralisée :** Budget fixe redistribué dynamiquement selon les choix des utilisateurs.
- **Collaboration simplifiée :** Partage de voyages via codes d'accès avec gestion des co-voyageurs.
- **Paiement sécurisé :** Système de paiement intégré avec génération de tickets de voyage.
- **Personnalisation avancée :** Sélection d'hôtels, lieux d'intérêt, activités personnalisées et vols.

---

## 2. ACTEURS ET RÔLES (Personas)

| Acteur | Rôle | Description |
|--------|------|-------------|
| **Visiteur** | Prospect | Accès en lecture seule au catalogue et aux informations publiques. |
| **Voyageur** | Utilisateur (User) | Acteur principal : crée, personnalise, paie et partage ses voyages. |
| **Co-voyageur** | Participant | Rejoint un voyage via un code pour visualiser l'itinéraire commun. |
| **Admin Contenu** | TravlerAdmin | Gère le catalogue des destinations (pays, villes, hôtels, lieux). |
| **Admin Système** | Admin | Gestion complète de la plateforme, des utilisateurs et du contenu. |

---

## 3. PRODUCT BACKLOG (Phase 1)

Ce backlog regroupe les fonctionnalités clés du système, exprimées sous forme de User Stories sans détails d'implémentation technique (code, routes, base de données).

### 3.1 Authentification et Profil
- **US-001 : Création de compte**
  - *En tant que* visiteur, *je souhaite* créer un compte *afin de* pouvoir enregistrer mes projets de voyage.
- **US-002 : Connexion sécurisée**
  - *En tant qu'*utilisateur enregistré, *je souhaite* me connecter *afin d'*accéder à mes réservations.
- **US-003 : Gestion du profil**
  - *En tant qu'*utilisateur, *je souhaite* modifier mes informations personnelles *afin de* garder mon compte à jour.

### 3.2 Découverte et Génération
- **US-004 : Exploration du catalogue**
  - *En tant que* visiteur, *je souhaite* consulter les destinations, hôtels et lieux d'intérêt *afin de* m'inspirer pour mon voyage.
- **US-005 : Génération d'itinéraires intelligents**
  - *En tant qu'*utilisateur, *je souhaite* renseigner mes préférences (budget, durée, passagers, type de voyage) *afin d'*obtenir des propositions de voyages optimisées.
- **US-006 : Comparaison des propositions**
  - *En tant qu'*utilisateur, *je souhaite* visualiser plusieurs options de voyages (villes, hôtels) *afin de* choisir celle qui me correspond le mieux.

### 3.3 Personnalisation et Budgétisation
- **US-007 : Ajustement des choix d'hébergement**
  - *En tant qu'*utilisateur, *je souhaite* inclure ou exclure l'hôtel et choisir parmi plusieurs options *afin de* contrôler mon budget logement.
- **US-008 : Sélection des lieux d'intérêt**
  - *En tant qu'*utilisateur, *je souhaite* sélectionner les lieux que je veux visiter *afin de* personnaliser mon programme quotidien.
- **US-009 : Visualisation budgétaire dynamique**
  - *En tant qu'*utilisateur, *je souhaite* voir l'impact de mes choix sur les différentes catégories de budget (Logement, Expériences, Divers) en temps réel.
- **US-010 : Sélection des vols**
  - *En tant qu'*utilisateur, *je souhaite* choisir une compagnie aérienne et une classe de voyage *afin de* finaliser mes options de transport.

### 3.4 Réservation et Paiement
- **US-011 : Confirmation de réservation**
  - *En tant qu'*utilisateur, *je souhaite* valider mes choix *afin de* créer une réservation en attente.
- **US-012 : Paiement sécurisé**
  - *En tant qu'*utilisateur (propriétaire), *je souhaite* régler ma réservation *afin de* confirmer définitivement mon voyage.
- **US-013 : Obtention du ticket de voyage**
  - *En tant qu'*utilisateur, *je souhaite* générer un ticket récapitulatif (Boarding Pass) après paiement *afin de* l'imprimer ou le conserver.

### 3.5 Collaboration et Partage
- **US-014 : Invitation de co-voyageurs**
  - *En tant que* propriétaire d'un voyage payé, *je souhaite* générer un code de partage *afin d'*inviter mes amis à rejoindre l'itinéraire.
- **US-015 : Adhésion à un voyage groupé**
  - *En tant qu'*utilisateur, *je souhaite* saisir un code de partage *afin de* participer à un voyage organisé par un ami.
- **US-016 : Consultation partagée**
  - *En tant que* participant, *je souhaite* visualiser l'itinéraire complet, les hôtels et les vols sélectionnés par le groupe.

### 3.6 Itinéraire et Planification
- **US-017 : Visualisation de la Timeline**
  - *En tant qu'*utilisateur, *je souhaite* voir mon voyage sous forme de ligne de temps jour par jour *afin de* mieux organiser mon temps.
- **US-018 : Ajout d'activités personnalisées**
  - *En tant qu'*utilisateur, *je souhaite* ajouter des activités manuelles à mon plan de voyage *afin de* compléter l'itinéraire proposé.

### 3.7 Administration
- **US-019 : Gestion du catalogue de destinations**
  - *En tant qu'*administrateur (Admin ou TravlerAdmin), *je souhaite* créer et modifier les pays, villes, hôtels et lieux *afin d'*enrichir l'offre de la plateforme.
- **US-020 : Dashboard de pilotage**
  - *En tant qu'*administrateur, *je souhaite* visualiser les statistiques globales (revenus, utilisateurs, voyages populaires) *afin de* suivre l'activité.
- **US-021 : Modération des utilisateurs**
  - *En tant qu'*administrateur système, *je souhaite* gérer les comptes utilisateurs (désactivation, bannissement) *afin de* garantir la sécurité de la plateforme.

---

## 4. RÈGLES MÉTIER (Business Rules)

### 4.1 Réservation et États
- **RB-001 :** Seul un utilisateur authentifié peut créer une réservation.
- **RB-002 :** Une réservation a un statut unique : `En attente` (modifiable) ou `Payé` (immuable).
- **RB-003 :** Une réservation payée ne peut plus être modifiée ni supprimée.

### 4.2 Partage et Collaboration
- **RB-004 :** Le partage n'est autorisé que pour les réservations avec plus d'un passager.
- **RB-005 :** Un code de partage ne peut être généré qu'après le paiement intégral du voyage.
- **RB-006 :** Le propriétaire d'un voyage ne peut pas rejoindre son propre voyage en tant que participant via un code.

### 4.3 Logique Budgétaire
- **RB-007 :** Le budget total est défini au départ et ne peut être dépassé par les sélections automatiques.
- **RB-008 :** Le budget restant est automatiquement redistribué entre les activités et les frais divers.
- **RB-009 :** Le coût des hôtels et des lieux est calculé par passager.

### 4.4 Contraintes de Voyage
- **RB-010 :** La ville de destination doit être différente de la ville de départ.
- **RB-011 :** La date de départ doit être au minimum le lendemain de la création.
- **RB-012 :** Un itinéraire doit durer au minimum 1 jour.

---

## 5. SPÉCIFICATIONS TECHNIQUES (Contraintes)

*Note : Cette section définit les contraintes de réalisation sans dicter la structure interne du code.*

### 5.1 Environnement
- **Framework :** Architecture basée sur PHP/Laravel.
- **Base de données :** Système relationnel (MySQL).
- **Interface :** Responsive, optimisée "Mobile-first", utilisant Tailwind CSS.

### 5.2 Algorithmes Clés
- **Génération d'Itinéraire :** Algorithme de matching basé sur le type de voyage, le budget par nuit et la localisation.
- **Calcul de Distance :** Utilisation de formules géodésiques pour estimer les temps de vol entre pays.
- **Répartition Budgétaire :** Calcul dynamique des sous-budgets (Vols, Logement, Expériences, Divers) avec mise à jour en temps réel sans rechargement de page.

### 5.3 Sécurité
- Chiffrement des mots de passe.
- Protection contre les injections SQL et les failles XSS.
- Gestion des accès basée sur les rôles (RBAC).

---

