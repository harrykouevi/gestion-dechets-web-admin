<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WasteTypeController extends Controller
{
    public function index()
    {
       
         return view('wastetypes.list'); 
    }
}
