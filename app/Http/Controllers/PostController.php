<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $selectedPost = Null ;
        $datas = [[1],[2],[3]] ;
        return view('posts.list',compact('datas','selectedPost')); 
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
