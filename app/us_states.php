<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class us_states extends Model
{
    public static function getStates()
    {
        $instance = new static;
        return $instance->get();
    }
}
