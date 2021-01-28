<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SEOController extends Controller
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

    public function index(Request $request)
    {

        return view('admin.modules.general', ['mod_name' => 'SEO Manager']);
    }
}
