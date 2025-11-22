<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HotelPicturesController;
use App\Models\Hotel;
use App\Models\HotelPictures;
use Inertia\Inertia;

class PicturePage extends  Controller
{

    public function index($id){
        $pictures = HotelPictures::where('hotel_id', $id)
            ->orderBy('position', 'asc')//recupérer les images selon leurs position croissant
            ->get();

        return Inertia::render('pictures/index', [
            'pictures' =>$pictures,
            'hotelId' => $id
        ]);
    }

   public function create($id){
        $maxPosition = HotelPictures::where('hotel_id', $id)
            ->max('position');
        $nextPosition = $maxPosition? $maxPosition + 1 :1;

        return Inertia::render('pictures/create', [
            'hotelId' => $id,
            'nextPosition' => $nextPosition,//on envoie l index de position ou ajouter la nouvelle image
       ]);
   }

   public function update($id,$pictureId){
       $image= HotelPictures::findOrFail($pictureId);

       return Inertia::render('pictures/update', [
           'hotelId' => $id,
           'pictureId' => $pictureId,
           'image' => $image,
       ]);
   }
}
