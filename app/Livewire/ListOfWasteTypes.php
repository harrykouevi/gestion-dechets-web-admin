<?php

namespace App\Livewire;

use Livewire\Component;

class ListOfWasteTypes extends Component
{
    public function render()
    {
        // $wastetype = (new RoadIssueTypeService())->getAll() ;
        $wastetype = [[1],[2],[3]] ;

        return view('livewire.list-of-waste-types', [
            'wastetype' =>  $wastetype,
        ]);
    }
}
