# 1. Résumé de la demande

## 1.1 Contexte

Le service de transplantation rénale du CHU XXX prend en charge les patients de la région, ainsi que ceux de quelques départements limitrophes. Ces patients, atteints le plus souvent d’insuffisance rénale terminale, peuvent ainsi bénéficier d’une greffe rénale afin d’améliorer leur confort de vie quotidien.  

Cette prise en charge s’effectue lors de la phase dite de **pré-greffe**, puis lors de l’hospitalisation liée à la greffe proprement dite.

Lors de sa sortie d’hospitalisation, le patient retourne à son domicile souvent éloigné géographiquement du CHU. Le suivi est alors effectué par son néphrologue de ville.

Lors de cette phase **post-greffe**, le patient n’est revu au CHU que **6 mois après la greffe**, puis lors de visites annuelles ou plus resserrées en cas de besoin.  
Le néphrologue de ville est donc la personne effectuant la plus grande part du suivi longitudinal post greffe.

---

## 1.2 Constat

Suite à la greffe et aux visites de contrôle annuelles au sein du CHU, de nombreux néphrologues de la région effectuent des demandes d’informations auprès du service de transplantation afin de compléter les informations des dossiers de leurs patients.

Réciproquement, le service du CHU doit intégrer à son actuel dossier patient les informations en provenance des néphrologues de ville afin de disposer des données de suivi lors des visites de contrôle.

De multiples inconvénients sont liés à ces demandes/échanges d’informations :

- difficultés lors des échanges entre médecins du CHU et néphrologues de ville,
- deux dossiers patient informatisés disjoints doivent être maintenus à jour,
- risque non négligeable de la présence d’informations manquantes ou erronées de part et d’autre,
- risques importants liés à la corruption de la sécurité des informations confidentielles transmises,
- temps important d’échange et de mise à jour des dossiers patients.

---

## 1.3 Objectif général du projet

Les constats énoncés au paragraphe précédent montrent l’impérieuse nécessité de la mise en place d’une **application partagée permettant l’accès à un “dossier patient greffe”**, commun au CHU et aux néphrologues de ville.

Ce dossier doit pouvoir être **consulté et mis à jour en temps réel** par les praticiens hospitaliers et les praticiens de ville.

---

## 1.4 Idée de base du projet

Proposer une **application sécurisée accessible sur tout système** :

- ordinateur  
- tablette  
- téléphone  

permettant la **consultation et la mise à jour des informations médicales liées au suivi longitudinal des patients greffés du rein**.

Cette application doit pouvoir gérer :

- les données d’identification du patient,
- les comptes-rendus médicaux établis par les médecins (du CHU ou de ville),
- la saisie des paramètres biologiques **pré-greffe, greffe et post-greffe**,
- un module d’administration des données liées aux utilisateurs.

Dans un premier temps, et afin de disposer d’une application fonctionnelle le plus rapidement possible, **seul le périmètre fonctionnel lié à la greffe sera pris en compte.**

---

# 2. Expression des besoins métier

## 2.1 Accès à l’application et authentification

L’application doit être accessible aux professionnels de santé :

- médecins
- infirmières
- autres profils non encore définis

de manière sécurisée, en utilisant une **authentification via la carte CPS (Carte Professionnel de Santé).**

Il est indispensable de proposer **un mode d’accès alternatif** en cas d’indisponibilité de la carte CPS (panne, perte de la carte).  
L’application doit en effet pouvoir être accessible par un professionnel autorisé en cas de besoin urgent.

Parmi les utilisateurs, on doit pouvoir définir des **profils administrateurs** prenant en charge la gestion des données liées aux utilisateurs de l’application.

Dans un premier temps :

> tout utilisateur de l’application aura accès à l’intégralité des fonctions de gestion des données patient.

Cependant, il faut prévoir qu’une version ultérieure pourra intégrer **des profils utilisateurs avec droits restreints**, par exemple :

- consultation seule des données patient

Enfin, il est demandé de **garder une trace de l’activité des utilisateurs** au sein de l’application :

- identité de l’utilisateur
- heure de début de connexion
- heure de fin de connexion

---

## 2.2 Accès aux données de l’application

Lorsque l’utilisateur est authentifié, celui-ci doit avoir accès aux fonctions principales :

- recherche de patients
- accès aux dossiers patients
- création d’un nouveau patient

---

## 2.3 Recherche de patients

