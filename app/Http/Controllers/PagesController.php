<?php

namespace App\Http\Controllers;

use App\pages;
use App\slugs;
use App\children;
use App\page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        }else{
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
        }else{
            return view('admin.modules.Pages.pages', [

                'publishcount' => $publish_page_count,
                'draftcount' => $draft_pages_count,
                'trashed' => $trashed_page_count,
                'draftpages' => $draft_pages,
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
            'description' => ['required'],
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
            $slugs->slug = $this->SlugsCreator($request->slug);
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

    /***
     * Publish a page
     */
    public function publish(Request $request, pages $pages)
    {
        $pages->where('id', request('page_id'))
            ->update([
                'active' => request('change_status')
            ]);

        return response()->json(['success' => request()]);
        // return redirect('admin/pages');
    }

    /**
     * Restore the spicific page to the storage
     */
    public function restore(Request $request, pages $pages, slugs $page_slugs)
    {
        $restore_page = $pages->withTrashed()->find($request->id)->restore();
        $restore_page_slug = $page_slugs->withTrashed()->where('pages_id', $request->id)->restore();

        return response()->json(['success' => request()]);
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
        return view('admin.modules.Pages.edit', [
            'editview' => $edit_view,
            'pages' => $page_list
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pages $pages)
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
        //Update
        $pages->where('id', $request->id)->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'parent_id' => $request->parent_id,
            'content' => $request->description,
            'owner' => $request->title,
        ]);
        $success_message = "Page " . $request->title . " has been updated";
        return response()->json(['success' => $success_message]);
        //return redirect('admin/pages/edit/' . $request->page_id)->withErrors($validatedData);
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
        if ($request->parent == NULL) {
            $child = $pages->with('childItems')->where('parent_id', $request->id)->update(['parent_id' => NULL]);
        }
        $pages->where('id', $request->id)->delete();
        $slugs->where('pages_id', $request->id)->delete();

        $success_message = "Page has been deleted.";
        //return redirect('admin/pages/')->with('message', $success_message);
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
}
