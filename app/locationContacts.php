<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class locationContacts extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'locations_id',
        'phone',
        'enail',
        'maps_url'

    ];
    public function LocationsContact(){
        return $this->belongsTo( 'App\locations', 'locations_id');
    }
}
