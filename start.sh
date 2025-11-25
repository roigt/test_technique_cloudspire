#!/bin/bash

echo "Démarrage du lancement de l application"
echo "Attendre la reponse de la base de donnees"
while ! nc -z db 3306; do
  sleep 1
done
echo "Base de données prêt!"

echo "Nettoyage du dossier images..."
rm -rf /var/www/public/storage/images/*

#créer le fichier .env
if [ ! -f .env ]; then
    echo "Creation du fichier .env ..."
    cp .env.example .env
    php artisan key:generate
fi

echo "Nettoyage du cache"
php artisan config:clear
php artisan view:clear
php artisan route:clear


echo "Lancement des migrations et des seeders ..."
php artisan migrate --force --seed

echo "Création de la table des sessions"
php artisan session:table

echo "Suppression de l'ancien lien si il existe et création d'un nouveau lien symbolique de stockage"
php artisan storage:unlink
php artisan storage:link

echo "Build assets"
npm run build

echo "Lancement du PHP-FPM..."
php-fpm

