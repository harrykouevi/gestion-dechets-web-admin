@extends('layouts.app')

@section('title', 'Les types de déchets')



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
            <li class="breadcrumb-item active" aria-current="page">
                Type de déchets
            </li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-2 text-gray-800">Les types de déchets</h1>
    </div>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Content Row -->

    @livewire('list-of-waste-types') <!-- Include the Livewire component -->
    <!-- Page Heading -->




@endsection
