<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class page_images extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'upload_images_id',
        'pages_id'

    ];

    public function page_images()
    {
        return $this->belongsTo('App\pages');
    }

    public function attachedPages(){
        return $this->belongsTo( 'App\pages', 'pages_id');
    }
    public function getImages(){
        return $this->belongsTo( 'App\UploadImages', 'upload_images_id');
    }
}
