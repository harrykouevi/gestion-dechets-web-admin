@extends('layouts.app')

@section('title', 'Agents de collecte')



@section('content')
    <!-- Fil d'Ariane -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">🏠 Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Gestion des collectes
            </li>
        </ol>
    </nav>

    <!-- Titre principal + bouton retour -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>{{ isset($id) ? 'Mis à jour d\'un agent de collecte' : 'Enregistrement d\'un agent de collecte' }}</h3>
    <p class="text-muted">
        Veuillez remplir les champs ci-dessous pour {{ (isset($id) && $id) ? "mettre à jour" : "enregistrer" }} un agent de collecte.
        Assurez-vous que les informations sont exactes avant de valider.
    </p>

    @livewire('agent-form', isset($id) ? ['id' => $id] : [])




@endsection
