<?php

namespace App\Http\Controllers;

use App\Jobs\LoadCollectStats;
use App\Jobs\LoadQuizStats;
use App\Services\PostService;
use App\Services\QuizService;
use App\Services\StatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class DashboardController extends Controller
{
    public function index()
    {
        $p = Cache::get("collect_stats",
            [
                'collectcount' => 'Chargement...',
                'requestcount' => 'Chargement...',
                'user_number' => 'Chargement...',
                'agent_number' => 'Chargement...'
            ]);
        $collectcount = $p['collectcount'] ;
        $requestcount = $p['requestcount'] ;
        $user_number = $p['user_number'] ;
        $agent_number = $p['agent_number'] ;

        $mostRead = app(StatService::class)->getPostMostRead() ;
        $postcount = app(PostService::class)->getAll()->count() ;
        $quizcount = app(QuizService::class)->getAll()->count() ;
        $quizzParticipantCount = app(StatService::class)->getQuizzParticipantCount();

        $o = Cache::get("quiz_stats", [
                    'attempts' => 'Chargement...',
                    'average_score' => 'Chargement...',
                    'success_rate' => 'Chargement...',
                ]);

        $quizzAverageScore = $o['average_score'] ;
        $quizzSuccessRate = $o['success_rate'] ;
        $quizAttemptCount = !is_string($o['attempts'])? $o['attempts']->sum('total') : $o['attempts'] ;
                // Lancer le job pour charger en fond
        $job = new LoadQuizStats();
        $job->handle(app(\App\Services\StatService::class));

        $job = new LoadCollectStats ();
        $job->handle();

            //  dump(Cache::has('quiz_stats'));
            //  dump(Cache::get('quiz_stats'));
            //  dd(Cache::get('quiz_stats_20')) ;
        return view('dashboard',compact('user_number','agent_number','quizzSuccessRate','mostRead',
        'quizzParticipantCount', 'postcount','quizcount',
        'requestcount',
        'collectcount','quizAttemptCount','quizzAverageScore'));
    }
}
