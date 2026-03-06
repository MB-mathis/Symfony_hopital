# Cahier des charges – Application de suivi des greffes rénales

---

# 1. Contexte du projet

Le service de transplantation rénale du CHU prend en charge des patients atteints d’insuffisance rénale terminale provenant de la région ainsi que de départements limitrophes.

Ces patients peuvent bénéficier d’une **greffe rénale**, permettant une amélioration significative de leur qualité de vie.

Le parcours du patient comporte plusieurs phases :

- Phase pré-greffe
- Hospitalisation pour la transplantation
- Suivi post-greffe

Après l’hospitalisation, le patient retourne généralement à son domicile, parfois éloigné géographiquement du CHU. Le suivi médical est alors principalement assuré par le **néphrologue de ville**.

Dans ce contexte, le patient n’est revu au CHU que :

- 6 mois après la greffe
- puis lors de visites annuelles ou en cas de besoin

Le néphrologue de ville devient donc l’acteur principal du suivi longitudinal.

---

# 2. Problématique actuelle

Actuellement, les informations médicales sont réparties entre plusieurs systèmes :

- le dossier patient du CHU
- le dossier médical du néphrologue de ville

Cela entraîne plusieurs difficultés :

- échanges fréquents d’informations entre les médecins
- duplication des dossiers patients
- risque d’informations manquantes ou incohérentes
- problèmes de sécurité dans la transmission des données
- perte de temps administratif importante

---

# 3. Objectif du projet

L’objectif est de concevoir une **application sécurisée de gestion du dossier patient greffe** permettant :

- un accès partagé entre le CHU et les néphrologues de ville
- une mise à jour en temps réel des données
- un suivi centralisé du patient greffé

L’application doit permettre la gestion :

- des patients
- des greffes
- des consultations
- des données biologiques
- des comptes rendus médicaux

---

# 4. Périmètre fonctionnel

Dans une première version, l’application se concentre uniquement sur :

- le suivi des greffes rénales

Les autres spécialités médicales ne sont pas concernées.

---

# 5. Utilisateurs de l'application

L'application est destinée aux professionnels de santé :

- médecins hospitaliers
- néphrologues de ville
- infirmiers (potentiellement dans une version future)
- administrateurs

Chaque utilisateur doit posséder un **compte sécurisé**.

---

# 6. Accès et authentification

L'accès à l'application doit être sécurisé.

## Authentification principale

Authentification via **Carte Professionnelle de Santé (CPS)**.

## Authentification secondaire

Un mode d'accès alternatif doit être disponible en cas de :

- perte de la carte
- panne
- indisponibilité du lecteur

Ce mode devra rester sécurisé :

- identifiant
- mot de passe

---

# 7. Gestion des rôles utilisateurs

Deux rôles principaux doivent être implémentés.

## Utilisateur standard

Peut :

- consulter les dossiers patients
- créer ou modifier des informations médicales
- accéder aux données biologiques
- consulter les greffes

## Administrateur

Peut en plus :

- gérer les comptes utilisateurs
- supprimer certaines données sensibles
- modifier certaines informations verrouillées

---

# 8. Traçabilité et sécurité

L’application doit conserver une **trace de l’activité des utilisateurs**.

Pour chaque connexion :

- identifiant utilisateur
- date et heure de connexion
- date et heure de déconnexion

Cette traçabilité permet :

- la sécurité médicale
- la conformité réglementaire

---

# 9. Gestion des patients

L’application doit permettre :

- la création d’un patient
- la recherche de patients
- l’accès à un dossier patient

Chaque patient possède un **numéro de dossier unique**.

---

# 10. Recherche de patients

La recherche peut se faire selon plusieurs critères :

- nom
- prénom
- numéro de dossier
- ville de résidence

Conditions :

- au moins **un critère doit être renseigné**

Les résultats doivent :

- être triés par ordre alphabétique
- être paginés

Si le nombre de résultats dépasse **200 patients**, l’utilisateur doit confirmer l’affichage.

---

# 11. Dossier patient

Le dossier patient centralise plusieurs modules :

