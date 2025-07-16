<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
       
        return view('quizzes.list'); 
    }

    public function create(Request $request)
    {
        $postId =  $request->input('postId') ;
    
        return view('quizzes.edit',compact('postId')); 
    }

    public function edit($id)
    {
        return view('quizzes.edit',compact('id')); 
    }

    public function rewards($id)
    {
        return view('quizzes.rewards',compact('id')); 
    }
}
