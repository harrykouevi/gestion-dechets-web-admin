<?php

namespace App\Livewire;

use App\Services\AddressService;
use App\Services\MenageService;
use App\Services\RequestCollectService;
use Livewire\Component;

class ListOfMenages extends Component
{
    public string $mode = 'incident';



    public $zones = [[1],[2],[3]]  ;

    public $selectedMenage = null;
    public $cachedlist ;
    public $userRequestList ;
    public $userAddressList ;


    public ?string $filterType = null;
    public ?string $filterStatus = null;

    public ?float $incidentLatitude = null;
    public ?float $incidentLongitude = null;
    public ?float $incidentRadius = null;

    public ?float $departureLatitude = null;
    public ?float $departureLongitude = null;
    public ?float $arrivalLatitude = null;
    public ?float $arrivalLongitude = null;



    public function selectMenage($id){
        // dd($this->cachedlist->firstWhere('id', $id)) ;
        $this->selectedMenage =  $this->cachedlist->firstWhere('id', $id);
        $this->userRequestList = app(RequestCollectService::class)->getAll($id,['relation']) ;
        $this->selectedMenage['requestesolvedcount'] = $this->userRequestList->where('statut', 'termine')->count() ;
        $this->userAddressList = app(AddressService::class)->getByUser($id,['relation']) ;

    }

    public function mount()
    {

    }

    public function updated($property)
    {
        $this->updateIframeUrl();
    }



    public function loadList()
    {
        return  app(MenageService::class)->getAll(['quizz']) ;
    }

    public function render()
    {
        $this->cachedlist = $menages = $this->loadList() ;
        return view('livewire.list-of-menages', [
            'menages' => $menages,
        ]);
    }
}
