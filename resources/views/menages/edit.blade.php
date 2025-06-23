@extends('layouts.app')

@section('title', 'Ménages')



@section('content') 
    <h3>{{ isset($id) ? 'Mis à jour d\'un ménage' : 'Enregistrement d\'un ménage' }}</h3>
    <p class="text-muted">
        Veuillez remplir les champs ci-dessous pour {{ (isset($id) && $id) ? "mettre à jour" : "enregistrer" }} un ménage.
        Assurez-vous que les informations sont exactes avant de valider.
    </p>
    
    @livewire('menage-form', isset($id) ? ['id' => $id] : [])
  
    
    

@endsection