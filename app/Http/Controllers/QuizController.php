<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $selectedQuiz = Null ;
        $datas = [[1],[2],[3]] ;
         return view('quizzes.list',compact('datas','selectedQuiz')); 
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
}
