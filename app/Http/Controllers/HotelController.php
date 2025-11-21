<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=Hotel::query();

        //filtre par q sur name ou city
        if($request->filled('q')){
            $q=$request->input('q');
            $query->where('name','like',"%{$q}%")
                  ->orWhere('city','like',"%{$q}%");
        }

        //Tri selon le nom et l'ordre croissant
        $sort= $request->input('sort','name');
        $order= $request->input('order','asc');

        //verifier que la colonne existe
        if(in_array($sort,['name','city','price_per_night','max_capacity','created_at'])){
            $query->orderBy($sort,$order);
        }

        //pagination
        $perPage=$request->input('per_page',10);
        $hotels=$query->paginate($perPage);

        return response()->json($hotels);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HotelRequest $request)
    {
       $request->validated();
       Hotel::create([
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
       return response()->json('created',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        return response()->json($hotel);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HotelRequest $request, Hotel $hotel)
    {
        $data=$request->validated();

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
        return response()->json('updated successfully!!',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return response()->json('deleted successfully!!',204);
    }
}
