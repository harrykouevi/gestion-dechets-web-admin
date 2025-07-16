<?php

namespace App\Livewire;

use App\Services\QuizService;
use App\Services\RewardService;
use Livewire\Component;

class ListOfRewards extends Component
{
    public string $mode = 'incident';
   
    public $urlparams = [] ;
    public ?string $endpoint = '';

    public $selectedRewards = null;

    public ?string $filterType = null;
    public ?string $filterStatus = null;

   
    // Dans ton composant Livewire
    public $rewardIdToDelete = null;

  

    public $successMessage = Null ;
    private RewardService $RewardService;

    public function mount(RewardService $RewardService)
    {
        $this->RewardService = $RewardService;
    }

    public function setrewardIdToDelete($id)
    {
        $this->rewardIdToDelete = $id;
    }


    public function applyFilters()
    {
    }

    public function selectQuiz($id){
        $this->selectedRewards = $id;
    }

    
    public function delete(){
        $this->resetErrorBag();
        $RewardService = app(RewardService::class);
      

        try{ 
        
            if ($this->rewardIdToDelete) {
                $response = $RewardService->delete($this->rewardIdToDelete) ; 
           
                if (isset($response['errors'])) {
                    $this->addError('general_erreur', '<p>Une erreur est survenue</p>');
                    foreach ($response['errors'] as $field => $messages) {
                        if(is_string($messages)){
                            foreach (['id','titre', 'content','type','description'] as $needle) {
                                if (str_contains($messages, $needle)) {
                                    $this->addError('post_'.$needle, str_replace("Validation Error:", '', $messages));
                                }
                            }
                        }
                        foreach ((array)$messages as $message) {
                            $this->addError($field, $message);
                        }
                    }
                    
                }

                if (isset($response['success']) && $response['success'] == true) {
                    $this->successMessage = "Opération réussie !";
                    $this->reset('rewardIdToDelete');
                    $this->dispatch('post-deleted');
                }
            }
            
          
            
        }catch (\Exception $e) {
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
    }

    


    public function loadList()
    {
        // return  app(RewardService::class)->getAll() ;
        $j = app(QuizService::class)->getAll(['rewards']) ;
        $j = collect($j->flatMap(function ($item) {
                return collect($item['rewards'])->map(function ($reward) use ($item) {
                    $reward['quizzId'] = $item['id'];
                    return $reward;
                });
            }))->sortBy('id')->values();
                    // dd($j) ;
        return  $j ;
    }

    public function render()
    {
        $rewards = $this->loadList() ;
        return view('livewire.list-of-rewards', [
            'datas' => $rewards,
        ]);
    }
}
