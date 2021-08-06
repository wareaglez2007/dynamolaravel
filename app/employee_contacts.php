<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_contacts extends Model
{
    public function contacts(){
        return $this->belongsTo( 'App\employees', 'employees_id');
    }
}
