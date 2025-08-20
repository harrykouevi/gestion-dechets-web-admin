<?php

namespace App\Livewire;

use App\Services\AgentService;
use Livewire\Component;

class AgentForm extends Component
{
    public $agent;
    public $agentId;
    public $agent_nom;
    public $agent_prenom;
    public $agent_type_collecteur;
    public $agent_email ;
    public $agent_telephone ;
    public $agent_password ;
    public $agent_password_confirmation ;

    public $successMessage = Null ;


    public function mount($id = null)
    {
        if ($id) {
            $this->agent = $agent = app(AgentService::class)->get($id) ;
            $this->agentId = $agent['id'];
            $this->agent_nom = $agent['nom'];
            $this->agent_prenom = $agent['prenom'] ;
            // $this->agent_type_collecteur = $agent['type_collecteur'];
            $this->agent_telephone = $agent['telephone'];
            $this->agent_email = $agent['email'];
        }
    }

    public function save()
    {

        $this->resetErrorBag();
        $agentService = app(AgentService::class);
        $data_v = $this->validate([
            'agent_prenom' => 'required|string|max:255',
            'agent_nom' => 'required|string|max:255',
            'agent_email' => 'required|email',
            'agent_type_collecteur' => 'required|string|in:interne,externe',
            'agent_telephone' => 'nullable',
            'agent_password' => 'required|confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ]);


        try{
            $data = [
                'prenom' => $data_v['agent_prenom'],
                'nom' => $data_v['agent_nom'],
                'prenom' => $data_v['agent_prenom'],
                'email' => $data_v['agent_email'],
                'type_collecteur' => $data_v['agent_type_collecteur'],
                'telephone' => $data_v['agent_telephone'],
            ] ;

            if ($this->agentId) {
                $response = $agentService->update($this->agentId,$data) ;
            } else {
                $data['password'] = $data_v['agent_password'] ;
                $response = $agentService->create($data) ;
            }


            if (isset($response['errors'])) {
                $this->addError('general_erreur', '<p>Une erreur est survenue</p>');
                foreach ($response['errors'] as $field => $messages) {
                    if(is_string($messages)){
                        foreach (['id','prenom','nom','prenom','email','type_collecteur','telephone','password'] as $needle) {
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
                session()->flash('success', 'Opération réussie !');
                $this->successMessage = "Opération réussie !";
                return redirect()->route('agents.edit',['id'=>$response['data']['id']]);

            }


        }catch (\Exception $e) {
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }

    }


    public function render()
    {
        return view('livewire.agent-form');
    }
}
