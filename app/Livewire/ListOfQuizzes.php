<?php

namespace App\Livewire;

use App\Services\QuizService ;
use Livewire\Component;

class ListOfQuizzes extends Component
{
    public string $mode = 'incident';
   
    public $urlparams = [] ;
    public ?string $endpoint = '';

    public $selectedQuiz = null;

    public ?string $filterType = null;
    public ?string $filterStatus = null;

    public ?float $incidentLatitude = null;
    public ?float $incidentLongitude = null;
    public ?float $incidentRadius = null;

    // Dans ton composant Livewire
    public $quizIdToDelete = null;

    public ?float $departureLatitude = null;
    public ?float $departureLongitude = null;
    public ?float $arrivalLatitude = null;
    public ?float $arrivalLongitude = null;

    public $successMessage = Null ;
    private QuizService $quizService;

    public function mount(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function setQuizIdToDelete($id)
    {
        $this->quizIdToDelete = $id;
    }


    public function applyFilters()
    {
    }

    public function selectQuiz($id){
        $this->selectedQuiz = $id;
    }

    
    public function delete(){
        $this->resetErrorBag();
        $quizService = app(QuizService::class);
      

        try{ 
        
            if ($this->quizIdToDelete) {
                $response = $quizService->delete($this->quizIdToDelete) ; 
           
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
                    $this->reset('quizIdToDelete');
                    $this->dispatch('post-deleted');
                }
            }
            
          
            
        }catch (\Exception $e) {
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
    }

    


    public function loadList()
    {
        return  app(QuizService::class)->getAll(['quizz']) ;
    }

    public function render()
    {
        $quizzes = $this->loadList() ;
        return view('livewire.list-of-quizzes', [
            'datas' => $quizzes,
        ]);
    }
}
