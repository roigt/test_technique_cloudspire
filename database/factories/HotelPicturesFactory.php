<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HotelPictures>
 */
class HotelPicturesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $testImages = Storage::disk('public')->files('/seeding-images');

        if(empty($testImages))throw new \Exception("Aucune image trouvée dans le dossier storage/app/public/seeding-images");

        //sélectionner une image au hasard
        $selectRandomImage = $this->faker->randomElement($testImages);

        //générer un nom unique pour l image
        $filename =Str::uuid().'.webp';
        $filepath='images/'.$filename;

        //rezize l'image et le charger
        $manager = new ImageManager(new GdDriver());

        $image= $manager
            ->read(Storage::disk('public')->path($selectRandomImage))
            ->cover(600, 600)
            ->toWebp(80);

        Storage::disk('public')->put($filepath, (string) $image);


        return [
            'hotel_id' =>Hotel::factory(),
            'filepath' => $filepath,
            'filesize' => Storage::disk('public')->size($filepath),
            'position' => 1,
            'displayable'=>true
        ];
    }
}
