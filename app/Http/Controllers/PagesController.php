<?php

namespace App\Http\Controllers;

use App\pages;
use App\slugs;
use App\children;
use App\page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\UploadImages;

class PagesController extends Controller
{

    /**
     * To find all children of a page
     * use  $children = $pages->find(3);
     *      $children->child;
     * To find the parent of a page
     * use  $parent = $pages->find(5);
     *      $parent->parent->id;
     * To find page slug
     * use  $pages->find(3);
     *      $pages->slug
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, pages $pages)
    {

        $publish_page_count = $pages->where('active', 1)->count();
        $trashed_page_count = $pages->onlyTrashed()->count();
        $draft_pages_count = $pages->where('pages.active', 0)->count();
        $all_pages_count = $pages->withTrashed()->count();
        return view('admin.modules.Pages.pages', [
            'request' => $request,
            'publishcount' => $publish_page_count,
            'draftcount' => $draft_pages_count,
            'trashed' => $trashed_page_count,
            'allcount' => $all_pages_count
        ]);
    }


    public function AjaxPublishedPages(Request $request, pages $pages)
    {
        $pageslist = $pages->with('slug')->where('pages.active', 1)->orderBy('position', 'ASC')->paginate(7); //Active pages
        $draft_pages = $pages->with('slug')->where('active', 0)->orderBy('position', 'ASC')->paginate(7); //Draft pages
        $deleted_pages =  $pages->with('slug')->onlyTrashed()->orderBy('position', 'ASC')->paginate(7); // Trashed pages
        $publish_page_count = $pages->where('active', 1)->count();
        $trashed_page_count = $pages->onlyTrashed()->count();



        $draft_pages_count = $pages->where('pages.active', 0)->count();
        $all_pages_count = $pages->withTrashed()->count();
        if ($request->ajax()) {
            return view('admin.layouts.partials.page', [
                'pageslist' => $pageslist,
                'deleted_pages' => $deleted_pages,
                'publishcount' => $publish_page_count,
                'draftcount' => $draft_pages_count,
                'trashed' => $trashed_page_count,
                'draftpages' => $draft_pages,
                'allcount' => $all_pages_count,
                'request' => $request
            ])->render();
        } else {
            return view('admin.modules.Pages.pages', [
                'pageslist' => $pageslist,
                'deleted_pages' => $deleted_pages,
                'publishcount' => $publish_page_count,
                'draftcount' => $draft_pages_count,
                'trashed' => $trashed_page_count,
                'draftpages' => $draft_pages,
                'allcount' => $all_pages_count,
                'request' => $request
            ]);
        }
    }

    public function AjaxDraftPages(Request $request, pages $pages)
    {
        $draft_pages = $pages->with('slug')->where('active', 0)->orderBy('position', 'ASC')->paginate(7);
        $draft_pages_count = $pages->where('pages.active', 0)->count();
        $all_pages_count = $pages->withTrashed()->count();
        $publish_page_count = $pages->where('active', 1)->count();
        $trashed_page_count = $pages->onlyTrashed()->count();

        if ($request->ajax()) {

            return view('admin.layouts.partials.page', [

                'publishcount' => $publish_page_count,
                'draftcount' => $draft_pages_count,
                'trashed' => $trashed_page_count,
                'draftpages' => $draft_pages,
                'allcount' => $all_pages_count
            ])->render();
        } else {
            return view('admin.modules.Pages.pages', [

                'publishcount' => $publish_page_count,
                'draftcount' => $draft_pages_count,
                'trashed' => $trashed_page_count,
                'draftpages' => $draft_pages,
                'allcount' => $all_pages_count
            ]);
        }
    }
    public function AjaxTrashedPages(Request $request, pages $pages)
    {
        $deleted_pages = $pages->onlyTrashed()->orderBy('position', 'ASC')->paginate(7);
        $draft_pages_count = $pages->where('pages.active', 0)->count();
        $all_pages_count = $pages->withTrashed()->count();
        $publish_page_count = $pages->where('active', 1)->count();
        $trashed_page_count = $pages->onlyTrashed()->count();

        if ($request->ajax()) {

            return view('admin.layouts.partials.page', [

                'publishcount' => $publish_page_count,
                'draftcount' => $draft_pages_count,
                'trashed' => $trashed_page_count,
                'deleted_pages' => $deleted_pages,
                'allcount' => $all_pages_count
            ])->render();
        } else {
            return view('admin.modules.Pages.pages', [

                'publishcount' => $publish_page_count,
                'draftcount' => $draft_pages_count,
                'trashed' => $trashed_page_count,
                'deleted_pages' => $deleted_pages,
                'allcount' => $all_pages_count
            ]);
        }
    }
    /**
     * Pages Tree
     */
    public function Pagestree(pages $pages)
    {
        $tree = pages::whereNull('parent_id')->with('childItems')->orderBy('position', 'ASC')->get();
        //  dd($tree);
        return view('admin.modules.Pages.pagetree', ['items' => $tree]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageslist = pages::select('id', 'title')->get();
        //Create a new page
        return view('admin.modules.Pages.create', [
            'pageslist' => $pageslist,
            'section_name' => "Create new page."

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param App\pages
     * @param App\slugs
     * @param App\children
     *
     ***************Notes:****************
     * To save betweeon pages->childrens->slug:
     * use:  $slugs->slug = <[slug value]>;
     *       $pages->slug()->save($slugs);
     */
    public function store(Request $request, pages $pages, slugs $slugs)
    {
        //before inserting we need to check and see if the page name is unique or not
        $validatedData = $request->validate([
            'title' => ['required', 'unique:pages', 'max:255'],
            'content' => ['required'],
        ]);
        $count = $pages->get()->count();
        $pages->title = $request->title;
        $pages->subtitle = $request->subtitle;
        $pages->content = $request->content;
        $pages->parent_id = $request->parent_page_id;
        $pages->owner = $request->owner;
        $pages->position = (int)$count + 1;
        $pages->save();

        if (strtolower($request->title) != "home") {
            if (empty($request->slug)) {
                $slug = $this->SlugsCreator($request->title);
            } else {
                $slug = $this->SlugsCreator($request->slug);
            }

            //Create the URI
            $par = $this->array_values_recursive($request->parent_page_id);
            $count_parents = count($par);
            $slug_uri  = "";
            for ($i = 0; $i < $count_parents; $i++) {
                $slug_uri .= "/" . $par[$i]->slug->slug;
            }

            $page_final_slug = $slug_uri . "/" . $slug;


            $slugs->slug = $slug;
            $slugs->uri = $page_final_slug;
            $pages->slug()->save($slugs);
        }

        $success_message = "Page " . request('title') . " has been added to your pages.";
        return response()->json(['success' => $success_message]);
    }

    /**
     * Page Title Validator VIA AjAX
     */
    public function validateNewPageData(Request $request, pages $pages)
    {

        if ($request->flag) {
            //on edit if the page name is the same as what the actual page is then,
            //just validate but if the page is already taken by other existing page give error
            $check_title = $pages->find($request->id);
            if ($check_title->title == $request->title) { //meaning if the values are the same allow
                $unique_rule = "";
            } else {
                $unique_rule = 'unique:pages';
            }
            $validatedData = $request->validate([
                'title' => ['required', $unique_rule, 'max:255'],

            ]);
        } else {

            $validatedData = $request->validate([
                'title' => ['required', 'unique:pages', 'max:255'],

            ]);
        }

        $success_message = "Page title " . $request->title . " is available";
        return response()->json(['success' => $success_message]);
    }
    /**
     * Slug validator via AJAX
     */
    public function validatPageSlugUniqueness(Request $request, slugs $paga_slugs)
    {
        $slug_validator = ['slug' => $this->SlugsCreator(request('slug'))];
        $validator = Validator::make($slug_validator, [
            'slug' => ['unique:slugs']
        ]);
        $success_message = "Slug " . $this->SlugsCreator(request('slug')) . " is available";
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return response()->json(['success' => $success_message]);
    }
    /**
     * Update Page slug from Edit pages
     * 03-31-2021
     * After ajax checks slug validation
     */
    public function updatePageSlug(Request $request, slugs $slug)
    {

        if (request('slug') == "") {
            $error_message = ['error_message' => "Slug for this page cannot be empty!", 'slug' => request('old_slug')];
            return response()->json($error_message,  422);
        }
        $slug_validator = $this->SlugsCreator(request('slug'));

        $slug  = "";
        if ($request->parent_id != 0) {
            $par = $this->array_values_recursive($request->parent_id);
            $count_parents = count($par);

            for ($i = 0; $i < $count_parents; $i++) {
                $slug .= "/" . $par[$i]->slug->slug;
            }
        }


        $uri = $slug . "/" . $slug_validator;


        $success_message = ['success_message' => "Slug " . $slug_validator . " has been updated!", 'uri' => $uri, 'slug' => $slug_validator];
        slugs::where("pages_id", request('page_id'))->update(['slug' => $slug_validator, 'uri' => $uri]);
        return response()->json(['success' => $success_message]);
    }


    /***
     * Publish a page
     */
    public function publish(Request $request, pages $pages)
    {
        $pages->where('id', request('page_id'))
            ->update([
                'active' => request('change_status')
            ]);
        $title = $pages->find(request('page_id'));
        if ($request->change_status == 1) {
            $keyword = "published";
        } else {
            $keyword = "Unpublished";
        }
        $success_message = "Page <b>" . $title->title . "</b> has been " . $keyword;
        return response()->json(['success' => $success_message]);
        // return redirect('admin/pages');
    }

    /**
     * Restore the spicific page to the storage
     */
    public function restore(Request $request, pages $pages, slugs $page_slugs)
    {
        $restore_page = $pages->withTrashed()->find($request->id)->restore();
        $restore_page_slug = $page_slugs->withTrashed()->where('pages_id', $request->id)->restore();

        $title = $pages->find($request->id);

        $success_message = "Page <b>" . $title->title . "</b> has been restored.";
        return response()->json(['success' => $success_message]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function show(pages $pages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function edit(pages $pages, $id)
    {
        $edit_view = $pages->with('slug')->find($id);
        $page_list = $pages->select('id', 'title')->where('id', "!=", $id)->get();
        $homepage_count = $pages->where("is_homepage", 1)->count();

        //Create the URI
        $par = $this->array_values_recursive($edit_view->parent_id);
        $count_parents = count($par);
        $slug_uri  = "";
        for ($i = 0; $i < $count_parents; $i++) {
            $slug_uri .= "/" . $par[$i]->slug->slug;
        }

        $images = UploadImages::orderBy('id', 'DESC')->paginate(12);


        return view('admin.modules.Pages.edit', [
            'permalink' => $slug_uri,
            'editview' => $edit_view,
            'pages' => $page_list,
            'homepageCount' => $homepage_count,
            'mod_name' => "Images",
            'images' => $images
        ]);
    }
    /**
     * Edit page image pagination
     */
    public function PageImagesPagination(Request $request, pages $pages, $id)
    {
        $images = UploadImages::orderBy('id', 'DESC')->paginate(12);
        $edit_view = $pages->with('slug')->find($id);
        if ($request->ajax()) {
            return response()->json([
                'view' => view('admin.layouts.partials.showpageimages')->with(['images' => $images, 'editview' => $edit_view])->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pages $pages, slugs $slugs)
    {
        $check_title = $pages->find($request->id);
        if ($check_title->title == $request->title) { //meaning if the values are the same allow
            $unique_rule = "";
        } else {
            $unique_rule = 'unique:pages';
        }
        $validatedData = $request->validate([
            'title' => ['required', $unique_rule, 'max:255'],

        ]);

        $get_slugs = $slugs->where('pages_id', $request->id)->get();

        //we will fix the slug uri to be
        //IF it has parents then get their slugs and append it /services/residential-services/name

        $par = $this->array_values_recursive($request->parent_id);
        $count_parents = count($par);
        $slug  = "";
        for ($i = 0; $i < $count_parents; $i++) {
            $slug .= "/" . $par[$i]->slug->slug;
        }

        $page_final_slug = $slug . "/" . $request->slug;
        $updated_slugs_uri = $slugs->where('pages_id', $request->id)->update(['uri' => $page_final_slug]);



        //Update
        $pages->where('id', $request->id)->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'parent_id' => $request->parent_id,
            'content' => $request->description,
            'owner' => $request->title,
        ]);
        //Check Slug
        $get_slugs_count = $slugs->where('pages_id', $request->id)->count();

        if ($get_slugs_count == 0) {
            //Means we need to update this slug
            $slugs->slug = $request->slug;
            $slugs->pages_id = $request->id;
            $slugs->create(['slug' => $request->slug, 'pages_id' => $request->id]);
        }



        $success_message = "Page <b>" . $request->title . "</b> has been updated";
        return response()->json(['success' => $success_message]);
        //return redirect('admin/pages/edit/' . $request->page_id)->withErrors($validatedData);
    }

    public function array_values_recursive($id)
    {
        $array = pages::where('id', $id)->with('slug')->get();
        $flat = array();
        foreach ($array as $value) {
            $flat = array_merge($flat, $this->array_values_recursive($value['parent_id']));
            $flat[] = $value;
        }
        return $flat;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, pages $pages, slugs $slugs)
    {
        //Check if the page has any children 1st
        //Find all children if parent is zero
        //look at the page id in parent_page_id column of childpages table
        $parent = $request->parent == 0 ? NULL : $request->parent;
        if ($parent == NULL) {
            $child = $pages->with('childItems')->where('parent_id', $request->id)->update(['parent_id' => NULL]);
        }
        $title = $pages->find($request->id);
        $pages->where('id', $request->id)->delete();
        $slugs->where('pages_id', $request->id)->delete();


        $success_message = "Page <b>" . $title->title . "</b> has been deleted.";
        //return redirect('admin/pages/')->with('message', $success_message);
        return response()->json(['success' => $success_message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function permDelete(Request $request, pages $pages, slugs $slugs)
    {
        //
        //Check if the page has any children 1st
        //Find all children if parent is zero
        //look at the page id in parent_page_id column of childpages table

        //  $parent_info = pages::find($id)->childPages()->where('pages_id', $id)->first();
        $parent = $request->parent == 0 ? NULL : $request->parent;
        if ($parent == NULL) {
            $child = $pages->with('childItems')->where('parent_id', $request->id)->update(['parent_id' => NULL]);
        }

        $success_message = "Page has been permanatly deleted <i class='bi bi-exclamation-circle'></i>";

        $update_new_positions = $pages->where('position', '>', $request->position)->decrement('position');

        //if is not zero means the page is a child and not a main and do not change
        $pages->where('id', $request->id)->forceDelete();
        $slugs->where('pages_id', $request->id)->forceDelete();


        return response()->json(['success' => $success_message]);
    }


    /**
     * takes in a string and converts it to URI safe straing
     * @return string
     */
    function SlugsCreator($string)
    {
        $string = str_replace(' ', '-', $string);
        $string = strtolower($string);
        $string = preg_replace('/[^A-Za-z0-9-]/', '', $string);
        $string = trim(preg_replace("![^a-z0-9]+!i", "-", $string), '-');
        return $string;
    }



    /**
     * These are for ajax requests
     *
     */
    public function getDraftpageByID(pages $pages, $id, $status)
    {

        $draftpages = $pages->where('active', $status)->findorfail($id);
        return response()->json($draftpages);
    }
    public function getAllNoneDeletedPagesByID(pages $pages, $id, $parent)
    {
        //$nontrashedpages = $pages
        //     ->select('pages.title', 'pages.id', 'pages.created_at', 'pages.updated_at', 'slugs.slug', 'pages.deleted_at')
        //   ->leftJoin('page_slugs', 'pages.id', '=', 'page_slugs.pages_id')->withTrashed()->find($id);
        $nontrashedpages = $pages->with('slug')->withTrashed()->find($id);

        return response()->json($nontrashedpages);
    }
    public function getAllTrashedpagesBYID(pages $pages, $id)
    {
        $trashedpages = $pages
            ->select('pages.title', 'pages.id',  'pages.created_at', 'pages.updated_at', 'slugs.slug', 'pages.active')
            ->leftJoin('slugs', 'pages.id', '=', 'slugs.pages_id')->onlyTrashed()->find($id);

        return response()->json($trashedpages);
    }
    public function getDeletedAtInfoAfterDelete(pages $pages, $id)
    {
        $deleted_at = $pages->onlyTrashed()->findorfail($id);
        return response()->json($deleted_at);
    }
    public function getNewPublishedCount(pages $pages)
    {
        $newactivecount = $pages->where('active', 1)->count();
        $draftnewcount = $pages->where('active', 0)->count();
        $trashednewcount = $pages->onlyTrashed()->count();
        return response()->json(['newcount' => $newactivecount, 'draftnewcount' => $draftnewcount, 'tashedcount' => $trashednewcount]);
    }

    public function UpdatePosition(Request $request, pages $pages)
    {
        /**
         * positions
         * @help source: https://dba.stackexchange.com/questions/203799/how-to-update-sorting-order-column-of-other-rows-when-changing-one
         */

        $old_position = $request->old_p; //a
        $new_position = $request->new_p; //b
        $page_id = $request->id; //id

        if ($old_position < $new_position) {
            $update_new_positions = $pages->where('position', '>', $old_position)->where('position', '<=', $new_position)->decrement('position');
        } else {
            $update_new_positions = $pages->where('position', '<', $old_position)->where('position', '>=', $new_position)->increment('position');
        }
        $update_old_position = $pages->where('id', $page_id)->update(['position' => $new_position]);


        $success_message = $update_new_positions;

        return response()->json(['success' => $success_message]);
    }

    //Bulk Unpublish function
    public function BulkUnpublish(Request $request, pages $pages)
    {

        $count = $pages->where('active', 1)->count();
        $success_message = "There are no published pages here.";
        if ($count > 0) {
            $pages->where('active', 1)->update(['active' => 0]);
            $success_message = "All pages have been unpublished.";
        }


        return response()->json(['success' => $success_message]);
    }
    //Bulk Publish function
    public function BulkPublish(Request $request, pages $pages)
    {

        $count = $pages->where('active', 0)->count();
        $success_message = "There are no unpublished pages here.";
        if ($count > 0) {
            $pages->where('active', 0)->update(['active' => 1]);
            $success_message = "All pages have been published.";
        }


        return response()->json(['success' => $success_message]);
    }

    //Update page status with toggle button

    public function updatePageStatus(Request $request, pages $pages)
    {
        $page_id = $request->page_id;
        $status = $request->status;

        $update_page_status = $pages->where('id', $page_id)->update(['active' => $status]);
        $success_message = "page status changed to " . $status;
        return response()->json(['success' => $success_message]);
    }
    //03-26-2021 check as the homepage
    public function isHomepage(Request $request, pages $pages)
    {
        //there can ONLY be one homepage
        //1st check if any of the values in the pages table is already a homepage
        $page_id = $request->page_id;
        $status = $request->status;
        //Check page and see its homepage status
        $is_homepage = pages::find($page_id);
        if ($is_homepage->is_homepage == 1 && $status == 1) {
            $error_message = "This page is already the homepage!";
            return response()->json(['errors' => $error_message], 422);
        } else if ($is_homepage->is_homepage == 1 && $status == null) {
            pages::where("id", $page_id)->update(["is_homepage" => $status]);
            $success_message =  "This page is no longer a homepage.";
            return response()->json(['success' => $success_message]);
        } else {
            //check to see if there is another page that is a homepage
            $check_homepage = pages::where('is_homepage', 1)->get();
            if (count($check_homepage) > 0) {
                foreach ($check_homepage as $hp) {
                    $error_message = "There can be only one homepage per website. Please uncheck page " . $hp->title . " id= " . $hp->id;
                }
                return response()->json(['errors' => $error_message], 422);
            } else {
                pages::where("id", $page_id)->update(["is_homepage" => $status]);
                if ($status == 1) {
                    $success_message =  "Page has been set as the homepage.";
                } else {
                    $success_message =  "This page is no longer a homepage.";
                }

                return response()->json(['success' => $success_message]);
            }
        }
    }
}
