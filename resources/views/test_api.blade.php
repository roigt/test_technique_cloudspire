<form action="/api/hotels" method="POST">
    @csrf
    <!-- Nom de l'hôtel -->
    <label for="name">Nom de l'hôtel :</label>
    <input type="text" id="name" name="name" value="Annabel Graham" required maxlength="255">
    <br><br>

    <!-- Adresse 1 -->
    <label for="address1">Adresse 1 :</label>
    <input type="text" id="address1" name="address1" value="309 Marvin Forges Suite 652
Danielmouth, FL 08464-5939" required maxlength="255">

    <br><br>

    <!-- Adresse 2 -->
    <label for="address2">Adresse 2 :</label>
    <input type="text" id="address2" name="address2" value="25306 Prosacco Isle
North Dexter, MS 24457-7855" maxlength="255">
    <br><br>

    <!-- Code postal -->
    <label for="zipcode">Code postal :</label>
    <input type="text" id="zipcode" name="zipcode" value="07439" required maxlength="20">
    <br><br>

    <!-- Ville -->
    <label for="city">Ville :</label>
    <input type="text" id="city" name="city" value="Port Lysannefort" required maxlength="100">
    <br><br>

    <!-- Pays -->
    <label for="country">Pays :</label>
    <input type="text" id="country" name="country" value="Gambia" required maxlength="100">
    <br><br>

    <!-- Longitude -->
    <label for="lng">Longitude :</label>
    <input type="number" id="lng" name="lng" value="122.765964" step="0.000001" required>
    <br><br>

    <!-- Latitude -->
    <label for="lat">Latitude :</label>
    <input type="number" id="lat" name="lat" value="6.937766" step="0.000001" required>
    <br><br>

    <!-- Description -->
    <label for="description">Description :</label>
    <textarea id="description" name="description" rows="5" maxlength="5000">
Pariatur quis sit occaecati atque. Qui necessitatibus reprehenderit consectetur perferendis ratione. Voluptate vel et architecto iure vero. Qui sint ut vero provident impedit blanditiis voluptatem.
  </textarea>
    <br><br>

    <!-- Capacité maximale -->
    <label for="max_capacity">Capacité maximale :</label>
    <input type="number" id="max_capacity" name="max_capacity" value="83" min="1" max="200" required>
    <br><br>

    <!-- Prix par nuit -->
    <label for="price_per_night">Prix par nuit :</label>
    <input type="number" id="price_per_night" name="price_per_night" value="20" step="0.01" min="0" required>
    <br><br>

    <label for="photo">Choisir une photo :</label>
    <input type="file" id="photo" name="filepath" accept="image/*" required>
    <br><br>

    <button type="submit">Envoyer</button>
</form>

