<?php

namespace App\Livewire;

use Livewire\Component;
use App\Jobs\LoadQuizStats;
use Illuminate\Support\Facades\Cache;

class BoardPostStatCard extends Component
{
    public $stat = []; //

    public function hydrate()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $o = Cache::get("quiz_stats", [
            'attempts' => 'Chargement...',
            'average_score' => 'Chargement...',
            'success_rate' => 'Chargement...',
        ]);
        $o['attempts'] = !is_string($o['attempts'])? $o['attempts']->sum('total') : $o['attempts'] ;
        // $this->stat = $o ;
        if($this->stat['key'] == 'quizAttemptCount') $this->stat['value'] =  $o['attempts'] ;
        if($this->stat['key'] == 'quizzSuccessRate') $this->stat['value'] =  $o['success_rate'] ;
        if($this->stat['key'] == 'quizzAverageScore')$this->stat['value'] = $o['average_score'] ;

        // Lancer le job pour charger en fond
        dispatch(new LoadQuizStats());
    }

    public function mount($stat = [])
    {
        $this->stat = $stat ;
        $this->refreshData();
    }

    public function render()
    {
        return view('livewire.board-post-stat-card');
    }
}
