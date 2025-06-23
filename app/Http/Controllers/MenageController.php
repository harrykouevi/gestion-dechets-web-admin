<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenageController extends Controller
{
    //

    public function index()
    {
         return view('menages.list'); 
    }

    public function update($id)
    {
        return view('menages.edit', compact('id'));
    }

    public function create()
    {
        return view('menages.edit');
    }

}
