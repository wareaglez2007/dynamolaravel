<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    


    public function employee_address()
    {
        return $this->hasMany('App\employee_addresses');
    }

    public function employee_contacts()
    {
        return $this->hasMany('App\employee_contacts');
    }
    public function employee_resumes()
    {
        return $this->hasMany('App\employee_resumes');
    }

    public function employee_locations()
    {
        return $this->hasMany('App\employee_locations');
    }

}
