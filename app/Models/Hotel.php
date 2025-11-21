<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    /** @use HasFactory<\Database\Factories\HotelFactory> */
    use HasFactory;
    protected $fillable = ['name','address1','address2','zipcode','city','country','lng','description','lat','max_capacity','price_per_night'];

    public function pictures(){
        return $this->hasMany(HotelPictures::class);
    }
}