L'utilisateur doit avoir accès à une recherche par critères dans la liste ci-dessous :

- nom patient
- prénom patient
- numéro de dossier patient
- ville de résidence

La recherche n'est valide que si **au moins un critère est renseigné.**

Lorsque la recherche renvoie une liste de patients :

- celle-ci est triée par **ordre alphabétique du nom des patients**

Si la recherche renvoie un grand nombre de patients :

- l'affichage de la liste doit être **paginé**
- l’utilisateur doit **donner son accord pour afficher plus de 200 résultats**

*(ce nombre pourra éventuellement être modifié en fonction des retours utilisateurs).*

Après l’affichage de la liste des patients, l’utilisateur peut :

- sélectionner un patient dans la liste et ouvrir le dossier correspondant
- effectuer une autre recherche

---

## 2.4 Accès à un dossier patient

Suite à la sélection d’un dossier patient, l’utilisateur a accès à un ensemble de fonctions :

- gestion des antécédents du patient
- gestion des consultations attachées au dossier
- gestion des greffes du patient
- gestion de l’**Éducation Thérapeutique du Patient (ETP)**
- consultation des résultats biologiques disponibles dans le dossier

---

# 2.5 Gestion des greffes du patient

La gestion des greffes consiste à accéder, dans un premier temps, à la **liste des greffes dont le patient a bénéficié**.

La liste est affichée :

> de la plus ancienne à la plus récente.

Pour chaque greffe on affiche :

- date
- type
- rang de la greffe

L’utilisateur doit pouvoir :

- accéder aux informations détaillées de la greffe
- créer une nouvelle greffe si la greffe recherchée n’est pas présente

**Remarque :**

La suppression d’une greffe est possible **uniquement pour les profils administrateurs**.

---

# 2.5.1 Informations liées à la greffe

Une greffe est caractérisée par les informations essentielles suivantes :

- date de la greffe
- rang de la greffe
- type de donneur du greffon :

  - donneur vivant
  - donneur décédé par mort encéphalique
  - donneur décédé par mort cœur arrêté

Les informations affichées en consultation sont **identiques aux informations saisies en création/modification.**

---

## Informations complémentaires de la greffe

- **Greffon fonctionnel** — Information indispensable  
- **Date/heure de fin de fonction du greffon** — Non indispensable (si greffon non fonctionnel)  
- **Cause de fin de fonction du greffon** — Non indispensable (si greffon non fonctionnel)

### Type de greffe (obligatoire)

Valeurs possibles :

- Rein
- Rein donneur vivant
- Rein-pancréas
- Rein-foie
- Rein-cœur
- Autre

### Informations opératoires

- Nom du chirurgien — Non indispensable
- Date de déclampage — Non indispensable
- Heure de déclampage — Non indispensable

### Informations anatomiques

- Côté de prélèvement du rein — droit / gauche
- Côté de transplantation du rein — droit / gauche
- En — Extra Péritonéal / Intra Péritonéal

### Durées opératoires

- Ischémie totale — durée (heures + minutes)
- Durée des anastomoses — durée (minutes)

### Dispositifs

- Sonde JJ — Oui / Non

### Commentaires

- Commentaire — texte libre
- Compte-rendu opératoire — gestion de fichier :
  - téléchargement
  - consultation
  - suppression

---

## Statuts virologiques

### CMV (obligatoire)

- D-/R-
- D-/R+
- D+/R-
- D+/R+

### EBV (optionnel)

- D-/R-
- D-/R+
- D+/R-
- D+/R+

### Toxoplasmose (optionnel)

- R+
- R-

---

## Incompatibilités HLA

- HLA A — 0 / 1 / 2
- HLA B — 0 / 1 / 2
- HLA Cw — 0 / 1 / 2
- HLA DR — 0 / 1 / 2
- HLA DQ — 0 / 1 / 2
- HLA DP — 0 / 1 / 2

---

## Risque immunologique (obligatoire)

Valeurs possibles :

| Valeur | Couleur |
|------|------|
| Non immunisé | Vert |
| Immunisé sans DSA | Orange |
| Immunisé DSA | Rouge |
| ABO incompatible | Rouge |

Autres champs :

- Commentaire risque immunologique
- Conditionnement immunosuppresseur
- Commentaire conditionnement

---

## Conditionnement immunosuppresseur (liste)

