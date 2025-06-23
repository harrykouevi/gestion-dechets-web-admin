<?php

namespace App\Livewire;

use Livewire\Component;

class ListOfAgents extends Component
{
    public string $mode = 'incident';
   
    public $urlparams = [] ;
    public ?string $endpoint = '';

    public $selectedAgent = null;

    public ?string $filterType = null;
    public ?string $filterStatus = null;

    public ?float $incidentLatitude = null;
    public ?float $incidentLongitude = null;
    public ?float $incidentRadius = null;

    public ?float $departureLatitude = null;
    public ?float $departureLongitude = null;
    public ?float $arrivalLatitude = null;
    public ?float $arrivalLongitude = null;

    public function applyFilters()
    {
        if ($this->mode === 'incident') {
            // Appliquer les filtres incidents
            $this->urlparams = [
               
                'lat' => $this->incidentLatitude,
                'lng' => $this->incidentLongitude,
                'radius' => $this->incidentRadius,
            ];


            $this->endpoint = route('map-incidents') ;

            //lat=6.1751&lng=1.2123&radius=1000
        } elseif ($this->mode === 'itineraire') {
            // Appliquer la recherche d'itinéraire
            $this->urlparams = [
               
                'start' => $this->departureLatitude.','.$this->departureLongitude,
                'end' => $this->arrivalLatitude.','.$this->arrivalLongitude,
                'alternatives' => 3,
            ];


            $this->endpoint = route('map-directions') ;
            //start=6.1725,1.2314&end=6.1865,1.2200&alternatives=3
        }
    }

    public function selectAgent($id){
        // $this->selectedAgent = (new RoadissueService())->get($id) ;
        // $this->urlparams = [
               
        //         'lat' => $this->selectedAgent["latitude"],
        //         'lng' => $this->selectedAgent["longitude"],
        //         'radius' => 1,
        // ];


        // $this->endpoint = route('map-incidents') ;
        $this->selectedAgent = [1];

    }

    public function mount()
    {
        // Au départ, pas de filtres appliqués
        $this->appliedFilters = [
            'per_page' => 20
        ];
    }

    public function updated($property)
    {
        $this->updateIframeUrl();
    }



    public function loadRoadIssues()
    {

        // $page = (new RoadissueService())->fetchRoadIssues($this->appliedFilters);
        
        // $collection = collect($page['data']);
        return  [[1],[2],[3]] ;
        
    }

    public function render()
    {
        $agents = $this->loadRoadIssues() ;
        return view('livewire.list-of-agents', [
            'agents' => $agents,
        ]);
    }
}
