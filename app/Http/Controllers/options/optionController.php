<?php

namespace App\Http\Controllers\options;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class optionController extends Controller
{
    public function index(){
        $packages = DB::table('packages')->get();
        return view('packages.index',['packages'=>$packages]);
    }
}
