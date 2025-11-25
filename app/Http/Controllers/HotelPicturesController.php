<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelPictures;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class HotelPicturesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Hotel $hotel)
    {

        $request->validate([
            'image' => ['required','image','mimes:jpeg,png,webp','max:4096'],
            'position'=>['required','integer', 'integer']
        ]);


        $fileSize=$request->file('image')->getSize()/1024 ; //kilo octet
        $imagePath= $request->file('image')->store('images','public');

        $picture=HotelPictures::create([
            'hotel_id'=>$hotel->id,
            'filepath'=>$imagePath,
            'filesize'=>$fileSize,
            'position'=>$request->position,
            'displayable'=>true
        ]);

        if(!$picture){
            Log::error("Echec de l'ajout de l'image à l'hotel",[
                'hotel_id'=>$hotel->id
            ]);
            return response()->json([
                'message'=>"Erreur lors de l'enrégistrement de l'image",
                'status'=>500
            ],500);
        }

        Log::info("Ajout de l'image éffectué avec succès!!");
        return response()->json([
            'message'=>'Enrégistrement de l image éffectué avec succes!!',
            'data'=> $picture,
            'status'=>201
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel,HotelPictures $picture)
    {
        Log::info("Tentative de mise à jour de l'image d'un hôtel ");

        if($picture->hotel_id!== $hotel->id){
            Log::error("L'image a supprimée n'appartient pas à l'hotel");
            return response()->json([
                'error'=>'This picture does not belong to this hotel'
            ],404);
        }

        $request->validate([
           'image'=>['required','image','mimes:jpeg,png,webp','max:4096'],
           'position'=>['required','integer', 'min:1']
         ]);

        //supprimer l'ancienne image si elle existe
        if($picture->filepath && Storage::disk('public')->exists($picture->filepath)){
            Storage::disk('public')->delete($picture->filepath);
            Log::info("Suppression de l'ancienne image réussie!!...");
        }


        $imagePath=$request->file('image')->store('images','public');
        $fileSize= $request->file('image')->getSize()/1024; //en k octet
        Log::info('Enrégistrement de la nouvelle image terminé');


        $picture->update([
            'filepath'=>$imagePath,
            'filesize'=>$fileSize,
            'position'=>$request->position,
            'displayable'=>true
        ]);

        Log::info('Modification de l image éffectuée avec succes!!!',['picture'=>$picture]);
        return  response()->json([
            'message'=>"Modification de l'image éffectuée avec succes!!",
            'data'=> $picture->fresh(),
        ],200);
    }

    /**
     * Endpoint pour réorganiser un ensemble de photo
     * @param Request $request
     * @param Hotel $hotel
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorder(Request $request, Hotel $hotel){

        $validated=$request->validate([
            'pictures' => ['required', 'array'],
            'pictures.*.id' => [
                'required',
                'integer',
                Rule::exists('hotel_pictures', 'id')->where('hotel_id', $hotel->id)
            ],
            'pictures.*.position' => ['required', 'integer', 'min:1'],
        ]);

        foreach($validated['pictures'] as $picture){
            HotelPictures::where('hotel_id',$hotel->id)
                ->where('id',$picture['id'])
                ->update(['position'=>$picture['position']]);
        }

        Log::info('Réorganisation des images dans un nouvel ordre éffectuée avec succes!!!');
        return response()->json([
            'message'=>'Réorganisation de la position des images éffectuée avec succès.',
            'status'=>200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel, HotelPictures $picture)
    {

        if($picture->hotel_id !== $hotel->id) return response()->json(['error'=>'Cette image n appartient pas à cet hôtel.']);

        if($picture->filepath && Storage::disk('public')->exists($picture->filepath)){
            Storage::disk('public')->delete($picture->filepath);
        }
        //suppresion de l'image
        $picture->delete();

        Log::info("Suppression de l'image de l'hotel éffectué avec succes!!!",['hotel_id'=>$hotel->id]);

        return response()->json(['message'=>'Suppression de l image éffectuée avec succès!!']);
    }
}
