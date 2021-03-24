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
        return $this->belongsTo('App\pages')->where('active', 1)->orderBy('position', 'ASC');
    }



    public function parent(){

        return $this->hasOne(children::class, 'pages_id')->where('active', 1)->orderBy('position', 'ASC');
    }
    public function child()
    {
        return $this->hasMany(children::class, 'parent')->with('parent')->where('active', 1)->orderBy('position', 'ASC');
    }

    /**
     * Get the slug associated with page.
     */
}
