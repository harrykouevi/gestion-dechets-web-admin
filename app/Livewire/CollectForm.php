<?php

namespace App\Livewire;

use App\Services\CollectService;
use Livewire\Component;

class CollectForm extends Component
{

    public $successMessage = Null ;
    public $collectId;
    public $collect;
    public $collect_content ;
    public $collect_longitude ;
    public $collect_description ;
    public $collect_adresse_id ;
    public $collect_latitude ;
    public $collect_instructions ;
    public $collect_date_demande ;
    public $collect_user_id  ;
    public $collect_dechet_id ;

    public $collect_medias = []; // Chaque élément : ['file' => UploadedFile, 'type' => string]
    public $medias_to_show = []; // Chaque élément : ['file' => UploadedFile, 'type' => string]
    public $existing_medias_last_index =0 ;
    

    public function mount( $id = null)
    {
        if ($id) {
            $this->collect = $collect = app(CollectService::class)->get($id,['medias']) ;
            $this->collectId = $collect['id'];
            $this->collect_longitude = $collect['longitude'];
            $this->collect_latitude = $collect['latitude'] ;
            $this->collect_description = $collect['description'] ?? "" ;
            $this->collect_adresse_id = $collect['adresse_id'] ;
            $this->collect_instructions = $collect['instructions'] ;
            $this->collect_date_demande = $collect['date_demande'] ;
            $this->collect_user_id = $collect['user_id'] ;
            $this->collect_dechet_id = $collect['dechet_id'] ;

            // $this->medias_to_show = $collect['medias'] ;
            // $this->existing_medias_last_index = count($this->medias_to_show) - 1 ;
    
        }
    }

    public function save()
    {
        $this->resetErrorBag();
        $collectService = app(CollectService::class);
        $data_v = $this->validate([
               
                'collect_longitude' => 'required|string',
                'collect_description' => 'required|string',
                'collect_latitude' => 'required|string',
                'collect_instructions' => 'required|string',
                'collect_date_demande' => 'required|string',
                'collect_adresse_id' => 'required|string',
                'collect_user_id'  => 'required|string',
                'collect_dechet_id' => 'required|string',
              
            ],[
                // 'collect_nom.required' => 'The titre field is required.',
                // 'collect_prix.required' => 'The content field is required.',
                // 'collect_description.required' => 'The description field is required.',
                // 'collect_unite.required' => 'The type field is required.',
                // 'collect_actif.required' => 'The status field is required.',
            ]
        );

       
        try{ 
            
            $data = [
                'adresse_id' => $data_v['collect_adresse_id'],
                'user_id' => $data_v['collect_user_id'],
                'dechet_id' => $data_v['collect_dechet_id'],
                'longitude' => $data_v['collect_longitude'],
                'latitude' => $data_v['collect_latitude'],
                'instructions' => $data_v['collect_instructions'],
                'description' => array_key_exists('collect_description',$data_v)? $data_v['collect_description'] : Null ,
                'date_demande' => $data_v['collect_date_demande'],
            ];

            if ($this->collectId) {
                $response = $collectService->update($this->collectId,$data) ; 
            } else {
                $response = $collectService->create($data) ; 
            }
            if (isset($response['errors'])) {
                $this->addError('general_erreur', '<p>Une erreur est survenue</p>');
                foreach ($response['errors'] as $field => $messages) {
                    if(is_string($messages)){
                        foreach (['id','adresse_id','user_id','dechet_id','longitude','latitude','instructions','description','date_demande'] as $needle) {
                            if (str_contains($messages, $needle)) {
                                $this->addError('collect_'.$needle, str_replace("Validation Error:", '', $messages));
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
                return redirect()->route('collectes.edit',['id'=>$response['data']['id']]);
            
            }

        }catch (\Exception $e) {
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
    }

    public function render()
    {
        return view('livewire.collect-form');
    }
}
