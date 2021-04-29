<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fileshandler extends Model
{
    protected $fillable = [
        'file_name',
        'extension',
        'storage_path',
        'file_size'
    ];



}
