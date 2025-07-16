<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index(Request $request)
    {
       
        return view('rewards.list'); 
    }

    public function create(Request $request)
    {
        $quizId =  $request->input('quizId') ;
        return view('rewards.edit',compact('quizId')); ; 
    }

    public function edit($id)
    {

        return view('rewards.edit', compact('id'));
    }

}
