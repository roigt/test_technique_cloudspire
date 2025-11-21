<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Inertia\Inertia;
use Inertia\Response;

class HotelPage extends Controller
{
    /**
     * Show the profile for a given user.
     */
    public function index()
    {

        return Inertia::render('index', [
            'hotels'=> Hotel::with('pictures')->get()
            ->map(function($hotel){
                return [
                    'id' => $hotel->id,
                    'name' => $hotel->name,
                    'city' => $hotel->city,
                    'description' => $hotel->description,
                    'max_capacity' => $hotel->max_capacity,
                    'firstPictures' => $hotel->pictures->first()
                        ? asset('storage/'.$hotel->pictures->first()->filepath)
                        : null,
                ];
            })
        ]);
    }

    public function show($id){
        $hotel = Hotel::with('pictures')->findOrFail($id);
        return Inertia::render('detail', [
            'hotel' => $hotel
        ]);
    }

    public function create(){
        return Inertia::render('create');
    }

    public function update($id){
        $hotel = Hotel::with('pictures')->findOrFail($id);
        return Inertia::render('update', ['hotel'=>$hotel]);
    }
}
