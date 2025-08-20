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
        return view('posts.edit'); 
    }

    public function edit($id)
    {

        return view('posts.edit', compact('id'));
    }

}
