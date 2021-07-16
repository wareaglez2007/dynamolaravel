<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hoursdays extends Model
{
    //

    public static function getDays()
    {
        $instance = new static;
        return $instance->get('week_days');
    }

    public static function getHours()
    {
        $instance = new static;
        return $instance->get('hours');
    }
}
