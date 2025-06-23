<?php

namespace App\Livewire;

use Livewire\Component;

class AgentForm extends Component
{
    public $agent;
    public $agentId;
    public $description;
    public $addresse;
    public $report_type_id;
    public $latitude ;
    public $longitude ;
    public $incidentTypes ;


    public function mount($id = null)
    {
        if ($id) {
            // $this->agent = $agent = (new agentService())->get($id) ;
            $this->agent = [1] ;
            $this->agentId = 1;
            // $this->description = $agent['description'];
            // $this->addresse = $agent['addresse'] ;
            // $this->report_type_id = $agent['report_type_id'];
            // $this->latitude = $agent['latitude'];
            // $this->longitude = $agent['longitude'];
            // $this->email = $agent['email'];
        }
    }

    public function save()
    {
        
        $this->resetErrorBag();
        try{ 
            $data = $this->validate([
                'addresse' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'report_type_id' => 'nullable',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
            ]);

            if ($this->agentId) {
                // $response = (new agentService())->update($this->agentId,$data) ; 
            } else {
                // $response = (new agentService())->create($data) ; 
            }

            // if ($response['success']== true) {

            //     session()->flash('message', 'Problème signalé avec succès.');
            //     return redirect()->route('agents.index');

            // } elseif ($response['success']== false) {
    
            //     $err = $response['errors'];
            //     foreach ($err as $field => $messages) {
            //         foreach ($messages as $message) {
            //             $this->addError('_mess_', $message);
            //         }
            //     }
            //     session()->flash('message', 'Probleme survenu.');
            // } 
        }catch (\Exception $e) {
            $this->addError('general', 'Erreur : ' . $e->getMessage());
        }
            
    }

    
    public function render()
    {
        return view('livewire.agent-form');
    }
}
