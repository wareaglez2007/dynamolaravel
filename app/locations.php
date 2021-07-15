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

}

