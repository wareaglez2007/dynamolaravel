<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_locations extends Model
{
    public function employee_locations(){
        return $this->belongsToMany( 'App\employees', 'employees_id');
    }
}
