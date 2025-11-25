<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\HotelPictures;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class HotelControllerTest extends TestCase
{

    /**
     * @return void
     * tester la pagination
     */
    public function test_pagination_hotels_index(): void
    {
        Hotel::factory(10)->create();

        $response = $this->get('/hotels');
        $response->assertStatus(200);

        //tester les filtres de requête
        $response =$this->getJson('/api/hotels?per_page=3');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'last_page',
                'current_page',
                'per_page',
                ]);
        //verifier que l'on a récupérer 3 hotels
        $this->assertCount(3, $response->json()['data']);



    }

    /**
     * @return void
     * tester les filtres sur une liste des hôtels
     */
    public function test_filters_hotels_by_name_or_city_index(): void
    {
        Hotel::factory()->create([
            'name'=>'Le paradis',
            'address1'=>'address1',
            'address2'=>'address2',
            'zipcode'=>'23546',
            'city'=>'Lyon',
            'country'=>'FRANCE',
            'lng'=>'23.33',
            'lat'=>'53.33',
            'description' => 'Le paradis un hôtel paradisiaque cinq étoiles',
            'max_capacity'=>200,
            'price_per_night'=>200,
        ]);

        Hotel::factory()->create([
            'name'=>'Le jardin des Marais',
            'address1'=>'Jean jaures 23',
            'address2'=>'Haute ',
            'zipcode'=>'2346',
            'city'=>'Paris',
            'country'=>'FRANCE',
            'lng'=>'152.38',
            'lat'=>'43.32',
            'description' => 'Le paradis un hôtel paradisiaque cinq étoiles',
            'max_capacity'=>250,
            'price_per_night'=>220,
        ]);

        //On fait une requête avec un filtre sur le nom de l'hôtel ou la ville (city)
        $response=$this->getJson('/api/hotels?q=paris');

        //On vérifie que la requete a réussie
        $response->assertStatus(200);
        //On vérifie que l'on un seul hôtel retourné celui qui respecte le filtre
        $this->assertCount(1, $response->json()['data']);

        //On s'assure que l'hôtel récupérer est l'hôtel qui a pour caractéristique city=Paris
        $this->assertEquals('Paris', $response->json()['data'][0]['city']);

    }

    /**
     * @return void
     * test le tri des hôtels par nom de manière croissante
     */
    public function test_sort_hotels_by_name_asc(): void
    {
        Hotel::factory()->create([
            'name'=>'Alysee',
            'address1'=>'address1',
            'address2'=>'address2',
            'zipcode'=>'23546',
            'city'=>'Lyon',
            'country'=>'FRANCE',
            'lng'=>'23.33',
            'lat'=>'53.33',
            'description' => 'Le paradis un hôtel paradisiaque cinq étoiles',
            'max_capacity'=>200,
            'price_per_night'=>200,
        ]);

        Hotel::factory()->create([
            'name'=>'Bel Azur',
            'address1'=>'address1',
            'address2'=>'address2',
            'zipcode'=>'23546',
            'city'=>'Lyon',
            'country'=>'FRANCE',
            'lng'=>'23.33',
            'lat'=>'53.33',
            'description' => 'Le paradis un hôtel paradisiaque cinq étoiles',
            'max_capacity'=>200,
            'price_per_night'=>200,
        ]);

        //On fait une requête pour récupérer les hotels ordonnés selon leurs noms de manière croissante( A>B...>Z)
        $response = $this->getJson('/api/hotels?sort=name&order=asc');
        $data=$response->json('data');

        //On s'assure que le premier élément récupérer à le nom A et ensuite B (A>B)
        $this->assertEquals('Alysee', $data[0]['name']);
        $this->assertEquals('Bel Azur', $data[1]['name']);
    }


    /**
     * @return void
     * Tester l'ajout d'une image à un hôtels
     */
    public function test_hotels_pictures_exist_index(){
       $hotel = Hotel::factory()->create();
       HotelPictures::factory()->create([
           'hotel_id'=>$hotel->id,
           'filepath'=>'images/test_image.jpg',
       ]);

       $response = $this->getJson('/api/hotels');
       $response->assertStatus(200)
           ->assertJsonStructure([
               'data'=>[
                   [
                       'pictures'
                   ]
               ]
           ]);
       dump($response->json('data'));

       $this->assertCount(1,$response->json('data')[0]['pictures']);
    }


    public function test_hotels_creation_store(): void
    {
        //avant la table des hôtels est vide
        $response= $this->get('/api/hotels');
        $this->assertCount(0, $response->json('data'));


        $response=$this->post('/api/hotels',[
            'name'=>'Bel Azur',
            'address1'=>'address1',
            'address2'=>'address2',
            'zipcode'=>'23546',
            'city'=>'Lyon',
            'country'=>'FRANCE',
            'lng'=>'23.33',
            'lat'=>'53.33',
            'description' => 'Le paradis un hôtel paradisiaque cinq étoiles',
            'max_capacity'=>200,
            'price_per_night'=>200,
        ]);

        //la table contient un enrégistrement
        $this->assertEquals(201,$response->status());
        $response= $this->get('/api/hotels');
        $this->assertCount(1,$response->json('data'));

    }

    public function test_show_hotel_show(): void
    {
        //créer un hôtel test
        $hotel_test=Hotel::factory()->create();

        //Essayer de récupérer l'hôtel avec son id
        $response = $this->get("/api/hotels/{$hotel_test->id}");
        $response->assertStatus(200);

        //vérifie si l'hôtel créer est également celui récupérer
        $this->assertEquals($hotel_test->jsonSerialize(),$response->json());

    }

    public function test_upadate_hotel_update(): void
    {
        $hotel = Hotel::factory()->create();
        //Modification des information d'un hôtel
        $response=$this->put("/api/hotels/{$hotel->id}",[
            'name'=>'Bel Azur',
            'address1'=>'address1',
            'address2'=>'address2',
            'zipcode'=>'23546',
            'city'=>'Lyon',
            'country'=>'FRANCE',
            'lng'=>'23.33',
            'lat'=>'53.33',
            'description' => 'Le paradis un hôtel paradisiaque cinq étoiles',
            'max_capacity'=>200,
            'price_per_night'=>200,
        ]);

        $response->assertStatus(200);

        $this->assertEquals('Hôtel modifié avec succès!!',$response->json());

        //vérifier si le nouveau nom de l'hôtel correspond au changement attendu
        $this->assertEquals('Bel Azur',$this->get("/api/hotels/{$hotel->id}")->json()['name']);
    }


    public function test_delete_hotel_delete(): void
    {
        //On crée un hôtel en base de données
        $hotel = Hotel::factory()->create();
        $response=$this->get("/api/hotels/")->assertStatus(200);

        //On vérifie maintenant le nombre d'hôtels en base de données
        $this->assertCount(1,$response->json('data'));

        //On supprime l'hôtel créé
        $result=$this->delete("/api/hotels/{$hotel->id}")->assertStatus(200);
        assertEquals('Hôtel supprimé avec succès!!',$result->json());

        //On vérifie que l'on a plus d'hôtel en base de données
        $response=$this->get("/api/hotels");
        $this->assertCount(0,$response->json('data'));
    }

}

