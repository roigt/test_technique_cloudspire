<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class HotelController extends Controller
{
    /**
     * Endpoint qui retourne la liste des hôtels en fonction des filtres de requêtes
     */
    public function index(Request $request)
    {
        //logger la requête reçu
        Log::info('Appel de Hotel index()',[
            'paramètre'=>$request->all()
        ]);

        $query=Hotel::with('pictures')->latest();

        //filtre par q sur name ou city
        if($request->filled('q')){
            $q=$request->input('q');

            $byName = Hotel::where('name', 'like','%'. $q . '%');
            $byCity = Hotel::where('city', 'like','%'. $q . '%');

            $query = $byName->union($byCity)->with('pictures');
        }

        //Tri selon le nom et l'ordre croissant
        $sort= $request->input('sort','name');
        $order= $request->input('order','asc');

        //verifier que la colonne existe
        if(in_array($sort,['name','city','price_per_night','max_capacity','created_at'])){
            $query->orderBy($sort,$order);
        }else{
            Log::warning("Column invalide a trié:{$sort}");
        }

        //pagination
        $perPage=$request->input('per_page',5);
        $hotels=$query->paginate($perPage);

        Log::info('Les hôtels trouvés',[
            'nombre'=>$hotels->count(),
            'total'=>$hotels->total(),
        ]);
        return response()->json($hotels);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(HotelRequest $request)
    {
        $request->validated();

       $hotel=Hotel::create([
           'name'=>$request->input('name'),
           'address1'=>$request->input('address1'),
           'address2'=>$request->input('address2'),
           'zipcode'=>$request->input('zipcode'),
           'city'=>$request->input('city'),
           'country'=>$request->input('country'),
           'lng'=>$request->input('lng'),
           'lat'=>$request->input('lat'),
           'max_capacity'=>$request->input('max_capacity'),
           'description'=>$request->input('description'),
           'price_per_night'=>$request->input('price_per_night'),
       ]);

       Log::info(" Ajout d'un hotel terminé avec succès !!",['hotel_id',$hotel->id]);

       return response()->json('Hôtel créer avec succès',201);
    }

    /**
     * Endpoint qui retourne un hôtel grâce à son id
     */
    public function show(Hotel $hotel)
    {
        return response()->json($hotel);
    }


    /**
     * Endpoint qui permet de modifier les informations d'un hôtel
     */
    public function update(HotelRequest $request, Hotel $hotel)
    {
        $request->validated();

        $hotel->update([
            'name'=>$request->input('name'),
            'address1'=>$request->input('address1'),
            'address2'=>$request->input('address2'),
            'zipcode'=>$request->input('zipcode'),
            'city'=>$request->input('city'),
            'country'=>$request->input('country'),
            'lng'=>$request->input('lng'),
            'lat'=>$request->input('lat'),
            'max_capacity'=>$request->input('max_capacity'),
            'description'=>$request->input('description'),
            'price_per_night'=>$request->input('price_per_night'),
        ]);

        Log::info("Modification de l'hôtel éffectuée avec succès", ['hotel_id'=>$hotel->id]);
        return response()->json('Hôtel modifié avec succès!!',200);
    }

    /**
     * Endpoint pour supprimer un hôtel
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        Log::info("Suppression de l'hôtel réussie!!",['hotel_id'=>$hotel->id]);

        return response()->json('Hôtel supprimé avec succès!!',200);
    }
}
