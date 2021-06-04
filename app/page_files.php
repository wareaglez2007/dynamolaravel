<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class page_files extends Model
{
    protected $fillable = [
        'file',
        'fileshandlers_id',
        'pages_id'
    ];


    public function page_images()
    {
        return $this->belongsTo('App\pages');
    }

    public function attachedFiles(){
        return $this->belongsTo( 'App\pages', 'pages_id');
    }

    public function getFiles(){
        return $this->belongsTo( 'App\fileshandler', 'fileshandlers_id')->where('extension','html');
    }
}
