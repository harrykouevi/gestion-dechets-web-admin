<?php

namespace App\Http\Controllers;

use App\Services\StatService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('report') && $request->input('report') == true ){
            $reports =  app(StatService::class)->getPostMostRead() ;
            return view('posts.report'
                , [
                            'datas' => $reports,
                        ]);
        }
        return view('posts.list'); 
    }

    public function create()
    {
        $postId = Null ;
        $datas = [[1],[2],[3]] ;
        $post = [ 
           "questions" => [["propositions"  => [[1],[2],[3]]],["propositions"  => [[1],[2],[3]]],["propositions"  => [[1],[2],[3]]]] ,
        ] ;
        return view('posts.edit',compact('datas','post','postId')); 
    }

    public function edit($id)
    {

        return view('posts.edit', compact('id'));
    }

}
