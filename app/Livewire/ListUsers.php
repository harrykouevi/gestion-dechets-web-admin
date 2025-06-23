<?php

namespace App\Livewire;

use App\Services\UserService;
use Livewire\Component;
use Livewire\WithPagination;


class ListUsers extends Component
{
    use WithPagination;

    public $showActions = true;
    public $showHeaders = true ;
    public $defaultPerPage = 10;
    public $columnsToNotShow = [];
    public $perPage;
    public $search = ''; // Property for search functionality

    public function mount($showActions = true, $defaultPerPage = 10, $columnsToNotShow = [])
    {
        $this->showActions = $showActions;
        $this->defaultPerPage = $defaultPerPage;
        $this->columnsToNotShow = $columnsToNotShow;
        $this->perPage = $this->defaultPerPage;
    }

    public function render()
    {
        //  $annonces = (new UserService())->search($this->search)->paginate(8) ;
        // $users = (new UserService())->getAll() ;
        $users = [[1],[2],[3]] ;
        return view('livewire.list-users', [
            'users' => $users,
        ]);
    }

    
    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when search query changes
    }


}
