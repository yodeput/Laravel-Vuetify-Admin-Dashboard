<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;

class ApplicationController extends BaseController
{
    public function index()
    {
        return view('application');
    }
}
