<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class location_hours extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'locations_id',
        'days',
        'hours_from',
        'hours_to'

    ];
    public function LocationsHours(){
        return $this->belongsTo( 'App\locations', 'locations_id');
    }
}
