<?php

namespace App\Livewire;

use Livewire\Component;

class ListOfDeclarations extends Component
{
    public function render()
    {
        $declarations = [[1],[2],[3]] ;
        return view('livewire.list-of-declarations', [
            'declarations' => $declarations,
        ]);
    }
}
