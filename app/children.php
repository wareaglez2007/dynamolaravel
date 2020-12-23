<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class children extends Model
{



    protected $fillable = [
        'pages_id',
        'parent'
    ];

    protected $guarded = [];
    /**
     * Get the pages that owns the child.
     */
    public function pages()
    {
        return $this->belongsTo('App\pages');
    }



    public function parent(){

        return $this->hasOne(children::class, 'pages_id');
    }
    public function child()
    {
        return $this->hasMany(children::class, 'parent')->with('parent');
    }

    /**
     * Get the slug associated with page.
     */
}
