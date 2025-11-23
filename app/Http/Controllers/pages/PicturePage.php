<?php

namespace App\Http\Controllers\pages;

use App\Helpers\ExceptionController;
use App\Http\Controllers\Controller;
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

       $nextPosition = ExceptionController::run(function() use($id){
           $maxPosition=HotelPictures::where('hotel_id', $id)
               ->max('position'); //trouver la position du dernier image
           return  $maxPosition? $maxPosition + 1 :1;//et l'incrémenter pour ajouter une nouvelle photo . Si on ne trouve rien on débute à 1
       },1);

        return Inertia::render('pictures/create', [
            'hotelId' => $id,
            'nextPosition' => $nextPosition,//on envoie l index de position ou ajouter la nouvelle image
       ]);
   }

   public function update($id,$pictureId){
       $image= HotelPictures::find($pictureId);

       return Inertia::render('pictures/update', [
           'hotelId' => $id,
           'pictureId' => $pictureId,
           'image' => $image,
       ]);
   }
}
