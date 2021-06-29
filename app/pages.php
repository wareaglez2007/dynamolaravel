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

    public function page_images()
    {
        return $this->hasMany('App\page_images');
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
    public function parent()
    {

        return $this->belongsTo(pages::class, 'parent_id')->with('parent')->where('active', 1)->orderBy('position', 'ASC');
    }


    public function imageforpages()
    {
        return $this->belongsToMany('App\UploadImages', 'App\page_images', 'pages_id', 'upload_images_id');
    }

    public function fileforpages()
    {
        return $this->belongsToMany('App\fileshandler', 'App\page_files', 'pages_id', 'fileshandlers_id');
    }

    /**
     * *********************************************
     * COUNT SECTION
     * *********************************************
     */

    /**
     * This function will return the count of published pages
     * $publish_page_count = $pages->where('active', 1)->count();
     * @return count numeric
     */
    public function GetPublishedPagesCount()
    {
        return $this->where('active', 1)->count();
    }


    /**
     * This function will return the count of trashed pages
     * $trashed_page_count = $pages->onlyTrashed()->count();
     * @return count numeric
     */
    public function GetTrashedPagesCount()
    {
        return $this->onlyTrashed()->count();
    }

    /**
     * This function will return the count for draft pages
     * $draft_pages_count = $pages->where('pages.active', 0)->count();
     * @return count numeric
     */
    public function GetDraftPagesCount()
    {
        return $this->where('pages.active', 0)->count();
    }

    /**
     * this function will return count for all pages (active, draft and trashed)
     * $all_pages_count = $pages->withTrashed()->count();
     * @return count numeric
     */
    public function GetCountForAllPages()
    {
        return $this->withTrashed()->count();
    }

    /**
     * *********************************************
     * DATA RETURN SECTION
     * *********************************************
     */

    /**
     * ****** added 06-29-2021
     * function Name: GetPublishedPagesPaginated
     * It will return active pages with slugs, order
     * $pages->with('slug')->where('pages.active', 1)->orderBy('position', 'ASC')->paginate(7);
     * ********************************
     * @param $page_count = number of records per page (numberic)
     * @param $direction = ASC, DESC
     * ********************************
     */
    public function GetPublishedPagesPaginated($page_count, $direction)
    {
        return $this->with('slug')->where('pages.active', 1)->orderBy('position', $direction)->paginate($page_count);
    }

    /**
     * ****** added 06-29-2021
     * function GetDraftPagesPaginated
     * It will return DRAFT pages with slugs, order
     * $draft_pages = $pages->with('slug')->where('active', 0)->orderBy('position', 'ASC')->paginate(7); //Draft pages
     * ********************************
     * @param $page_count = number of records per page (numberic)
     * @param $direction = ASC, DESC
     * ********************************
     */
    public function GetDraftPagesPaginated($page_count, $direction)
    {
        return $this->with('slug')->where('pages.active', 0)->orderBy('position', $direction)->paginate($page_count);
    }

    /**
     * ****** added 06-29-2021
     * function GetTrashedPagesPaginated
     * $deleted_pages =  $pages->with('slug')->onlyTrashed()->orderBy('position', 'ASC')->paginate(7); // Trashed pages
     * It will return TRASHED pages with slugs, order
     * ********************************
     * @param $page_count = number of records per page (numberic)
     * @param $direction = ASC, DESC
     * ********************************
     */
    public function GetTrashedPagesPaginated($page_count, $direction)
    {
        return $this->with('slug')->onlyTrashed()->orderBy('position', $direction)->paginate($page_count);
    }
}
