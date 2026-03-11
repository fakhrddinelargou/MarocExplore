<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Itinerarie;
use App\Models\User;

class Destination extends Model
{
    
    public function itinerarie(){
        return $this->hasMany(itinerarie::class);
    }

}
