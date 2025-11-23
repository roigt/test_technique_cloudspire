#!/bin/bash

echo "Démarrage du lancement de l application"
echo "Attendre la reponse de la base de donnees"
while ! nc -z db 3306; do
  sleep 1
done
echo "Base de données prêt!"

#créer le fichier .env
if [ ! -f .env ]; then
    echo "Creation du fichier .env ..."
    cp .env.example .env
    php artisan key:generate
fi

echo "Nettoyage du cache"
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "Installation des dépendances PHP"
composer install --no-interaction --optimize-autoloader

echo "Construction des assets"
npm run build


echo "Lancement des migrations et des seeders ..."
php artisan migrate --force --seed
php artisan db:seed

echo "Création de la table des sessions"
php artisan session:table
php artisan migrate --force

if [ "$APP_ENV" = "production" ]; then
    echo "Optimisation ..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "Création du lien symbolique de stockage"
php artisan storage:link

chown -R www-data:www-data /var/www
chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/database

echo "Lancement du PHP-FPM..."
php-fpm
