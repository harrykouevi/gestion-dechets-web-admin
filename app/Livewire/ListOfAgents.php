<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\AgentService;


class ListOfAgents extends Component
{

    public $selectedAgent = null;
    public ?string $filterType = null;
    public ?string $filterStatus = null;
    public $cachedCollect ;



    public function selectAgent($id){
        $this->selectedAgent =  $this->cachedCollect->firstWhere('id', $id);

    }

    public function render()
    {
        $this->cachedCollect = $agents = (new AgentService())->getAll() ;

        return view('livewire.list-of-agents', [
            'agents' => $agents,
        ]);
    }
}
