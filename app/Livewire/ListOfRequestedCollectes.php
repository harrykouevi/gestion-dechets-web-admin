<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\RequestCollectService;

class ListOfRequestedCollectes extends Component
{

    public $selectedCollect = null;
    public $cachedCollect ;
    public bool $isCollapsed = false;
    public $filterstatus ;


    public function selectCollect($id){

        $this->selectedCollect =  $this->cachedCollect->firstWhere('id', $id);
        $this->dispatch('updateMap',[
                'longitude' => $this->selectedCollect['longitude'],
                'latitude'  => $this->selectedCollect['latitude'],
                'where' => ""
            ]
        );
    }


    public function toggleCollapse()
    {
        $this->isCollapsed = ! $this->isCollapsed;
    }


    public function loadList()
    {
        $params = [];
        if ($this->filterstatus) {
            $params['statut'] = $this->filterstatus;
            // dd($this->filterstatus) ;
        }

        return  app(RequestCollectService::class)->getAll(null,[...$params,'relation']) ;
    }

    public function render()
    {
        $this->cachedCollect = $data = $this->loadList() ;

        return view('livewire.list-of-requested-collectes', [
            'datas' => $data,
        ]);
    }
}

