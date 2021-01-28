<?php

namespace App\Http\Controllers;

use App\pages;
use App\slugs;
use App\children;
use App\page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index(Request $request, pages $pages)
    {

        $publish_page_count = $pages->where('active', 1)->count();
        $trashed_page_count = $pages->onlyTrashed()->count();
        $draft_pages_count = $pages->where('pages.active', 0)->count();
        $all_pages_count = $pages->withTrashed()->count();
        return view('admin.modules.general', [
            'mod_name' => 'Main Dashboard',
            'request' => $request,
            'publishcount' => $publish_page_count,
            'draftcount' => $draft_pages_count,
            'trashed' => $trashed_page_count,
            'allcount' => $all_pages_count
        ]);
    }
}
