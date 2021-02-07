<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pages;
use App\slugs;

class FrontendController extends Controller
{

    public $nav_style = 2;
    //Index page
    public function index(pages $pages, slugs $slugs)
    {
        $slug = null;
        $pages_info = $slugs->with('pages')->where('slug', $slug)->get();
        foreach ($pages_info as $info) {


            $pages_children = $pages->with('childItems')->find($info->pages->id);
            $tree = pages::whereNull('parent_id')->with('childItems')->with('slug')->whereNull('parent_id')->orderBy('position', 'ASC')->get();

            return view('frontend.welcome', [
                'page_data' => $pages_info,
                'page_children' => $pages_children,
                'items' => $tree,
                'nav_style' => $this->nav_style
            ]);
        }
    }
    //This will handle Top level pages
    public function SingleSlug(pages $pages, slugs $slugs, $slug)
    {
        $pages_info = $slugs->with('pages')->where('slug', $slug)->get();

        if (count($pages_info) > 0) {
            foreach ($pages_info as $info) {


                $pages_children = $pages->with('childItems')->find($info->pages->id);

                $breadCrumb = $this->array_values_recursive($info->pages->id);
                $count_parents = count($breadCrumb);
                $bc  = "";
                for ($i = 0; $i < $count_parents; $i++) {
                    $bc = $breadCrumb[$i]->title;
                }
                $tree = pages::whereNull('parent_id')->with('childItems')->with('slug')->whereNull('parent_id')->orderBy('position', 'ASC')->get();

                return view('frontend.welcome', [
                    'page_data' => $pages_info,
                    'page_children' => $pages_children,
                    'items' => $tree,
                    'nav_style' => $this->nav_style,
                    'bread_crumbs' => $breadCrumb
                ]);
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
            $pages_info = $slugs->with('pages')->where('slug', $last_slug)->get();
            if (count($pages_info) > 0) {
                foreach ($pages_info as $info) {

                    $pages_children = $pages->with('childItems')->find($info->pages->id);

                    // $page_parent = $pages->with('parent')->find($info->pages->id);
                    $breadCrumb = $this->array_values_recursive($info->pages->id);
                    $count_parents = count($breadCrumb);
                    $bc  = "";
                    for ($i = 0; $i < $count_parents; $i++) {
                        $bc = $breadCrumb[$i]->title;
                    }
                   // dd($bc);

                    $tree = pages::whereNull('parent_id')->with('childItems')->with('slug')->whereNull('parent_id')->orderBy('position', 'ASC')->get();
                    return view('frontend.welcome', [
                        'page_data' => $pages_info,
                        'page_children' => $pages_children,
                        'items' => $tree,
                        'nav_style' => $this->nav_style,
                        'bread_crumbs' => $breadCrumb
                    ]);
                }
            } else {
                return abort(404);
            }
        }
    }



    public function ShowWithId( $id){
        $pages_info = slugs::with('pages')->where('pages_id', $id)->get();

        if (count($pages_info) > 0) {
            foreach ($pages_info as $info) {

               // dd($info->uri);
                $pages_children = pages::with('childItems')->find($info->pages->id);

                $breadCrumb = $this->array_values_recursive($info->pages->id);
                $count_parents = count($breadCrumb);
                $bc  = "";
                for ($i = 0; $i < $count_parents; $i++) {
                    $bc = $breadCrumb[$i]->title;
                }
                $tree = pages::whereNull('parent_id')->with('childItems')->with('slug')->whereNull('parent_id')->orderBy('position', 'ASC')->get();


                return view('frontend.welcome', [
                    'page_data' => $pages_info,
                    'page_children' => $pages_children,
                    'items' => $tree,
                    'nav_style' => $this->nav_style,
                    'bread_crumbs' => $breadCrumb
                ]);
            }
        } else {
            return abort(404);
        }
    }

    public function array_values_recursive($id)
    {
        //$array = pages::where('id', $id)->with('slug')->get();
        $array = pages::where('id', $id)->with('parent')->with('slug')->get();
        $flat = array();
        foreach ($array as $value) {
            $flat = array_merge($flat, $this->array_values_recursive($value['parent_id']));
            $flat[] = $value;
        }
        return $flat;
    }
}
