@extends('layouts.app')

@section('title', 'Rapports & Statistiques')



@section('content') 
    <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="">🗂️ Gestion des posts éducatifs</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            📊 Rapports généraux
        </li>
    </ol>
    </nav>
    <!-- Titre principal -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 mb-0">📊 Rapports généraux</h1>
        <a href="" class="btn btn-sm btn-secondary">
            ← Retour à la gestion des posts
        </a>
    </div>
    <p class="mb-4">Analyse des performances des utilisateurs, des contenus éducatifs et de la participation aux quizzes.</p>

    <!-- 📈 Graphe de participation -->
    <div class="row mb-4">
        <div class="col-lg-6">
            @livewire('quiz-participation-graph') 
        </div>
        <div class="col-lg-6">
             @livewire('quiz-leaderboard') 
        </div>
    </div>



    <!-- 📊 Comparaison de performances par contenu -->
    <div class="row mb-4">
        
        <div class="col-lg-12" >
            <livewire:content-performance-comparison wire:poll.5s />
        </div>
    </div>

    <!-- 📊 Les posts les plus lus -->
    <div class="row mb-4">
        
        <div class="col-lg-12" >
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-info">📊 Les contenus éducatifs les plus vues</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="incidentTypesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>Titre</th>
                                    <th>Extrait</th>
                                    <th>Nombre de vues</th>
                                    <th>Date de création</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr>
                                    {{-- <td>{{ array_key_exists("id", $data['post'] ) ?  $data['post']['id'] : 1}}</td> --}}
                                    <td>{{ array_key_exists("titre", $data['post'] ) ?  $data['post']['titre'] : 'titre' }}</td>
                                    <td>{{ array_key_exists("content", $data['post'] ) ? Str::limit(strip_tags($data['post']['content']), 60) : '...' }}</td>
                                    
                                    
                                    <td>{{ array_key_exists("vues", $data ) ?  $data['vues'] : 'vues' }}</td>
                                    <td>{{ array_key_exists("createdAt", $data['post'] ) ? \Carbon\Carbon::parse( $data['post']['createdAt'])->format('d M Y') : '2025-05-13' }}</td>
                                    <td>
                                        
                                        <a href="{{ route('posts.edit',  ['id' => $data['post']['id']]) }}" class="btn btn-sm btn-warning">✏️ Modifier</a>
                                      
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   
@endpush
