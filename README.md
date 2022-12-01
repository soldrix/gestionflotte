lancer les commandes suivantes:

npm i </br>
composer i </br>
npm run dev </br>
php artisan key:generate </br>
modifier le fichier .env.exemple en .env </br>
creer dans la base de donner un table du nom auth_app_db </br>
puis modifier </br>
    DB_PORT=8889   port du server sql </br>
    DB_DATABASE=app_auth_db nom de la base de donner </br>
    DB_USERNAME=root utilisateur de base  </br>
    DB_PASSWORD=root    mot de passe de base </br>
</br>
puis lancer la commande suivante </br>
    php artisan migrate </br>
    php artisan storage:link </br>
    php artisan serve </br>

Enfin creer un compte </br>
