<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_resumes extends Model
{
    public function resumes(){
        return $this->belongsTo( 'App\employees', 'employees_id');
    }
}
