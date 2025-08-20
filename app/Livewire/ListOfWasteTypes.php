<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\WastetypeService;


class ListOfWasteTypes extends Component
{
    public $selectedType = null;
    public $successMessage = Null ;
    public $wastetypeIdToDelete = null;


 
    public function selectType($id){
        
        $this->selectedType = $id;
    }

    public function setwastetypeIdToDelete($id)
    {
        $this->wastetypeIdToDelete = $id;
    }

    public function delete(){
        $this->resetErrorBag();
      
        try{ 
            
            if ($this->wastetypeIdToDelete) {
                $response = app(WastetypeService::class)->delete($this->wastetypeIdToDelete) ; 
           
                if (isset($response['errors'])) {
                    $this->addError('general_erreur', '<p>Une erreur est survenue</p>');
                    foreach ($response['errors'] as $field => $messages) {
                        if(is_string($messages)){
                            foreach (['id',"nom" ,"description", "prix","unite","actif"] as $needle) {
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
                    $this->reset('wastetypeIdToDelete');
                    // Déclenche l’événement JS
                    $this->dispatch('post-deleted');
                }
            }
            
          
            
        }catch (\Exception $e) {
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
    }

    public function render()
    {
        $wastetype = (new WastetypeService())->getAll() ;
        return view('livewire.list-of-waste-types', [
            'wastetype' =>  $wastetype,
        ]);
    }
}
