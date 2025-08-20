<?php

namespace App\Livewire;

use App\Services\AgentService;
use App\Services\CollectService;
use App\Services\MenageService;
use App\Services\RequestCollectService;
use Livewire\Component;

class ListOfCollectes extends Component
{
    public $selectedCollect = null;
    public $collects ;
    public bool $isCollapsed = false;
    public $filterstatus ;


    public function selectCollect($id){

        $this->selectedCollect =  $this->collects->firstWhere('id', $id);
        $this->selectedCollect['agent'] = app(AgentService::class)->get($this->selectedCollect["collecteur_id"]) ;
        $this->selectedCollect['request'] = app(RequestCollectService::class)->get($this->selectedCollect["demande_collecte_id"]) ;


        $this->dispatch('updateMap',[
                'longitude' => $this->selectedCollect['longitude'],
                'latitude'  => $this->selectedCollect['latitude'],
                'where' => $this->selectedCollect['request']['quartier'] .' '. $this->selectedCollect['request']['ville'] ,
            ]
        );
    }



    public function loadList()
    {
        $params = [];
        if ($this->filterstatus) {
            $params['statut'] = $this->filterstatus;

        }
        return  app(CollectService::class)->getAll([...$params,'relation']) ;
    }

    public function render()
    {
        $this->collects = $data = $this->loadList() ;

        return view('livewire.list-of-collectes', [
            'collectes' => $data,
        ]);
    }
}
