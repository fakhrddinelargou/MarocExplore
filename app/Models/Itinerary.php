<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Destination;
use App\Models\User;


class Itinerary extends Model
{
    public function destinations(){
        return $this->hasMany(Destination::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
