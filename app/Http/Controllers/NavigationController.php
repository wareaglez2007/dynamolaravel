<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pages;

class NavigationController extends Controller
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


    public function index(Request $request,pages $pages )
    {

        $tree = pages::whereNull('parent_id')->with('childItems')->orderBy('position', 'ASC')->get();
        return view('admin.modules.general', [
        'mod_name' => 'Navigation Manager',
        'items' => $tree


        ]);
    }
}
