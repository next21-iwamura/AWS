<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('parts.ajax.user');
    }

    public function select2_ajax() {

        return view('parts.operation');

    }
    public function select2_ajax2() {

        return view('parts.operation_status');

    }

    public function select2_ajax_test() {

        return view('parts.operation_test');

    }
    public function select2_ajax2_test() {

        return view('parts.operation_status_test');

    }


}

