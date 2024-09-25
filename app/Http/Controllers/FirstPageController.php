<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class FirstPageController extends Controller
{
    public function index(){
        $shopRecords=Shop::all();
        return view('firstpage',compact('shopRecords'));
    }
}
