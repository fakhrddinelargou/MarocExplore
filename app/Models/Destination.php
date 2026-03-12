<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Itinerary;
// use App\Models\User;

class Destination extends Model
{

    protected $fillable = [
        'itinerary_id',
        'name',
        'location',
        'activities'
    ];


    public function itinerarie()
    {
        return $this->hasMany(itinerary::class);
    }

}
