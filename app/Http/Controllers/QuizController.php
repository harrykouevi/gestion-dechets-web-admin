<?php

namespace App\Http\Controllers;

use App\Services\QuizService;
use App\Services\StatService;
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

    public function showResult(Request $request)
    {
        $user = $request->input('user',Null) ;
        $quiz = $request->input('quiz',Null) ;
        if(is_null($user)){
            abort(404); // Will show the default 404 page
        }
        $quiz_data  = app(QuizService::class)->get($quiz, ['post']);
        

        $r =  app(StatService::class)->getQuizzUserAttemps([ 'userId'=> $user , 'quizzId'=> $quiz]) ;
        $attempsforquiz =  array_filter( $r, function($q) use($quiz) {
            return $q['quizzId'] == $quiz;
        });

        $statforAllParticipedQuiz =  app(StatService::class)->getQuizzUserScores([ 'userId'=> $user]) ;
        $statforAllParticipedQuiz['quizz'] =  array_filter( $statforAllParticipedQuiz['quizz'], function($q) use($quiz) {
            return $q['quizz_id'] == $quiz;
        });
        $quiz = [
            'id' => $quiz ,
            ...reset($statforAllParticipedQuiz['quizz']) ,
        ]; 

        // dd( $statforAllParticipedQuiz, $quiz_data ,$attempsforquiz ) ;

        return view('quizzes.resultshow', [
                            'user' =>  $user ,
                            'quiz' =>   $quiz ,
                            'quiz_data' =>   $quiz_data ,
                            'statforAllParticipedQuiz' => $statforAllParticipedQuiz,
                            'attempsforquiz' => $attempsforquiz,
                        ]); 
    }

}
