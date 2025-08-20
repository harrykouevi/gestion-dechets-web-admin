<div>
    <div class="@if ($selectedAgent) row mb-4 @else  d-none @endif">
        @if ($selectedAgent)
        <div class="col-md-12">

            <!-- Détails de l’agent -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informations de l’agent</h5>

                    <p class="card-text"><strong>Nom de l'agent :</strong> {{ $selectedAgent["nom"] ?? '____' }} {{ $selectedAgent["prenom"] ?? '____' }}</p>
                    <p class="card-text"><strong>Téléphone :</strong> {{ $selectedAgent["telephone"] ?? '____' }}</p>
                    <p class="card-text"><strong>Type d'agent :</strong> {{ $selectedAgent["type"] ?? '____' }}</p>
                    <p class="card-text"><strong>Date d'ajout :</strong> {{ array_key_exists('created_at',$selectedAgent)? \Carbon\Carbon::parse($selectedAgent["created_at"]) : '____' }}</p>

                    @if(!empty($selectedAgent["image"]))
                        <div class="mb-3 text-center">
                            <img src="{{ asset('storage/' . $selectedAgent["image"]) }}"
                                alt="Photo de l'agent"
                                class="img-fluid rounded shadow-sm"
                                style="max-height: 300px;">
                        </div>
                    @endif

                    <a href="{{ route('agents.edit', $selectedAgent['id'] ) }}" class="btn btn-sm btn-primary mt-2">Modifier</a>
                    {{-- <button wire:click="delete({{ $selectedAgent['id']  }})"
                            onclick="return confirm('Êtes-vous sûr ?')"
                            class="btn btn-sm btn-danger mt-2">Supprimer</button> --}}

                </div>
            </div>

            <!-- Filtres par période -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="date_debut" class="form-label">Date début</label>
                            <input type="date" id="date_debut" class="form-control" name="date_debut">
                        </div>
                        <div class="col-md-4">
                            <label for="date_fin" class="form-label">Date fin</label>
                            <input type="date" id="date_fin" class="form-control" name="date_fin">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-primary w-100">Filtrer</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques clés -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title">Statistiques de performance</h5>

                    <div class="row text-center mb-4 ">
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>Total Collectes</h5>
                                    <h2 class="text-primary">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>Déchets (kg)</h5>
                                    <h2 class="text-success">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>Types Différents</h5>
                                    <h2 class="text-warning">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>Ménages servis</h5>
                                    <h2 class="text-info">0</h2>
                                </div>
                            </div>
                        </div>
                    </div>


                        <p class="mb-1"><strong>Nombre total de collectes :</strong> {{ $stats['total'] ?? 0 }}</p>
                        <p class="mb-1"><strong>Volume total collecté :</strong> {{ $stats['volume_total'] ?? 0 }} kg</p>
                        <p class="mb-1"><strong>Date de la dernière collecte :</strong> {{ $stats['derniere_collecte'] ?? 'Aucune' }}</p>


                </div>
            </div>

            <!-- Zone graphique -->
            <div class="card shadow mb-4">
                <div class="card-body">

                    <h5 class="card-title">Évolution des collectes (kg)</h5>
                    <div id="chart-container" class="bg-light border rounded p-3" style="height: 250px;">
                        <!-- Insérer un graphique avec Chart.js ou autre -->
                        <p class="text-muted text-center">[Graphique à insérer ici]</p>
                    </div>

            </div>
            </div>

            <!-- Tableau des collectes -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title">Historique des collectes</h5>
                    <div class="table-responsive">
                        @if(isset($collectes) && count($collectes))

                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Ménage</th>
                                    <th>Type de Déchet</th>
                                    <th>Quantité (kg)</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2025-08-01</td>
                                    <td>Famille Diop</td>
                                    <td>Plastique</td>
                                    <td>12</td>
                                    <td><span class="badge bg-success">Collecté</span></td>
                                </tr>
                                <tr>
                                    <td>2025-08-01</td>
                                    <td>Famille Ndiaye</td>
                                    <td>Métal</td>
                                    <td>8</td>
                                    <td><span class="badge bg-success">Collecté</span></td>
                                </tr>
                                <!-- Plus de lignes -->
                            </tbody>
                        </table>
                        @else
                            <p class="text-muted">Aucune collecte enregistrée.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        @endif
    </div>
    <div  class="@if ($selectedAgent) d-none @else row mb-4 @endif">
        <!-- Bouton Ajouter -->
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route('agents.create') }}" class="btn btn-success">
                + Ajouter un nouvel agent
            </a>
        </div>
    </div>
    <div class="@if ($selectedAgent) d-none @else row mb-4 @endif">
    <!-- Content Row -->


            {{-- <div class="col-md-12">
                <div class="card mb-4">

                    <div class="card-body">
                        <!-- Choix du mode -->

                            <h1 class="h5 mb-4 text-gray-800">Filtre _______</h1>
                            <!-- Filtres généraux incidents -->
                            <div class="row g-3"  >
                                <div class="col-md-6">
                                    <label for="keyword" class="form-label">Mot Clé </label>
                                    <input id="keyword" type="text" wire:model="filteKkeyword" class="form-control" placeholder="Entrez un mot clé" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Statut (actif/inactif)</label>
                                    <select wire:model="filterType" class="form-control">
                                        <option value="">Tous</option>
                                        <option value="admin">actif</option>
                                        <option value="client">inactif</option>
                                    </select>
                                </div>

                                <hr class="my-4">


                                    <div class="col-md-6">
                                        <h1 class="h5 mt-4 text-gray-800">Date de création</h1>

                                        <label for="date" class="form-label">Entre</label>
                                        <input id="date" wire:model="filterDate" type="date" class="form-control" />
                                    </div>


                                    <div class="col-md-6">

                                        <label for="date" class="form-label">Et</label>
                                        <input id="date" wire:model="filterDate" type="date" class="form-control" />
                                    </div>
                            </div>

                            <!-- Filtres géographiques incidents -->
                            <hr class="my-4">

                        <!-- Bouton -->
                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-primary" wire:click="applyFilters">Filtrer</button>
                        </div>
                    </div>

                </div>
            </div> --}}
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Date de création</th>
                                {{-- <th>Rôle</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $agent)
                            <tr>
                                <td>#{{ $agent['id'] ?? 'id' }}</td>
                                <td>{{ array_key_exists("nom", $agent ) ?   $agent["nom"].' '.$agent["prenom"] : 'nom et prenom' }}</td>
                                <td>{{ array_key_exists("email", $agent ) ?  $agent["email"] : 'admin@admin.com' }}</td>
                                <td>{{ array_key_exists("telephone", $agent ) ?  $agent["telephone"] : 'admin@admin.com' }}</td>
                                <td>{{ array_key_exists("created_at", $agent ) ?  \Carbon\Carbon::parse($agent['created_at']) : '2025-23-12'  }}</td>
                                {{-- <td>{{ $agent['created_at']->format('d/m/Y') }}</td>
                                <td>{{ $agent->role ?? 'N/A' }}</td> --}}
                                <td>
                                    <button wire:click="selectAgent('{{ $agent['id'] }}')" class="btn btn-sm btn-info">Voir</button>
                                    <a href="{{ route('agents.edit', $agent['id']) }}" class="btn btn-sm btn-warning">Modifier</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

</div>
