<div>
    <div class="@if ($selectedAgent) row mb-4 @else  d-none @endif">
        @if ($selectedAgent)
        <div class="col-md-12">

            <!-- Détails de l’agent -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informations de l’agent</h5>

                    <p class="card-text"><strong>Nom de l'agent :</strong> {{ $selectedAgent["name"] ?? '____' }}</p>
                    <p class="card-text"><strong>Coordonnée :</strong> {{ $selectedAgent["telephone"] ?? '____' }}</p>
                    <p class="card-text"><strong>Zone :</strong> {{ $selectedAgent["zone"]["nom"] ?? '____' }}</p>
                    <p class="card-text"><strong>Type d'agent :</strong> {{ $selectedAgent["type"] ?? '____' }}</p>
                    <p class="card-text"><strong>Date d'ajout :</strong> {{ $selectedAgent["created_at"] ?? '____' }}</p>

                    @if(!empty($selectedAgent["image"]))
                        <div class="mb-3 text-center">
                            <img src="{{ asset('storage/' . $selectedAgent["image"]) }}"
                                alt="Photo de l'agent"
                                class="img-fluid rounded shadow-sm"
                                style="max-height: 300px;">
                        </div>
                    @endif

                    <a href="{{ route('agents.edit', $selectedAgent['id'] ?? 1) }}" class="btn btn-sm btn-primary mt-2">Modifier</a>
                    <button wire:click="delete({{ $selectedAgent['id'] ?? 1 }})"
                            onclick="return confirm('Êtes-vous sûr ?')"
                            class="btn btn-sm btn-danger mt-2">Supprimer</button>
                   
                </div>
            </div>

            <!-- Historique des collectes -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title">Historique des collectes</h5>
                    
                    @if(isset($collectes) && count($collectes))
                        <ul class="list-group">
                            @foreach($collectes as $collecte)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        📍 <strong>Lieu :</strong> {{ $collecte['lieu'] ?? 'Non précisé' }} <br>
                                        🕒 <strong>Date :</strong> {{ $collecte['date'] ?? 'Non précisée' }}
                                    </div>
                                    <span class="badge bg-success rounded-pill">
                                        {{ $collecte['volume'] ?? 0 }} kg
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Aucune collecte enregistrée.</p>
                    @endif
                </div>
            </div>

            <!-- Statistiques de performance -->
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Statistiques de performance</h5>

                    <p><strong>Nombre total de collectes :</strong> {{ $stats['total'] ?? 0 }}</p>
                    <p><strong>Volume total collecté :</strong> {{ $stats['volume_total'] ?? 0 }} kg</p>
                    <p><strong>Date de la dernière collecte :</strong> {{ $stats['derniere_collecte'] ?? 'Aucune' }}</p>

                    <!-- Exemple de graphique (optionnel si tu utilises un JS frontend) -->
                    {{-- <div id="chart-container">Insérer un graphique ici avec Chart.js, ApexCharts, etc.</div> --}}
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

        
            <div class="col-md-12">
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
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Dernière connexion</th>
                                {{-- <th>Rôle</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $agent)
                            <tr>
                                <td>{{ $agent[0] }}</td>
                                <td>{{ array_key_exists("name", $agent ) ?   $agent["name"] : 'nom et prenom' }}</td>
                                <td>{{ array_key_exists("email", $agent ) ?  $agent["email"] : 'admin@admin.com' }}</td>
                                <td>{{ array_key_exists("id", $agent ) ?  $agent['created_at'] : '2025-23-12'  }}</td>
                                {{-- <td>{{ $agent['created_at']->format('d/m/Y') }}</td>
                                <td>{{ $agent->role ?? 'N/A' }}</td> --}}
                                <td>
                                    <button wire:click="selectAgent({{  $agent[0]}})" class="btn btn-sm btn-info">Voir</button>
                                    <a href="{{ route('agents.edit', 1) }}" class="btn btn-sm btn-warning">Modifier</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

</div>
