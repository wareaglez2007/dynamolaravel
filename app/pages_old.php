<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pages extends Model
{

    use SoftDeletes;
    protected $fillable = [
        // 'published',
        'title',
        'subtitle',
        'content',
        'owner',
        'publish_start_date',
        'active'
        //   'publish_start_date',
        //   'publish_end_date'
    ];
    protected $guarded = [];



    /**
     * Get the slug associated with page.
     */
    public function slug()
    {
        return $this->hasOne('App\slugs');
    }
    /**
     * Get all the children of a parent
     */
    public  function child()
    {
        return $this->hasMany('App\children',  'parent')->with('parent');
    }
    /**
     * get the parent of a page
     */
    public function parent(){

        return $this->hasMany('App\children', 'pages_id');
    }



}
