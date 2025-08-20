@extends('layouts.app')

@section('title', 'Les posts éducatifs')

@push('styles')
 <!-- ✅ CSS de Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

@endpush

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
        <h1 class="h3 text-gray-800 mb-0">Les collectes</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">
            ← Retour au tableau de bord
        </a>
    </div>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Content Row -->

    @livewire('list-of-collectes') <!-- Include the Livewire component -->



@endsection



@push('scripts')


<!-- ✅ JS de Leaflet -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script>


    window.addEventListener('post-deleted', function () {

        document.getElementById('closeModalLabel').click();

    });

    Livewire.on('updateMap', (data) => {
        initMap('map',  data);
    });


</script>
<!-- JS Bootstrap + Leaflet -->





@endpush
