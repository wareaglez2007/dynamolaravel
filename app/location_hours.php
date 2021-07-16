<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class location_hours extends Model
{
    public function LocationsHours(){
        return $this->belongsTo( 'App\locations', 'locations_id');
    }
}
