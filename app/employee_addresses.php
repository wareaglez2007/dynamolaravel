<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_addresses extends Model
{
    public function addresses(){
        return $this->belongsTo( 'App\employees', 'employees_id');
    }
}
