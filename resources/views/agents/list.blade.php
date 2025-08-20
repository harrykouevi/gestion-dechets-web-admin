@extends('layouts.app')

@section('title', 'Agents de collectes')



@section('content')
    <!-- Fil d'Ariane -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">🏠 Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Agents de collecte
            </li>
        </ol>
    </nav>

    <!-- Titre principal + bouton retour -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-2 text-gray-800">Agents de collecte</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">
            ← Retour au tableau de bord
        </a>
    </div>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Content Row -->

    @livewire('list-of-agents') <!-- Include the Livewire component -->

@endsection