- Advagraf
- Prograf
- Neoral
- Rapamune
- Certican
- Cellcept
- Myfortic
- Imurel
- Methylprednisolone
- Mabthera
- Ig IV
- Soliris
- Thymoglobulines
- Simulect
- Plasmaphérese
- Immuno absorption

---

## Protocole

- Valeur : Oui / Non

Si **Oui** :

- téléchargement du fichier protocole
- consultation
- suppression

---

## Dialyse

- Dialyse — Oui / Non

Si **Oui** :

- Date de dernière dialyse — obligatoire

---

# 2.5.2 Informations liées au donneur

Un donneur est la personne dont est issu le greffon transplanté.

Deux cas possibles :

- **donneur décédé**
- **donneur vivant**

---

# 2.5.2.1 Informations communes aux donneurs

- Numéro CRISTAL — obligatoire
- Groupe sanguin — A / B / AB / O
- Sexe — M / F
- Age — obligatoire
- Taille — optionnel
- Poids — optionnel
- Commentaire patient — optionnel

---

## Groupage HLA

- HLA A — entier positif
- HLA B — entier (modification admin uniquement après validation)
- HLA Cw — entier
- HLA DR — entier
- HLA DQ — entier
- HLA DP — entier

---

## Sérologies

- CMV — + / -
- EBV — + / -
- Toxoplasmose — + / - / ND
- HIV — + / -
- HTLV — + / -
- Syphilis — + / -
- HCV — + / -
- ARNc — + / -
- Ag HBS — + / -
- Ac HBS — + / -
- Ac HBC — + / -
- DNA B — + / -

---

## Informations opératoires donneur

- Nom du chirurgien
- Date de clampage
- Heure de clampage
- Côté de prélèvement du rein
- Commentaire rein prélevé

---

## Anatomie vasculaire

- Artère principale
- Artère polaire supérieure
- Artère polaire inférieure
- Veine
- Commentaire veine

---

## Perfusion

- Machine à perfusion — Oui / Non
- Liquide de perfusion :
  - Viaspan
  - Celsior
  - IgL
  - Scott

---

# 2.5.2.2 Informations propres aux donneurs vivants

- Nom donneur
- Prénom donneur
- Lien de parenté :

  - Parent
  - Enfant
  - 2ème degré
  - Conjoint
  - Non apparenté
  - Autre

- Commentaire lien de parenté

---

## Mesures biologiques

- IMC — calculé : poids / taille²
- Créatinine
- Clairance calculée :

```
186 × (créatinine (µmol/l) × 0.0113)^-1.154 × âge^-0.203
× 0.742 pour les femmes
```

- Clairance isotopique
- Commentaire clairance
- Protéinurie

---

## Technique chirurgicale

- Voie d’abord — Lombotomie / Cœlioscopie
- Robot — Oui / Non

---

# 2.5.2.3 Informations propres aux donneurs décédés

- Ville d’origine
- Cause du décès :

  - AVC hémorragique
  - AVC ischémique
  - AVP
  - TC non AVP
  - Anoxie
  - Autre

- Commentaire cause du décès

---

## Donneur à critères étendus

Valeur : **Oui / Non**

Définition affichée :

> Donneur ≥ 60 ans OU donneur ≥ 50 ans avec deux des trois critères suivants :
> HTA, créatinine ≥ 132 µmol/l, décès de cause vasculaire

---

## Paramètres médicaux

- Arrêt cardiaque — Oui / Non
- Durée arrêt cardiaque
- PA moyenne
- Amines — Oui / Non

---

## Transfusion

- Transfusion — Oui / Non

Si **Oui** :

- CGR
- CPA
- PFC

---

## Fonction rénale

- Créatinine arrivée
- Créatinine prélèvement

### DFG calculé

**Homme**

```
175 × (créatinine / 88.4)^-1.154 × âge^-0.203
```

**Femme**

```
(175 × (créatinine / 88.4)^-1.154 × âge^-0.203) × 0.742
```

---

## État vasculaire

- Athérome aorte — Oui / Non
- Plaques calcifiées aorte — Oui / Non
- Athérome artère ostium — Oui / Non
- Plaques calcifiées artère ostium — Oui / Non
- Athérome artère rénale — Oui / Non
- Plaques calcifiées artère rénale — Oui / Non

---

## Informations complémentaires

- Uretère — 1 / 2
- Plaie digestive — Oui / Non
- Liquide de conservation :

  - Viaspan
  - Celsior
  - IGL
  - Scott

- Infection liquide de conservation — Oui / Non