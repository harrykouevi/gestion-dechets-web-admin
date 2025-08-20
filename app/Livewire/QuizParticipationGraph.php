<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Services\QuizService ;


class QuizParticipationGraph extends Component
{
    public $filter = 20; // par défaut 30 derniers jours
    public $chartData;

    public function mount()
    {
        $this->generateChart_();
    }

    public function updatedFilter()
    {
       
        $this->generateChart_();
        // $this->dispatchBrowserEvent('updateChart', $this->chartData);
        $this->dispatch('updateChart', 
            $this->chartData
        );
    }

    
     public function generateChart_()
    {
        $fromDate = Carbon::now()->subDays(30)->startOfDay();
        // $fromDate = Carbon::now()->subDays($this->filter)->startOfDay();
        //UserQuizAttempt
        // Récupérer les données depuis l’API (ex : via un service)
        $attempts = (app(QuizService::class)->getAllAttempt())->toArray(); // tu peux adapter le paramètre
        // $attempts = [
        //      [
        //         "postId" => "1a4e361d-e88e-44ce-86a7-b7349d0fac92",
        //         "id" => 13,
        //         "titre" => "♻️ Quiz : Es-tu un pro du tri des déchets ? 🌍🌍",
        //         "passingScore" => 5,
        //         "nombreQuestion" => 6,
        //         "pointTotal" => +135,
        //         "rewards" => [],
        //         "created_at" => "2025-07-07T10:35:21.000000Z"
        //     ]
        // ]; 
        $attempts = array_slice($attempts, 0, $this->filter);
        // // On suppose que chaque item contient un champ 'created_at'
        $attemptsFiltered = collect($attempts)
            ->filter(function ($attempt) use ($fromDate) {
                return Carbon::parse($attempt['jour'])->greaterThanOrEqualTo(Carbon::parse($fromDate));
            });

        // // Grouper par jour et compter les tentatives
        // $grouped = $attemptsFiltered->groupBy(function ($item) {
        //     return Carbon::parse($item['created_at'])->format('Y-m-d');
        // })->map(function ($items) {
        //     return count($items);
        // })->sortKeys();

        $grouped = $attemptsFiltered->pluck('total', 'jour')->sortKeys();
        
        // Générer les labels (ex : 01/07, 02/07, etc.)
        $labels = collect($grouped->keys())->map(function ($date) {
            return Carbon::parse($date)->format('d/m');
        })->toArray();
        
        $counts = $grouped->values()->toArray();
        // Construire le dataset pour le graphique
        $this->chartData = [
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Tentatives de quiz',
                'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'data' => $counts,
                'fill' => true,
                'tension' => 0.3,
            ]]
        ];

    }
    public function render()
    {
        return view('livewire.quiz-participation-graph');
    }

}
