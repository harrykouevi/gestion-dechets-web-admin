<?php

namespace App\Livewire;

use App\Jobs\LoadQuizStats;
use Livewire\Component;
use App\Services\QuizService ;
use App\Services\StatService;
use Illuminate\Support\Facades\Cache;

use function PHPUnit\Framework\isString;

class ContentPerformanceComparison extends Component
{
    public $contents;
    public $stats = []; //

    public function hydrate()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->contents = app(QuizService::class)->getAll(['quizz']); // tu peux adapter le paramètre
        
        // Pour chaque quiz, initialiser stats vide
        foreach ($this->contents as $quiz) {
            $id = $quiz['id'] ?? null;
            if ($id) {
                $this->stats[$id] = [
                    'attempts' => Null,
                    'average_score' => Null,
                    'success_rate' => Null,
                ];
                // Lancer la récupération des stats de façon asynchrone
                $this->loadStats($id);
            }
        }
    }

    public function mount()
    {
       
        $this->refreshData();
        // $this->contents = Content::with(['quiz', 'quiz.attempts.user'])
        //  ->get()
        //     ->map(function ($content) {
        //         $attempts = $content->quiz?->attempts ?? collect();

        //         $attemptCount = $attempts->count();
        //         $avgScore = $attemptCount > 0
        //             ? $attempts->avg('score')
        //             : 0;

        //         $successCount = $attempts->filter(function ($attempt) use ($content) {
        //             return $attempt->score >= ($content->quiz?->passing_score ?? 0);
        //         })->count();

        //         $successRate = $attemptCount > 0
        //             ? ($successCount / $attemptCount) * 100
        //             : 0;

        //         return (object) [
        //             'title' => $content->title,
        //             'quiz' => $content->quiz,
        //             'attempts' => $attemptCount,
        //             'average_score' => $avgScore,
        //             'success_rate' => $successRate,
        //         ];
        //     });
    }

    public function loadStats($quizId)
    {
        
        if ($quizId) {
            $o = Cache::get("quiz_stats_{$quizId}", [
                'attempts' => 'Chargement...',
                'average_score' => 'Chargement...',
                'success_rate' => 'Chargement...',
            ]);
            $o['attempts'] = !is_string($o['attempts'])? $o['attempts']->sum('total') : $o['attempts'] ;
            $this->stats[$quizId] = $o ;
            // Lancer le job pour charger en fond
            // dispatch(new LoadQuizStats($quizId));
            $job = new LoadQuizStats($quizId);
            $job->handle(app(\App\Services\StatService::class));
        }
      
    }
    
    public function render()
    {
       

        return view('livewire.content-performance-comparison');
    }
}
