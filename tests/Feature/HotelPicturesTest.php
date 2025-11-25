<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\HotelPictures;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HotelPicturesTest extends TestCase
{

    /**
     * @return void
     * Ajout d'une image d'un hôtel en base de données
     */
    public function test_store_picture_in_bd_store():void
    {

        //On crée un hôtel
        $hotel = Hotel::factory()->create();

        //on crée un fichier image fake
        $fakeImage= UploadedFile::fake()->image('test_image.jpg');

        //On crée trois images et on ajoute à l'hôtel
        $images =$this->post("/api/hotels/{$hotel->id}/pictures",[
            'image'=>$fakeImage,
            'position'=>1
        ]);

        $images->assertStatus(200);
        $this->assertEquals('Enrégistrement de l image éffectué avec succes!!',$images->json()['message']);
        //On vérifie si l'image est bien enrégistrée en BD
        $this->assertDatabaseHas('hotel_pictures',[
            'hotel_id'=>$hotel->id,
            'position'=>1
        ]);

        //on Vérifie si l'image est bien stocké dans le dossier public/storage/images
        Storage::disk('public')->assertExists('images/'. $fakeImage->hashName());
    }

    public function test_update_picture_in_bd_update():void
    {
        //On crée un faux hôtel pour le test
        $hotel = Hotel::factory()->create();

        $fakeImage= UploadedFile::fake()->image('test_image.jpg');

        $images =$this->post("/api/hotels/{$hotel->id}/pictures",[
            'image'=>$fakeImage,
            'position'=>1
        ]);
        //On vérifie si la requête a réussie
        $images->assertStatus(200);
        //On vérifie que l'on reçoit bien le message de confirmation d'enrégistrement attendu
        $this->assertEquals('Enrégistrement de l image éffectué avec succes!!',$images->json()['message']);

        //On recrée une fausse image pour tester la modification
        $fakeImageForUpdate =UploadedFile::fake()->image('test_updated_image.jpg');

        //On modifie l'image enrégistrée précédemment
        $images_updated =$this->post("/api/hotels/{$hotel->id}/pictures/{$images->json('data')['id']}",[
            'image'=>$fakeImageForUpdate,
            'position'=>3
        ]);

        //On vérifie que la modification à réussie
        $images_updated->assertStatus(200);
        $this->assertEquals("Modification de l'image éffectuée avec succes!!",$images_updated->json()['message']);
        //on vérifie que la base de données à les nouvelles valeurs
        $this->assertDatabaseHas('hotel_pictures',[
            'hotel_id'=>$hotel->id,
            'position'=>3
        ]);

        //On vérifie si la nouvelle image a bien été enrégistrée
        Storage::disk('public')->assertExists('images/'. $fakeImageForUpdate->hashName());

        //On vérifie si l'ancienne image n'existe plus dans le dossier des images
        Storage::disk('public')->assertMissing('images/'. $fakeImage->hashName());

    }


    public function test_destroy_picture_in_bd_destroy():void
    {
        //On crée un hotel
        $hotel = Hotel::factory()->create();
        //On crée une fausse image pour le test
        $fakeImage= UploadedFile::fake()->image('test_image.jpg');

        //On enrégistre l'image dans la table hotel_picture avec la position 1
        $images =$this->post("/api/hotels/{$hotel->id}/pictures",[
            'image'=>$fakeImage,
            'position'=>1
        ]);
        //On vérifie si la requête a réussie
        $images->assertStatus(200);
        //On vérifie que la table hôtel picture contient bien l'image uploadé avec la position 1
        $this->assertDatabaseHas('hotel_pictures',[
            'hotel_id'=>$hotel->id,
            'position'=>1
        ]);

        //On vérifie le nombre d'enrégistrement dans la table hotel_pictures
        $this->assertCount(1, HotelPictures::all());
        //On vérifie également si l' image est bien enrégistrer dans le dossier public/storage/images
        Storage::disk('public')->assertExists('images/'. $fakeImage->hashName());

        //Après suppression on vérifie que la table hotel_pictures ne contient plus aucune image
        //On vérifie également que l'image a été supprimé dans le dossier public/storage/images
        $this->delete("/api/hotels/{$hotel->id}/pictures/{$images->json('data')['id']}");
        Storage::disk('public')->assertMissing('images/'. $fakeImage->hashName());
        $this->assertCount(0, HotelPictures::all());

    }

}
