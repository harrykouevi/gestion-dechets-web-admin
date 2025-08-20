@extends('layouts.app')

@section('title', 'Tableau de bord')

@push('styles')
<style>

 .second-row .card {
    background-color: #ffffff; /* fond blanc */
    color: #495057; /* texte gris foncé */
    border-radius: 0.375rem;
    box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    padding: 0.75rem 1rem;
    border: 1px solid #dee2e6; /* bordure claire */
    transition: transform 0.15s ease-in-out;
}

.second-row .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.12);
}

.second-row .card .font-weight-bold.text-muted.text-uppercase {
    color: #6c757d; /* gris moyen */
    font-size: 0.75rem;
    letter-spacing: 0.03em;
    margin-bottom: 0.25rem;
}

.second-row .card .h5 {
    color: #212529; /* texte très foncé */
    font-size: 1.1rem;
    font-weight: 600;
}

.second-row .card .fa-2x {
    color: #6c757d;
    opacity: 0.6;
    transition: color 0.3s ease;
}

.second-row .card:hover .fa-2x {
    color: #0d6efd; /* bleu bootstrap à l'hover */
    opacity: 1;
}

.second-row .progress {
    height: 5px;
    background-color: #e9ecef; /* gris clair */
    border-radius: 10px;
    margin-top: 0.5rem;
}

.second-row .progress-bar.bg-info {
    background-color: #0dcaf0; /* cyan bootstrap */
}

.second-row .progress-bar.bg-success {
    background-color: #198754; /* vert bootstrap */
}

</style>
@endpush

