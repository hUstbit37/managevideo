<?php

namespace App\Http\Controllers;

class VueController extends Controller
{
    public function index()
    {
        return view('TestRouterVue/index');
    }
    public function register(Request $request)
    {
        dd($request);
    }
}