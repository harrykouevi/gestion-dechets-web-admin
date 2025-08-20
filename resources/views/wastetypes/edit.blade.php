@extends('layouts.app')

@section('title', '🎯 Crée ton Post !')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- style sheets and font icons  -->
    <link rel="stylesheet" href="{{ asset('css/accounting.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">


<style>
   body {
        background: #f7f9fb;
        font-family: 'Segoe UI', 'Roboto', sans-serif;
    }
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .btn-primary {
        background-color: #4da6ff;
        border-color: #4da6ff;
    }
    .btn-primary:hover {
        background-color: #3399ff;
    }

     .custom-checkbox {
        transition: all 0.3s ease-in-out;
        border: 1px solid #0d6efd;
        width: 2rem;
        height: 1rem;
        cursor: pointer;
    }

    .custom-checkbox:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }

    .form-check-label {
        margin-left: 0.5rem;
    }
</style>
@endpush



@section('content')
    <!-- Fil d’Ariane -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">🏠 Tableau de bord</a>
            </li>
             <li class="breadcrumb-item active" aria-current="page">
                Gestion des collectes
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('types-dechets.index') }}">Type de déchets</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Formulaire
            </li>
        </ol>
    </nav>

    <!-- Titre principal + bouton retour -->

    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary mb-0">
                {{ isset($id) ? '✏️ Mise à jour de ton type' : '🎉 Création d’un nouveau type' }}
            </h2>
            <a href="{{ route('types-dechets.index') }}" class="btn btn-sm btn-secondary">
                ← Retour à la liste des Déclaration de collectes
            </a>
        </div>
        <p class="text-muted">
            En route pour un nouveau défi intellectuel 😎 !<br>
            Complète les champs ci-dessous pour créer un post amusant et éducatif.
        </p>
    </div>





    <div class="card border-0 shadow-lg rounded-4 bg-light-subtle">
        <div class="card-body p-4">


            @livewire('wastetype-form', isset($id) ? ['id' => $id] : [])
        </div>
    </div>


@endsection

@push('scripts')

@endpush
