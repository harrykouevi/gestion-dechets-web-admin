@extends('layouts.app')

@section('title', '🎯 Crée ton Post !')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- style sheets and font icons  -->
    <link rel="stylesheet" href="{{ asset('css/accounting.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet"  />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

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
            <li class="breadcrumb-item">
                <a href="{{ route('collectes.index') }}">Gestion des collectes</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ isset($id) ? '✏️ Modifier une collecte' : '🎉 Nouvelle collecte' }}
            </li>
        </ol>
    </nav>

    <!-- Titre principal + bouton retour -->
    
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary mb-0">
                {{ isset($id) ? '✏️ Mise à jour d\'une collecte' : '🎉 Création d’une nouvelle collecte' }}
            </h2>
            <a href="{{ route('collectes.index') }}" class="btn btn-sm btn-secondary">
                ← Retour à la liste des collectes
            </a>
        </div>
        <p class="text-muted">
            En route pour un nouveau défi intellectuel 😎 !<br>
            Complète les champs ci-dessous pour créer un post amusant et éducatif.
        </p>
    </div>
    
    
  
   

    <div class="card border-0 shadow-lg rounded-4 bg-light-subtle">
        <div class="card-body p-4">

        
            @livewire('collect-form', isset($id) ? ['id' => $id] : [])
        </div>
    </div>
    

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- ✅ JS de Leaflet -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

  
    document.addEventListener('DOMContentLoaded', function () {
        let map, marker;
        const toggleMapBtn = document.getElementById('toggleMapBtn');
        const mapSection = document.getElementById('mapSection');
        // const coordsDisplay = document.getElementById('coordsDisplay');

        let component = Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));
        if (!component) return;

        toggleMapBtn.addEventListener('click', () => {
            mapSection.style.display = mapSection.style.display === 'none' ? 'block' : 'none';

            // Initialiser la carte si elle n'existe pas encore
            // if (!map) {
                const map = L.map('map').setView([6.5244, 3.3792], 12); // Exemple: Lagos

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                map.on('click', function(e) {
                    const lat = e.latlng.lat.toFixed(6);
                    const lng = e.latlng.lng.toFixed(6);

                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng).addTo(map);
                    }

                    document.getElementById('longitude').value = lng;
                    document.getElementById('latitude').value = lat;
                    // coordsDisplay.textContent = `${lat}, ${lng}`;

                    // Si Livewire n'utilise pas defer, forcer le sync :
                    component.set('collect_longitude', lng);
                    component.set('collect_latitude', lat);
                });
            // }

            setTimeout(() => map.invalidateSize(), 300); // Pour fixer les erreurs de dimension à l'affichage
        });

        

        $('#user_id').select2({
            placeholder: 'Rechercher un utilisateur...',
            data: [
                { id: 1, text: 'Jean Dupont (jean@email.com)' },
                { id: 2, text: 'Awa Traoré (awa@email.com)' }
            ]
            // ajax: {
            //     // {{--  --}}
            //     url: '',
            //     dataType: 'json',
            //     delay: 250,
            //     data: function (params) {
            //         return { q: params.term };
            //     },
            //     processResults: function (data) {
            //         return {
            //             results: data.map(function (user) {
            //                 return {
            //                     id: user.id,
            //                     text: `${user.name} (${user.email}) - ${user.phone ?? ''}`,
            //                 };
            //             })
            //         };
            //     },
            //     cache: true
            // }
        });

        $('#user_id').on('change', function (e) {
            const componentEl = document.querySelector('[wire\\:id]');
            const component = Livewire.find(componentEl.getAttribute('wire:id'));
            if (!component) {
                alert('Composant Livewire non encore prêt.');
                return;
            }
            let userId = $(this).val();
            component.set('collect_user_id', userId);
        });

        Livewire.on('updateMap', (data) => {
            initMap('mapSection') ;
        });
    });

      
  </script>
@endpush
