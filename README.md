# mini-projet_Deefy Mathys Blonbou S3A
voici le rendu attendu pour le mini-projet Deefy, constitué principalement des
fonctionnalités développées dans le cadre des TD pour l’application Deefy.

Vous etes sur le lien du dépot git du projet et pourrez retrouvez les fichiers demandées tels que :
- le fichier README.md
- Le tableau de bord de l'application Deefy
- Le fichier de configuration de la base de donnée (ScriptSql.txt)
- Le fichier de test de l'application Deefy 

> La connexion a la base de donnée se fait en modifiant les valeurs des variables suivantes dans le fichier de configuration de la base de donnée src/repository/Config.db.ini.

Il est possible de tester l'application en utilisant l'utilisateur administrateur suivant :
- email : admin@mail.com
- mot de passe : admin
En créant un nouvel utilisateur ou en utilisant un déjà existant tels que :
- email : user1@mail.com
- mot de passe : user1

## Tableau de bord de l'application Deefy

### 🚀 Fonctionnalité principales

|Fonctionnalité|Description|
|---|---|
|📝 Ajouter une Playlist|Formulaire permettant de créer une nouvelle playlist en saisissant le nom de celle-ci|
|➕ Ajouter une Piste Podcast|Formulaire pour ajouter un podcast à une playlist (nom + fichier .mp3)|
|👤 Inscription Utilisateur|Formulaire d'inscription avec vérification de l'email et du mot de passe via AuthnProvider::register()|
|🔑 Connexion Utilisateur|Formulaire de connexion avec authentification via AuthnProvider::signin()|
|📜 Afficher une Playlist|Affiche les pistes d'une playlist spécifique, celle choisit parmit toutes celles affichers dans l'affichage de toute les playlist, ou en choisissant dans l'url après vérification des droits d'accès utilisateur|
|📜 Afficher Toute les Playlist|Affiche les playlist spécifique à l'utilisateur connecter|

> [!NOTE]
>- Chaque utilisateur peut créer une playlist, ajouter des pistes à une playlist, et afficher les playlists qu'il a créées.
>- L'administrateur peut afficher toutes les playlists, et les pistes de chaque playlist.
>- Les utilisateurs connectés peuvent avoir accès à leurs différentes playlistes et pistes 
>- Les utilisateurs non connectés peuvent s'inscrire ou se connecter pour accéder aux fonctionnalités.
>- Les mots de passe sont stockés en base de données après chiffrement via password_hash()



### 📊 Données et Gestion des Utilisateurs

|Type | Détails|
|---|---|
|🔒 Sessions | Utilisées pour stocker la session utilisateur et les données relatives aux playlists|
| 📧 Authentification|Gestion des utilisateurs via la classe AuthnProvider, avec exception en cas d'erreur d'identification|
|👥 Authorization|Validation des droits d'accès pour afficher une playlist, via Authz::checkPlaylistOwner()|
|📦 Données Utilisateurs|Stockées dans la table `users` de la base de données|
|📦 Données Playlists|Stockées dans la table `playlists` de la base de données|
|📦 Données Pistes|Stockées dans la table `tracks` de la base de données|

> [!NOTE]
>-Un utilisateur lambda sera catégorié par le chiffre 1 tandis que l'administrateur sera catégorié par le chiffre 100
>-Ajout de la possibilité de se déconnecter pour plusieurs raison : 
- Sécurité
- Gestion des droits d'accès
- Facilité d'utilisation (notamment pour les tests)

### 🛠️ Compléments proposé 

- [x] Affichage d’une playlist et l’ajout d’une piste à une playlist est réservé au propriétaire de la
playlist ou au rôle ADMIN
- [x] Stockage adéquat des mot de passe, parades contre l’injection XSS et SQL
- [x] Code HTML généré valide
- [] Utilisation d’un framework css pour la mise en page
