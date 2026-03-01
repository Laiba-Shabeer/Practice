<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(){
    //   dd("index function called");
       return view('welcome');
    }
}
