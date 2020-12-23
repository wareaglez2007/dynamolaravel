<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class slugs extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'pages_id',

    ];

    /**
     * Get the pages that owns the slug.
     */
    public function pages()
    {
        return $this->belongsTo('App\pages');
    }
}
