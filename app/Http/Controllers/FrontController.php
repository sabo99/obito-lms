<?php

namespace App\Http\Controllers;

class FrontController extends Controller
{
    public function index()
    {
        return 'Front Controller';
    }

    public function pricing()
    {
        return view('welcome');
    }
}
