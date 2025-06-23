@extends('layouts.app')

@section('title', 'Agents de collecte')



@section('content') 
    <h3>{{ isset($id) ? 'Mis à jour d\'un agent de collecte' : 'Enregistrement d\'un agent de collecte' }}</h3>
    <p class="text-muted">
        Veuillez remplir les champs ci-dessous pour {{ (isset($id) && $id) ? "mettre à jour" : "enregistrer" }} un agent de collecte.
        Assurez-vous que les informations sont exactes avant de valider.
    </p>
    
    @livewire('agent-form', isset($id) ? ['id' => $id] : [])
  
    
    

@endsection