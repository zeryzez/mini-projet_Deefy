# mini-projet_Deefy Mathys Blonbou S3A
voici le rendu attendu pour le mini-projet Deefy, constitué principalement des
fonctionnalités développées dans le cadre des TD pour l’application Deefy.

Vous etes sur le lien du dépot git du projet et pourrez retrouvez les fichiers demandées tels que :
- le fichier README.md
- Le tableau de bord de l'application Deefy
- Le fichier de configuration de la base de donnée (ScriptSql.txt)
- Le fichier de test de l'application Deefy 

La connexion a la base de donnée se fait en modifiant les valeurs des variables suivantes dans le fichier de configuration de la base de donnée src/repository/Config.db.ini

## Tableau de bord de l'application Deefy

### 🚀 Fonctionnalité principales

|Fonctionnalité|Description|
|---|---|
|📝 Ajouter une Playlist|Formulaire permettant de créer une nouvelle playlist en saisissant le nom de celle-ci|
|🔍 Rechercher une Playlist|Formulaire permettant de rechercher une playlist par son nom|
|➕ Ajouter une Piste Podcast|Formulaire pour ajouter un podcast à une playlist (nom + fichier .mp3)|
|👤 Inscription Utilisateur|Formulaire d'inscription avec vérification de l'email et du mot de passe|
|🔑 Connexion Utilisateur|Formulaire de connexion avec authentification via AuthnProvider::signin()|
|📜 Afficher une Playlist|Affiche les pistes d'une playlist spécifique, avec vérification des droits d'accès utilisateur|

### 📊 Données et Gestion des Utilisateurs

|Type | Détails|
|---|---|
|🔒 Sessions | Utilisées pour stocker la session utilisateur et les données des playlists|
| 📧 Authentification|Gestion des utilisateurs via la classe AuthnProvider, avec exception en cas d'erreur d'identification|
|👥 Authorization|Validation des droits d'accès pour afficher une playlist, via Authz::checkPlaylistOwner()|
|📦 Données Utilisateurs|Stockées dans la table `users` de la base de données|


### 📂 Gestion des Fichiers et Playlists

|Fonctionnalité|	Description|
|---|---|
|📁 Upload Fichiers Audio|Vérifie que le fichier est en .mp3, enregistre avec un nom unique dans le dossier audio|
|🗒️ Visualisation Playlist|AudioListRenderer génère une vue HTML pour chaque playlist|