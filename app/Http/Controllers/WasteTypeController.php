<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WasteTypeController extends Controller
{
    public function index()
    {
       
         return view('wastetypes.list'); 
    }

    public function create()
    {
        return view('wastetypes.edit'); 
    }

    public function edit($id)
    {

        return view('wastetypes.edit', compact('id'));
    }
}
