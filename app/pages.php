<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class pages extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'owner',
        'parent_id',
        'active',
        'position'

    ];
    protected $guarded = [];
    /**
     * Get the slug associated with page.
     */
    public function slug()
    {
        return $this->hasOne('App\slugs');
    }
    public function items()
    {

        return $this->hasMany(pages::class, 'parent_id')->where('active', 1)->orderBy('position', 'ASC');
    }
    public function childItems()
    {
        return $this->hasMany(pages::class, 'parent_id')->with('childItems')->where('active', 1)->orderBy('position', 'ASC');
    }

    /**
     * get the parent of a page
     */
    public function parent(){

        return $this->belongsTo(pages::class, 'parent_id')->with('parent')->where('active', 1)->orderBy('position', 'ASC');
    }
}
