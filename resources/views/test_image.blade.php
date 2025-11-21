@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/api/hotels/14/pictures/13" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Upload de fichier -->
    <label for="photo">Choisir une photo :</label>
    <input type="file" id="image" name="image" accept="image/*" required>
    <div>@error('image') {{$message}}  @enderror</div>
    <br><br>

    <!-- Position de la photo -->
    <label for="position">Position :</label>
    <input type="number" id="position" name="position" value="1" min="1" required>
    <div>@error('position') {{$message}}  @enderror</div>
    <br><br>

    <button type="submit">Envoyer</button>
</form>