- antécédents
- consultations
- greffes
- éducation thérapeutique (ETP)
- résultats biologiques

---

# 12. Gestion des greffes

Chaque patient peut avoir **plusieurs greffes**.

Les greffes doivent être affichées :

- de la plus ancienne à la plus récente

Pour chaque greffe :

- date
- type
- rang de la greffe

Fonctionnalités disponibles :

- consulter les détails
- créer une nouvelle greffe
- supprimer une greffe (admin uniquement)

---

# 13. Informations d'une greffe

Une greffe contient plusieurs informations.

## Informations principales

- date de greffe
- rang de la greffe
- type de donneur

## Informations médicales

- statut du greffon
- type de greffe
- chirurgien
- durée d’ischémie
- durée des anastomoses
- présence de sonde JJ
- compatibilité HLA
- risque immunologique

## Documents

L’utilisateur peut gérer :

- compte rendu opératoire
- protocole médical

Actions possibles :

- importer un fichier
- consulter
- supprimer

---

# 14. Gestion des donneurs

Deux types de donneurs existent.

## Donneur vivant

Informations supplémentaires :

- nom
- prénom
- lien de parenté
- IMC
- créatinine
- clairance rénale
- protéinurie
- voie d’abord chirurgicale

## Donneur décédé

Informations supplémentaires :

- cause du décès
- ville d’origine
- durée arrêt cardiaque
- transfusion
- données biologiques
- critères étendus du donneur

---

# 15. Calculs médicaux automatiques

Certaines valeurs doivent être **calculées automatiquement** par l’application.

Exemples :

- IMC
- clairance rénale
- DFG

Ces calculs évitent les erreurs humaines.

---

# 16. Contraintes techniques

L'application doit :

- être accessible sur ordinateur, tablette et mobile
- respecter les normes de sécurité des données médicales
- utiliser une architecture web sécurisée

Technologies envisagées :

- Symfony
- MySQL / MariaDB
- Doctrine ORM
- Authentification sécurisée
- Docker

---

# 17. Fonctionnalités MVP (Minimum Viable Product)

Les fonctionnalités indispensables pour une première version sont :

## Authentification

- connexion utilisateur
- gestion des rôles

## Gestion des patients

- création
- recherche
- consultation

## Gestion des greffes

- création
- consultation
- modification

## Gestion des donneurs

- donneur vivant
- donneur décédé

## Historique des connexions

- traçabilité minimale

## Upload de documents

- compte rendu opératoire

---

# 18. Fonctionnalités secondaires (version future)

Certaines fonctionnalités sont intéressantes mais peuvent être ajoutées plus tard.

## Gestion avancée des utilisateurs

- profils infirmiers
- profils lecture seule

## Historique des modifications

- audit complet des changements

## Gestion complète des consultations

- suivi détaillé

## Gestion des résultats biologiques

- import automatique depuis laboratoires

## Notifications

- rappel de visite annuelle
- alertes médicales

## Statistiques médicales

- suivi des résultats de greffe
- indicateurs médicaux

---

# 19. Analyse critique (vision développeur)

Du point de vue technique, plusieurs points devront être surveillés.

## Complexité du modèle de données

Le nombre de champs médicaux est très important.

Une **modélisation solide de la base de données** sera indispensable.

## Sécurité des données

Les données médicales sont **hautement sensibles** :

- chiffrement
- gestion stricte des accès
- journalisation

## Maintenabilité

Le projet devra utiliser :

- architecture claire
- entités bien séparées
- validation des données

## Scalabilité

Le système doit pouvoir évoluer pour :

- d’autres spécialités
- plus d’utilisateurs
- plus de patients

---

# 20. Conclusion

Cette application vise à améliorer la **coordination entre le CHU et les néphrologues de ville** en centralisant les données médicales des patients greffés.

Elle permettra :

- un meilleur suivi des patients
- une réduction des erreurs
- un gain de temps pour les professionnels de santé

Le projet sera développé progressivement, en commençant par un **MVP fonctionnel**, puis en ajoutant des fonctionnalités avancées.