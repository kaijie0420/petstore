<?php

namespace App\Http\Controllers\Dog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class DogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(DB::table('dog')
          ->where('id', 1)
          ->get());
    }

    public function getAll() {
      $all = DB::table('dog')->get();
      return $all;
    }

    public function dashboard()
    {
      return view('dashboard');
    }
}
