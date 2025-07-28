<?php

namespace App\Jobs;

use App\Services\QuizService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\StatService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LoadQuizStats implements ShouldQueue
{
    
    use InteractsWithQueue, Queueable, SerializesModels;

    public $quizId;

    /**
     * Create a new job instance.
     */
    public function __construct($quizId = Null)
    {
        $this->quizId = $quizId;
    }


    

    /**
     * Execute the job.
     */
    public function handle(StatService $statService)
    {
                Log::error("yy_{$this->quizId} -  first") ;

        try {
            $quizId = $this->quizId;
            
            $param = (!is_null($quizId)) ? ['quizzId' => $quizId] : [] ;
            // Tentatives
            $attempts = app(\App\Services\QuizService::class)->getAllAttempt([...$param,'days'=>60]);
            $attemptCount = count($attempts);
            // Moyenne de score
            $averageScore = $statService->getQuizzScoreRate($param);

            // Taux de réussite
            $successRate = $statService->getQuizzSuccessRate($param);

            // Mise en cache des statistiques
            $data = [
                'attempts' => $attempts,
                'average_score' => $averageScore,
                'success_rate' => $successRate,
            ];
            if(is_null($quizId) ){
                Cache::put("quiz_stats", $data, now()->addMinutes(1));
            }else{
                // Log::info(["yy_{$quizId}","quiz_stats_{$quizId}",$data]) ;

                Cache::put("quiz_stats_{$quizId}", $data, now()->addMinutes(1));
            }
        } catch (\Throwable $e) {
            Log::error("Erreur dans LoadQuizStats pour quiz #{$this->quizId} : " . $e->getMessage());

            Cache::put("quiz_stats_{$this->quizId}", [
                'attempts' => 'Erreur',
                'average_score' => 'Erreur',
                'success_rate' => 'Erreur',
            ], now()->addMinutes(1));

            throw $e; // Permet à Laravel de marquer le job comme échoué
        }
    }
}
