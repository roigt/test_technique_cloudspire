<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelPictures;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class HotelPicturesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HotelPictures::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('test_image',['hotels'=>Hotel::all()]);
    }

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
        ]);

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

        if($picture->hotel_id!== $hotel->id){
            return response()->json([
                'error'=>'This picture does not belong to this hotel'
            ],404);
        }

        $validated=$request->validate([
           'image'=>['required','image','mimes:jpeg,png,webp','max:4096'],
           'position'=>['required','integer', 'min:1']
         ]);

        //supprimer l'ancienne image si elle existe
        if($picture->filepath && Storage::disk('public')->exists($picture->filepath)){
            Storage::disk('public')->delete($picture->filepath);
        }

        $imagePath=$request->file('image')->store('images','public');
        $fileSize= $request->file('image')->getSize()/1024; //en k octet


        $picture->update([
            'filepath'=>$imagePath,
            'filesize'=>$fileSize,
            'position'=>$request->position,
        ]);

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

        $picture->delete();
        return response()->json(['message'=>'Suppression de l image éffectuée avec succès!!']);
    }
}
