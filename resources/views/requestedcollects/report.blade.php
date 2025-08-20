@extends('layouts.app')

@section('title', 'Rapports & Statistiques')



@section('content') 
    <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        
        <li class="breadcrumb-item active" aria-current="page">
            <a href="">Gestion des collectes</a>
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
        
        <div class="col-lg-12" >
            <!-- Filtres globaux -->
            <div class="card mb-4">
                <div class="card-body">
                    <form class="row gy-3">
                        <div class="col-md-3">
                            <label class="form-label">Date début</label>
                            <input type="date" name="date_debut" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date fin</label>
                            <input type="date" name="date_fin" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type">
                                <option value="">Tous</option>
                                <option value="plastique">Plastique</option>
                                <option value="organique">Organique</option>
                                <option value="papier">Papier</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">État</label>
                            <select class="form-select" name="etat">
                                <option value="">Tous</option>
                                <option value="en_attente">En attente</option>
                                <option value="accepte">Accepté</option>
                                <option value="collecte">Collecté</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Appliquer</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistiques clés -->
            <div class="row text-center mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold ">Total collectes</h6>
                            <h3 class="text-primary">322</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold ">Total déchets (kg)</h6>
                            <h3 class="text-success">1 284</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold ">Types couverts</h6>
                            <h3 class="text-warning">5</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold " >Agents actifs</h6>
                            <h3 class="text-info">14</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6  class="font-weight-bold text-primary">Collectes par type de déchet</h6>
                            <div style="height: 250px;" class="bg-light border rounded p-3 text-center">
                                <canvas id="pieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="font-weight-bold text-primary" >Évolution des collectes par jour</h6>
                            <div style="height: 250px;" class="bg-light border rounded p-3 text-center">
                            {{-- <div class="bg-light border rounded p-3 text-center"> --}}
                                <canvas id="lineChart" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analyse croisée par agent -->
            <div class="card mb-5">
                <div class="card-body">
                    <h6 class="font-weight-bold text-success">🏆 Top  5 Agents - Quantité collectée</h6>
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Agent</th>
                                <th>Collectes</th>
                                <th>Quantité (kg)</th>
                                <th>Ménages servis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Oumar Diallo</td>
                                <td>54</td>
                                <td>210</td>
                                <td>18</td>
                            </tr>
                            <tr>
                                <td>Aïcha Sow</td>
                                <td>47</td>
                                <td>182</td>
                                <td>15</td>
                            </tr>
                            <!-- ... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   
  
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // === Données simulées ===
        const typesData = {
            labels: ['Plastique', 'Organique', 'Papier', 'Métal', 'Verre'],
            datasets: [{
            label: 'Types de Déchets',
            data: [350, 420, 210, 180, 124],
            backgroundColor: [
                '#0d6efd', '#198754', '#ffc107', '#fd7e14', '#6f42c1'
            ],
            borderWidth: 1
            }]
        };

        const evolutionData = {
            labels: [
            '2025-07-28', '2025-07-29', '2025-07-30', '2025-07-31',
            '2025-08-01', '2025-08-02', '2025-08-03'
            ],
            datasets: [{
            label: 'Quantité collectée (kg)',
            data: [110, 142, 95, 124, 180, 156, 145],
            fill: true,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.2)',
            tension: 0.4
            }]
        };

        // === Graphique Camembert ===
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: typesData,
            options: {
            responsive: true,
            plugins: {
                legend: {
                position: 'bottom'
                }
            }
            }
        });

        // === Graphique Linéaire ===
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: evolutionData,
            options: {
            responsive: true,
            plugins: {
                legend: {
                display: false
                }
            },
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
        </script>

   
@endpush
