<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pages;
use App\slugs;

class FrontendController extends Controller
{
    //Index page
    public function index(pages $pages, slugs $slugs)
    {
        $slug = null;
        $pages_info = $slugs->with('pages')->where('slug', $slug)->get();
        foreach ($pages_info as $info) {


            $pages_children = $pages->with('childItems')->find($info->pages->id);

            dd($pages_children);
        }
    }
    //This will handle Top level pages
    public function SingleSlug(pages $pages, slugs $slugs, $slug)
    {
        $pages_info = $slugs->with('pages')->where('slug', $slug)->get();
        if (count($pages_info) > 0) {
            foreach ($pages_info as $info) {
                $pages_children = $pages->with('childItems')->find($info->pages->id);
                $tree = pages::whereNull('parent_id')->with('childItems')->with('slug')->whereNull('parent_id')->orderBy('position', 'ASC')->get();

                return view('frontend.welcome', [
                    'page_data' => $pages_info,
                    'page_children' => $pages_children,
                    'items' => $tree]);
            }
        } else {
            return abort(404);
        }
    }
    //This will handle pages that have multi level slugs.
    public function MultipleSlugs(pages $pages, slugs $slugs, $any, $slug)
    {
        if ($any == 'admin') {
            return redirect('admin');
        } else {

            $last_slug = request()->segment(count(request()->segments()));
            dd($last_slug);
            $pages_info = $slugs->with('pages')->where('slug', $last_slug)->get();
            if (count($pages_info) > 0) {
                foreach ($pages_info as $info) {

                    $pages_children = $pages->with('childItems')->find($info->pages->id);

                    dd($pages_children);
                }
            } else {
                return abort(404);
            }
        }
    }
}
