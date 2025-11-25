<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelPictures extends Model
{
    /** @use HasFactory<\Database\Factories\HotelPicturesFactory> */
    use HasFactory;

    protected $fillable=['hotel_id','filepath','filesize','position','displayable'];

    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }
}
