<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\QuizService ;
use App\Services\StatService;

class QuizLeaderboard extends Component
{
    public $topScores;
    
    public function mount()
    {
        $this->topScores = app(StatService::class)->getQuizzTopScore(); // tu peux adapter le paramètre
        $this->topScores = (array_key_exists('data',$this->topScores))? collect($this->topScores['data'])->sortByDesc('best_score')->values()->toArray() : [];
        // dd($this->topScores) ;
    }
    
    public function render()
    {
        return view('livewire.quiz-leaderboard');
    }
}
