<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Inertia\Inertia;


class HotelPage extends Controller
{
    /**
     * Afficher la page d'affichage d'hôtel sous forme tableai
     */
    public function index(){
        return Inertia::render('hotels/home');
    }

    /**
     * Affichage des détails d'un hôtel
     * @param $id
     * @return \Inertia\Response
     */
    public function show($id){
        $hotel = Hotel::with('pictures')->findOrFail($id);
        return Inertia::render('hotels/detail', [
            'hotel' => $hotel
        ]);
    }

    /**
     * Afficher le formulaire de création d'un hôtel
     * @return \Inertia\Response
     */
    public function create(){
        return Inertia::render('hotels/create');
    }

    /**
     * Afficher le formulaire de modification d 'un hotel
     * @param $id
     * @return \Inertia\Response
     */
    public function update($id){
        $hotel = Hotel::with('pictures')->findOrFail($id);
        return Inertia::render('hotels/update', ['hotel'=>$hotel]);
    }
}
