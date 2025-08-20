<?php

namespace App\Jobs;

use App\Services\CollectService;
use App\Services\QuizService;
use App\Services\RequestCollectService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\StatService;
use App\Services\WastetypeService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LoadCollectStats implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $user_number = app(StatService::class)->getDomicilleCount() ;
            $user_number += $agent_number = app(StatService::class)->getAgentCount() ;
            $collectcount = app(CollectService::class)->getAll()->count();
            $requestcount = app(RequestCollectService::class)->getAll()->count() ;
            $wastetypecount = app(WastetypeService::class)->getAll()->count() ;


            // Mise en cache des statistiques
            $data = [
                'collectcount' => $collectcount,
                'requestcount' => $requestcount,
                'user_number' => $user_number,
                'agent_number' => $agent_number,
                'wastetypecount' =>  $wastetypecount

            ];

            Cache::put("collect_stats", $data, now()->addMinutes(1));

        } catch (\Throwable $e) {
            Log::error("Erreur dans LoadCollectStats } : " . $e->getMessage());

            Cache::put("collect_stats",  [
                'collectcount' => 'Erreur',
                'requestcount' => 'Erreur',
                'user_number' => 'Erreur',
                'agent_number' => 'Erreur',
                'wastetypecount' =>  'Erreur',

            ], now()->addMinutes(1));

            throw $e; // Permet à Laravel de marquer le job comme échoué
        }
    }
}
