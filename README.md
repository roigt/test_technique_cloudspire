

## Version Laravel 12 , PHP 8.2 
## Base de données MYSQL
### Lancer le projet
Le front et le back se lance avec les commandes ci-dessous 
J'ai utilisé inertia React Js de Laravel décrit dans sa documentation
```
  Installation en local
  A la racine du projet
  npm install (installer les dépendances du projet)
  php artisan migrate --seed
  composer run dev  ou en deux commandes (php artisan serve sur un terminal
   et sur un autre npm run dev)
    ensuite disponible sur http://localhost:8000/hotels
  
 ```

``` 
installation avec docker 
 lancer la commande docker-compose up -d --build
  ensuite disponible sur http://localhost:8000/hotels
```

Backend (Laravel)
  -Route (web.php) contenant les endpoints 
  -Controller
      -Pages (controlleurs d'affichage des pages React Js )
     -Controlleur de gestion des hotels et leurs images
  -Requests (gestion de la validation des champs)
  -Model (hotel et hotelPicture) 
  -factories (hotel et hotelPictures)
  -Eloquent pour les requêtes à la base de données
  -Base de données Mysql
     -table hotels
     -table hotel_pictures
  
  

Front (React Js + chackra ui, icons)
  -Pages
    -hotels (contenant les pages lier aux hôtels)
    -pictures (contenant les pages lier a la gestion des images des hôtels)
    -utils (fonction utiles pour les pages )
    -component ( composant des formulaires)
  -Requete asynchrone axios (get, post, patch, delete, etc...) au backend

