@extends('layouts.app')

@section('content')
<!-- Fil d’Ariane -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb ">
        <li class="breadcrumb-item">
            <a href="{{ route('posts.index') }}">🗂️ Posts éducatifs</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('posts.index', ['report' => true]) }}">📊 Rapports</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Résultats du quiz</li>
    </ol>
</nav>



<!-- Titre principal -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-gray-800 mb-0">📋 Résultats au quiz</h1>
        <small class="text-muted">Utilisateur : <strong>{{ $user }}</strong></small>
    </div>
    <a href="{{ route('posts.index', ['report' => true]) }}" class="btn btn-sm btn-secondary">
        ← Retour
    </a>
</div>

<!-- Statistiques générales -->
<section class="mb-5">
    <h4 class="mb-4">📈 Stat générale</h4>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="border rounded p-3 shadow-sm bg-white h-100">
                <div class="text-muted small">Score moyen global</div>
                <div class="h5 mb-0">{{ $statforAllParticipedQuiz['avg_global_score'] }}%</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border rounded p-3 shadow-sm bg-white h-100">
                <div class="text-muted small">Classement global</div>
                <div class="h5 mb-0">#{{ $statforAllParticipedQuiz['classement_global'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border rounded p-3 shadow-sm bg-white h-100">
                <div class="text-muted small">Quiz tentés</div>
                <div class="h5 mb-0">{{ $statforAllParticipedQuiz['nb_total_quizz'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border rounded p-3 shadow-sm bg-white h-100">
                <div class="text-muted small">Quiz validés</div>
                <div class="h5 mb-0">{{ $statforAllParticipedQuiz['nb_quizz_valides'] }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Détail du quiz -->
<section class="mb-5">
    <h4 class="mb-4">🧾 Résumé détaillé du quiz {{ $quiz['id'] }}</h4>
    <div class="row g-4">
        @foreach ($statforAllParticipedQuiz['quizz'] as $quizzStats)
            <div class="col-md-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <!-- Titre du quiz -->
                        <h5 class="card-title mb-3"> 🧪 ID du quiz : {{ $quizzStats['quizz_id'] }} </h5>

                        <!-- Informations générales -->
                        <div class="mb-4">
                            <p class="mb-1"><strong>📘 Post :</strong> {{ $quizzStats['titre_post'] }}</p>
                            <p class="mb-1"><strong>🎯 Points totaux :</strong> {{ $quizzStats['total_quizz_points'] }} pts</p>
                            <p class="mb-1"><strong>👥 Participants :</strong> {{ $quizzStats['total_participant'] ?? $user }}</p>
                            <p class="mb-1"><strong>🎓 Classement :</strong> {{ $quizzStats['rang_utilisateur'] }}</p>
                        </div>

                        <!-- Statistiques de performance avec style personnalisé -->
                        <div class="mb-4 p-3 rounded" style="background-color: #f8f9fa;">
                            <h6 class="text-muted mb-3">📈 Statistiques de performance</h6>

                            <ul class="list-group list-group-flush">
                                <li class=" d-flex justify-content-between" style="border-top: 1px solid rgba(0, 0, 0, 0.125); ">
                                    <span>Total de tentatives :</span>
                                    <span class="fw-bold">{{ $quizzStats['nb_total'] }}</span>
                                </li>
                                <li class=" d-flex justify-content-between" style="border-top: 1px solid rgba(0, 0, 0, 0.125); ">
                                    <span>Réussites :</span>
                                    <span class="fw-bold text-success">{{ $quizzStats['nb_valides'] }}</span>
                                </li>
                                <li class=" d-flex justify-content-between" style="border-top: 1px solid rgba(0, 0, 0, 0.125); ">
                                    <span>Score moyen :</span>
                                    <span class="fw-bold text-primary">{{ $quizzStats['avg_score'] }} pts</span>
                                </li>
                                <li class=" d-flex justify-content-between" style="border-top: 1px solid rgba(0, 0, 0, 0.125); ">
                                    <span>Score maximal obtenu :</span>
                                    <span class="fw-bold text-success">{{ $quizzStats['max_score'] }} pts</span>
                                </li>
                            
                            
                                
                            </ul>
                        </div>

                        <h5 class="mb-3">🕓 Tentatives de l’utilisateur</h5>
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <thead class="border-bottom text-muted small">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Score</th>
                                        <th>Validation</th>
                                        <th>Questions / Reponses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse ($attempsforquiz as $index => $attempt)
                                    @php $collapseId = 'collapseAttempt' . $index; @endphp

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($attempt['attemptAt'])->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="">
                                                {{ $attempt['score'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class=" ">
                                                {{ $attempt['isValidated'] ? '✅ Oui' : '❌ Non' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-info" type="button" data-toggle="collapse" data-target="#{{ $collapseId }}">
                                                voir
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Ligne collapse -->
                                    <tr class="collapse bg-white" id="{{ $collapseId }}">
                                        <td colspan="5">
                                            <div class="p-4 bg-light rounded border shadow-sm">
                                                <h6 class="text-primary mb-3">Détail des questions & réponses</h6>

                                                @foreach ($attempt['questions'] as $qIndex => $q)
                                                    @php
                                                        // Recherche de la question dans le quiz_data
                                                        $questiontodisplay = collect($quiz_data['questions'])->firstWhere('id', $q['questionId']);

                                                        // Préparation des réponses attendues
                                                        $expectedAnswer = collect($questiontodisplay['reponses'])->firstWhere('isCorrect', true);
                                                    @endphp

                                                    <div class="mb-4  border-bottom">
                                                        <p class="mb-1 fw-semibold">
                                                            Question {{ $qIndex + 1 }} <span class="text-muted">#{{ $q['questionId'] }}</span>
                                                        {{ $questiontodisplay['texte'] ?? 'Texte non disponible' }}</p>

                                                        <div class="mb-1">
                                                            <small class="text-muted">Réponse(s) choisie(s) :</small>
                                                            <ul class="ps-3">
                                                                @foreach ($q['reponses'] as $r)
                                                                    @php
                                                                        $reponse = collect($questiontodisplay['reponses'])->firstWhere('id', $r['reponseId']);
                                                                    @endphp
                                                                    <li class="text-dark">ID : <code>#{{ $r['reponseId'] ?? 'inconnue' }} {{ $reponse['texte'] ?? 'Réponse inconnue' }}</code></li>
                                                                    @if ($reponse['points'] ?? 0 > 0)
                                                                    <li class="text-dark"><small class="text-muted">Points : <code> {{ $reponse['points'] }}</small></code></li>
                                                                    @endif
                                                                        <span class="badge rounded-pill bg-{{ !empty($reponse['isCorrect']) ? 'success' : 'danger' }}">
                                                                            {{ !empty($reponse['isCorrect']) ? '✅ Bonne réponse' : '❌ Mauvaise réponse' }}
                                                                        </span>
                                                                    
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                        @if (!empty($expectedAnswer) && !$reponse['isCorrect'])
                                                            <div class="mb-1">
                                                                <small class="text-muted">✅ Réponse attendue :</small>
                                                                <p class="text-dark ">{{ $expectedAnswer['texte'] ?? 'Réponse manquante' }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>


                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Aucune tentative trouvée.</td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        @endforeach
    </div>
</section>



@endsection


@push('script')
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (inclut Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush