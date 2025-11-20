# Roadmap V2

- cree les table
- formulaire pour ce connecter
- cree un groupe et met le user1 en admin
- partager le groupe a un autre user via url
- le user rejoint le groupe
- les deux user envoie une image via formulaire : [**VichUploaderBundle**](https://github.com/dustin10/VichUploaderBundle)
- stocke coter serveur ( path en BDD, image ne local serveur)
- emit un event mercure
- un client ce connecte sur /projecteur
- recois levent mercure sur le client proj
- affiche l’image qui vient detre ajouter

````mairmaid
erDiagram
    User {
        int user_id PK "Clé primaire"
        varchar(255) email "Email unique pour la connexion"
        varchar(255) password_hash "Mot de passe haché"
        varchar(100) first_name "Prénom"
        varchar(100) last_name "Nom"
        varchar(50) role "Rôle de l'utilisateur (ex: 'user', 'admin')"
        datetime created_at "Date de création"
    }

  

    user-groups{
        int id PK "Clé primaire"
        int user_id "User in group"
        int group_id "group id"
        int role ""
        datetime created_at "Date de création"
    }

    groups{
        int id PK "Clé primaire"
        int token "Clé unique"
        text name
        datetime created_at "Date de création"
        varchar(255) url_image_logo1
        varchar(255) url_image_logo2
        tinyint administration_before
    }

    photos {
        int photo_id PK "Clé primaire"
        int group_id
        text media
        varchar(255) commentary
        tinyint is_allowed
        tinyint is_waiting
        datetime created_at "Date de création"
    }

    %% Définition des relations
    groups ||--o{ photos : "many to many"
    User ||--o{ user-groups : "one to many"
    user-groups ||--o{ groups : "many to many"
````

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
php bin/console tailwind:build


tips :
tailwind :
- download v3.4.18 of tailwind : https://github.com/tailwindlabs/tailwindcss/releases
- replace existing file in /var/tailwind/{version}/tailwindcss-windows-x64.exe by the DL file
- exec : php bin/console tailwind:build


