<?php

namespace App\Livewire;

use App\Services\MenageService;
use Livewire\Component;

class MenageForm extends Component
{
    
    public $menage;
    public $menageId;
    public $nom;
    public $prenom;
    public $addresse;
    public $telephone ;
    public $email ;
    public $report_type_id;
    public $latitude ;
    public $longitude ;
    public $incidentTypes ;
    public $password ;
    public $password_confirmation ;

    public $successMessage = Null ;


    public function mount($id = null)
    {
        if ($id) {
            // $this->menage = $menage = (new menageService())->get($id) ;
            $this->menage = [1] ;
            $this->menageId = 1;
            // $this->nom = $menage['nom'];
            // $this->addresse = $menage['addresse'] ;
            // $this->report_type_id = $menage['report_type_id'];
            // $this->latitude = $menage['latitude'];
            // $this->longitude = $menage['longitude'];
            // $this->email = $menage['email'];
        }
    }

    public function save()
    {
        
        $this->resetErrorBag();
        $data = $this->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'email',
                'telephone' => 'string|min:8|regex:/^\d{8}$/',
                'password' => 'required|confirmed|min:6',
                // 'password' => 'required|confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'password_confirmation' => 'required',
            ]);
        try{ 
            
            if ($this->menageId) {
                // $response = (new menageService())->update($this->menageId,$data) ; 
            } else {
                $response = (new MenageService())->create($data) ; 
                if (isset($response['errors'])) {
                    $this->addError('general_erreur', 'Une erreur est survenue');
                    foreach ($response['errors'] as $field => $messages) {
                        if(is_string($messages)){
                            foreach (['nom','prenom','email','telephone','password','password_confirmation' ] as $needle) {
                                if (str_contains($messages, $needle)) {
                                    $this->addError($needle, $messages);
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
                }
            }

        }catch (\Exception $e) {
            // Ajouter une erreur personnalisée
            json_decode($e->getMessage(), true); // Si c’est du JSON
            $this->addError('general_erreur', 'Une erreur est survenue');
        }
            
    }

    

    public function render()
    {
        return view('livewire.menage-form');
    }
}
