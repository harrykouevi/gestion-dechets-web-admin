<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\WastetypeService;


class WastetypeForm extends Component
{

    public $successMessage = Null ;
    public $wastetypeId;
    public $wastetype;

    public $wastetype_medias = []; // Chaque élément : ['file' => UploadedFile, 'type' => string]
    public $medias_to_show = []; // Chaque élément : ['file' => UploadedFile, 'type' => string]
    public $existing_medias_last_index =0 ;
    public $wastetype_description ; 
    public $wastetype_nom ; 
    public $wastetype_prix ; 
    public $wastetype_unite = "Kg"; 
    public $wastetype_actif = 0; 
   
    public function mount( $id = null)
    {
        if ($id) {
            $this->wastetype = $wastetype = app(WastetypeService::class)->get($id,['medias']) ;
            $this->wastetypeId = $wastetype['id'];
            $this->wastetype_nom = $wastetype['nom'];
            $this->wastetype_prix = $wastetype['prix'] ;
            $this->wastetype_description = $wastetype['description'] ?? "" ;
            $this->wastetype_unite = $wastetype['unite'] ;
            $this->wastetype_actif = $wastetype['actif'] == true ? 1 : 0 ;

            // $this->medias_to_show = $wastetype['medias'] ;
            // $this->existing_medias_last_index = count($this->medias_to_show) - 1 ;
        }
    }

    public function save()
    {
        $this->resetErrorBag();
        $wastetypeService = app(WastetypeService::class);
        $data_v = $this->validate([
                'wastetype_nom' => 'required|string|max:255',
                'wastetype_prix' => 'required|int',
                'wastetype_description' => 'required|string|max:255',
                'wastetype_unite' => 'required|string',
                'wastetype_actif' => 'required|boolean',
              
            ],[
                'wastetype_nom.required' => 'The titre field is required.',
                'wastetype_prix.required' => 'The content field is required.',
                'wastetype_description.required' => 'The description field is required.',
                'wastetype_unite.required' => 'The type field is required.',
                'wastetype_actif.required' => 'The status field is required.',
            ]
        );

       
        try{ 
            
            $data = [
                'nom' => $data_v['wastetype_nom'],
                'description' => array_key_exists('wastetype_description',$data_v)? $data_v['wastetype_description'] : Null ,
                'prix' => $data_v['wastetype_prix'],
                'unite' => ucfirst(strtolower($data_v['wastetype_unite'])),
                'actif' => $data_v['wastetype_actif'] == 1 ? 1 : 0,
            ];

            if ($this->wastetypeId) {
                $response = $wastetypeService->update($this->wastetypeId,$data) ; 
            } else {
                $response = $wastetypeService->create($data) ; 
            }
            if (isset($response['errors'])) {
                $this->addError('general_erreur', '<p>Une erreur est survenue</p>');
                foreach ($response['errors'] as $field => $messages) {
                    if(is_string($messages)){
                        foreach (['id',"nom","description","prix","unite","actif"] as $needle) {
                            if (str_contains($messages, $needle)) {
                                $this->addError('wastetype_'.$needle, str_replace("Validation Error:", '', $messages));
                            }
                        }
                    }
                    foreach ((array)$messages as $message) {
                        $this->addError($field, $message);
                    }
                }
                
            }
        

            if (isset($response['success']) && $response['success'] == true) {
                session()->flash('success', 'Opération réussie !');
                $this->successMessage = "Opération réussie !";
                return redirect()->route('types-dechets.edit',['id'=>$response['data']['id']]);
            
            }

        }catch (\Exception $e) {
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
    }

    public function render()
    {
        return view('livewire.wastetype-form');
    }
}
