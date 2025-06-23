<div>
    <div class="@if ($selectedMenage) row mb-4 @else d-none @endif">
        @if ($selectedMenage)
            <div class="col-md-12">

                <!-- Détails du ménage -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Informations du ménage</h5>

                        <p><strong>Nom du ménage :</strong> {{ $selectedMenage['name'] ?? 'Non renseigné' }}</p>
                        <p><strong>Coordonnée :</strong> {{ $selectedMenage['telephone'] ?? 'Non renseigné' }}</p>
                        <p><strong>Zone d'affectation :</strong> {{ $selectedMenage['zone']['nom'] ?? 'Non renseignée' }}</p>
                        <p><strong>Type de ménage :</strong> {{ $selectedMenage['type'] ?? 'Non renseigné' }}</p>
                        <p><strong>Date d'ajout :</strong> {{ $selectedMenage['created_at'] ??  'Non renseignée' }}</p>

                        @if (!empty($selectedMenage['image']))
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $selectedMenage['image']) }}"
                                    alt="Photo du ménage"
                                    class="img-fluid rounded shadow-sm"
                                    style="max-height: 300px;">
                            </div>
                        @endif

                        <a href="{{ route('menages.edit',  $selectedMenage['id'] ?? 1) }}"
                        class="btn btn-sm btn-primary mt-2">Modifier</a>
                        <button wire:click="delete({{  $selectedMenage['id'] ?? 1 }})"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce ménage ?')"
                                class="btn btn-sm btn-danger mt-2">Supprimer</button>
                        <button wire:click="deactivate({{  $selectedMenage['id'] ?? 1 }})"
                                onclick="return confirm('Êtes-vous sûr de vouloir désactiver ce ménage ?')"
                                class="btn btn-sm btn-warning mt-2">Désactiver</button>
                    </div>
                </div>

                <!-- Historique des collectes -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Historique des collectes</h5>

                        @if (!empty($collectes) && count($collectes))
                            <ul class="list-group">
                                @foreach($collectes as $collecte)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="me-auto">
                                            📍 <strong>Lieu :</strong> {{ $collecte['lieu'] ?? 'Non précisé' }}<br>
                                            🕒 <strong>Date :</strong> {{ $collecte['date'] ?? 'Non précisée' }}
                                        </div>
                                        <span class="badge bg-success rounded-pill align-self-center">
                                            {{ $collecte['volume'] ?? 0 }} kg
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Aucune collecte enregistrée pour ce ménage.</p>
                        @endif
                    </div>
                </div>

                <!-- Statistiques de performance -->
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Statistiques de performance</h5>

                        <p><strong>Nombre total de collectes :</strong> {{ $stats['total'] ?? 0 }}</p>
                        <p><strong>Volume total collecté :</strong> {{ $stats['volume_total'] ?? 0 }} kg</p>
                        <p><strong>Dernière collecte :</strong> {{ $stats['derniere_collecte'] ?? 'Aucune' }}</p>

                        {{-- Graphique de performance (ex. Chart.js) --}}
                        {{-- <div id="chart-container"></div> --}}
                    </div>
                </div>

            </div>
        @endif
    </div>

    <div  class="@if ($selectedMenage) d-none @else row mb-4 @endif">
        <!-- Bouton Ajouter -->
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route('menages.create') }}" class="btn btn-success">
                + Ajouter un nouveau ménage
            </a>
        </div>
    </div>
 
    <div class="@if ($selectedMenage) d-none @else row mb-4 @endif">
    <!-- Content Row -->

        
            <div class="col-md-12">
                <div class="card mb-4">
                    
                    <div class="card-body">
                        <!-- Choix du mode -->
                       
                            <h1 class="h5 mb-4 text-gray-800">Filtre _______</h1>
                            <!-- Filtres généraux incidents -->
                            <div class="row g-3"  >
                                <div class="col-md-4">
                                    <input wire:model.debounce.500ms="search" type="text" class="form-control" placeholder="Rechercher par nom...">
                                </div>

                                <div class="col-md-4">
                                    <select wire:model="zone" class="form-control">
                                        <option value="">📍 Toutes les zones</option>
                                        @foreach($zones as $z)
                                            <option value="{{ $z['id'] ?? 1  }}">{{ $z['nom'] ?? 'agoue' }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <select wire:model="status" class="form-control">
                                        <option value="">🟢 Tous les statuts</option>
                                        <option value="1">Actif</option>
                                        <option value="0">Inactif</option>
                                    </select>
                                </div>

                            </div>

                            <!-- Filtres géographiques incidents -->
                            <hr class="my-2">
                            
                        <!-- Bouton -->
                        <div class="d-flex justify-content-end mt-4">
                            <button wire:click="resetFilters" class="btn btn-outline-secondary mr-2">🔄 Réinitialiser</button>
                            <button class="btn btn-primary" wire:click="applyFilters">Filtrer</button>

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom du ménage</th>
                                <th>Téléphone</th>
                                <th>Zone</th>
                                <th>Type</th>
                                <th>Date d'ajout</th>
                                <th>État</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menages as $menage)
                                <tr>
                                    <td>{{ $menage['id'] ?? '—' }}</td>
                                    <td>{{ $menage['name'] ?? '—' }}</td>
                                    <td>{{ $menage['telephone'] ?? '—' }}</td>
                                    <td>{{ $menage['zone']['nom'] ?? '—' }}</td>
                                    <td>{{ $menage['type'] ?? '—' }}</td>
                                    <td>{{ array_key_exists("id", $menage ) ?  $menage['created_at'] : '2025-23-12'  }}</td>
                                    <td>
                                        @if(isset($menage['active']) && $menage['active'])
                                            <span class="badge badge-success " >Actif</span>
                                        @else
                                            <span class="badge badge-secondary">Inactif</span>
                                        @endif
                                    </td>
                                <td>
                                    <button wire:click="selectMenage({{  $menage[0]}})" class="btn btn-sm btn-info">Voir</button>
                                    <a href="{{ route('menages.edit', 1) }}" class="btn btn-sm btn-warning">Modifier</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

</div>
