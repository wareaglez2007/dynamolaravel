<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {

        return view('admin.modules.general', ['mod_name' => 'Business Information Manager']);
    }
}