@section('content')
    <!-- Page Heading -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/admin">🏠 Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Vue générale
            </li>
        </ol>
    </nav>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Vue générale</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm disabled">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Statistiques clés -->
    {{-- <h4 class="mb-3 text-primary fw-bold">Statistiques clés</h4> --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
        @php
            $stats = [
                ['title' => 'Utilisateurs', 'value' => $user_number, 'icon' => 'fas fa-users', 'color' => 'primary'],
                ['title' => 'Nombre de collectes', 'value' => $collectcount, 'icon' => 'fas fa-recycle', 'color' => 'success'],
                ['title' => 'En attente de collecte', 'value' => $requestcount, 'icon' => 'fas fa-clock', 'color' => 'info'],
                ['title' => 'Agents actifs', 'value' => $agent_number, 'icon' => 'fas fa-user-check', 'color' => 'primary'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="col mb-4">
            <div class="card h-100 border-start border-4 border-left-{{ $stat['color'] }} shadow-sm py-2">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="font-weight-bold text-muted text-uppercase">{{ $stat['title'] }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stat['value'] }}</div>
                        </div>
                        <div class="text-{{ $stat['color'] }}">
                            <i class="{{ $stat['icon'] }} fa-2x"></i>
                        </div>
                    </div>

                    @if(isset($stat['progress']))
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-{{ $stat['color'] }}" role="progressbar" style="width: {{ $stat['progress'] }}%;"
                            aria-valuenow="{{ $stat['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Indicateurs éducatifs -->
    <h5 class="mt-5 mb-3 text-secondary fw-semibold">Indicateurs éducatifs</h5>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3 second-row">
        @php
            $stats = [
                ['title' => '📘 Contenus éducatifs', 'value' => $postcount, 'icon' => 'fas fa-book', 'color' => 'info'],
                ['title' => '🧠 Quizzes associés', 'value' => $quizcount, 'icon' => 'fas fa-question-circle', 'color' => 'info'],
                ['title' => '👤 Participants aux quizzes', 'value' => $quizzParticipantCount, 'icon' => 'fas fa-user-graduate', 'color' => 'info'],
                ['title' => '🏆 Tentatives de quiz', 'value' => $quizAttemptCount, 'key' => 'quizAttemptCount' , 'icon' => 'fas fa-pen-alt', 'color' => 'info'],
                ['title' => '🎯 Taux de réussite global', 'value' => $quizzSuccessRate.'%',  'key' => 'quizzSuccessRate' ,'icon' => 'fas fa-bullseye', 'color' => 'success', 'progress' => $quizzSuccessRate],
                ['title' => '⭐ Moyenne des scores', 'value' => $quizzAverageScore, 'key' => 'quizzAverageScore' , 'icon' => 'fas fa-chart-line', 'color' => 'info'],
            ];
        @endphp

        @foreach($stats as $stat)
        @if(!array_key_exists('key',$stat))
        <div class="col mb-3">
            <div class="card border-start border-4 border-left-{{ $stat['color'] }} shadow-sm py-1">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="font-weight-bold text-muted text-uppercase">{{ $stat['title'] }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{  (isset($stat['progress'])) ? $stat['value'].' %' : $stat['value'] }}</div>
                        </div>
                        <div class="text-{{ $stat['color'] }}">
                            <i class="{{ $stat['icon'] }} fa-1x"></i>
                        </div>
                    </div>

                    @if(isset($stat['progress']))
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-{{ $stat['color'] }}" role="progressbar" style="width: {{ $stat['progress'] }}%;"
                            aria-valuenow="{{ $stat['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @else
            @livewire('board-post-stat-card', ['stat' => $stat])
        @endif
        @endforeach
    </div>

    <hr class="my-5">

    <!-- Analyse détaillée -->
    <h4 class="mb-3 text-primary fw-bold">Analyse détaillée</h4>
    <div class="row g-4 mb-4">
        <!-- Graphique Vue d’ensemble -->
        {{-- <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold m-0 font-weight-bold text-primary">Vue d’ensemble des collectes</span>
                    <select class="form-control shadow-sm rounded-3  w-auto">
                        <option>Cette semaine</option>
                        <option>Ce mois</option>
                        <option>Cette année</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="overviewChart" height="120"></canvas>
                    <div class="mt-4">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Quizzes et Scores -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header fw-bold m-0 font-weight-bold text-primary">🧪 Résultats des quizzes</div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <h2 class="fw-bold">{{ $quizzSuccessRate }}%</h2>
                        <div class="progress mx-auto" style="height: 6px; width: 80%;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $quizzSuccessRate }}%;" aria-valuenow="{{ $quizzSuccessRate }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <ul class="list-group text-start">
                        <li class="list-group-item d-flex justify-content-between"><span>Réussites</span><strong>{{ $quizzSuccessRate }}%</strong></li>
                        <li class="list-group-item d-flex justify-content-between"><span>Participation</span><strong>{{ (is_int($user_number) && $user_number > 0 )? number_format($quizzParticipantCount / $user_number * 100, 1).' %' : $user_number }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mb-4">
            <div class="card shadow">

                <div class="card-body">
                    <div id="vimeo-player-container" style="position: relative; width: 100%; cursor: pointer;">
                        <!-- Tu peux remplacer l'src de l'image par une miniature personnalisée -->
                        {{-- <img src="{{ asset('img/290497-P72QT9-640.jpg') }}"
                            alt="Aperçu Pollution"
                            style="width: 100%; height: auto; display: block;">
                        <!-- Bouton Play centré -->
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
                            background: rgba(0, 0, 0, 0.6); border-radius: 50%; padding: 20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#fff" viewBox="0 0 16 16">
                                <path d="M6.79 5.093a.5.5 0 0 1 .737-.441l4.5 2.407a.5.5 0 0 1 0 .882l-4.5 2.407a.5.5 0 0 1-.737-.441V5.093z"/>
                            </svg>
                        </div> --}}
                         <div style="display: flex; justify-content: center;">
                            <iframe src="https://player.vimeo.com/video/260797186"
                                width="560" height="315" frameborder="0"
                                allow="fullscreen; picture-in-picture"
                                allowfullscreen >
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('overviewChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['L', 'M', 'M', 'J', 'V', 'S', 'D'],
      datasets: [{
        label: 'Collecte',
        data: [200, 400, 300, 500, 600, 800, 700],
        backgroundColor: '#0d6efd'
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById('vimeo-player-container');
    container.addEventListener('click', function () {
        container.innerHTML = `
            <iframe src="https://player.vimeo.com/video/647440729?autoplay=1&muted=0"
                width="560" height="315" frameborder="0"
                allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen>
            </iframe>`;
    });
});



</script>
@endpush
