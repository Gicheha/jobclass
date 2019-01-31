<?php

namespace App\Http\Controllers\options;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class optionController extends Controller
{
    public function index(){
        return view('packages.index');
    }
}
