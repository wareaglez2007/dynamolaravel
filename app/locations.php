<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class locations extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'location_name',
        'street',
        'street2',
        'city',
        'state',
        'county',
        'postal'

    ];
    public function location_hours()
    {
        return $this->hasMany('App\location_hours');
    }

    public function location_contacts()
    {
        return $this->hasMany('App\locationContacts');
    }

    public function employees_per_location()
    {
        return $this->belongsToMany('App\employees', 'App\employee_locations', 'employees_id', 'locations_id');
    }
}

