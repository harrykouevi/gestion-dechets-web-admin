<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgentController extends Controller
{
    //

    public function index()
    {
         return view('agents.list'); 
    }

    public function update($id)
    {
        return view('agents.edit', compact('id'));
    }

    public function create()
    {
        return view('agents.edit');
    }

}
