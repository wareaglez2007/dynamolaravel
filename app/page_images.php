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
}
