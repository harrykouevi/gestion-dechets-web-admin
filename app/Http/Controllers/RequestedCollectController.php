<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestedCollectController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('report') && $request->input('report') == true ){
            // $reports =  app(StatService::class)->getPostMostRead() ;
            return view('requestedcollects.report');
        }
        return view('requestedcollects.list');
    }

    public function create()
    {
        return view('requestedcollects.edit');
    }

    public function edit($id)
    {

        return view('requestedcollects.edit', compact('id'));
    }


    public function stat(Request $request)
    {
        return view('requestedcollects.report');
    }
}
