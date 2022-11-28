<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(request()->user()->role == 'admin'){
            return redirect()->route('admin');
        } else if(request()->user()->role == 'vendor'){
            return redirect()->route('vendor');
        } else {
            return redirect()->route('user');
        }
        // return view('home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function admin(){
        return view('admin.dashboard.index');
    }



    public function vendor(){
        return view('layouts.vendor-dashboard');
    }


    public function customer(){
        return view('home');
    }





















}
