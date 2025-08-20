<?php

namespace App\Http\Controllers;

use App\Jobs\LoadCollectStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class CollectController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('report') && $request->input('report') == true ){
            // $reports =  app(StatService::class)->getPostMostRead() ;
              $p = Cache::get("collect_stats",
                    [
                        'collectcount' => 'Chargement...',
                        'requestcount' => 'Chargement...',
                        'user_number' => 'Chargement...',
                        'agent_number' => 'Chargement...',
                        'wastetypecount' => 'Chargement...'
                    ]);
                $collectcount = $p['collectcount'] ;
                $requestcount = $p['requestcount'] ;
                $user_number = $p['user_number'] ;
                $agent_number = $p['agent_number'] ;
                $wastetypecount = $p['wastetypecount'] ;
                $job = new LoadCollectStats();
                $job->handle();

            return view('collects.report',compact('agent_number','requestcount','collectcount','wastetypecount'));
        }
        return view('collects.list');
    }

    public function create()
    {
        return view('collects.edit');
    }

    public function edit($id)
    {

        return view('collects.edit', compact('id'));
    }


    public function stat(Request $request)
    {
        return view('collects.report');
    }
}
