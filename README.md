lancer les commandes suivantes:

npm i
composer i
npm run dev
php artisan key:generate

modifier le fichier .env.exemple en .env
creer dans la base de donner un table du nom auth_app_db
puis modifier
    DB_DATABASE=auth_app_db
    DB_USERNAME=root
    DB_PASSWORD=root

puis lancer la commande suivante
    php artisan migrate
    php artisan serve

Enfin creer un compte
