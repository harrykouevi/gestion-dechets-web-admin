<div>
    <div class="@if ($selectedMenage) row mb-4 @else d-none @endif">
        @if ($selectedMenage)
            <div class="col-md-12">

                <!-- Détails du ménage -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Informations du ménage</h5>

                        <div class="row">
                            <!-- Infos principales -->
                            <div class="col-md-6">
                                <ul class="list-unstyled mb-3">
                                    <li><strong>Nom :</strong> {{ $selectedMenage['nom'] ?? 'Non renseigné' }} {{ $selectedMenage['prenom'] ?? '' }}</li>
                                    <li><strong>Téléphone :</strong> {{ $selectedMenage['telephone'] ?? 'Non renseigné' }}</li>
                                    <li><strong>Type d'utilisateur :</strong> {{ $selectedMenage['type'] ?? 'Non renseigné' }}</li>
                                    {{-- <li><strong>Zone d'affectation :</strong> {{ $selectedMenage['zone']['nom'] ?? 'Non renseignée' }}</li> --}}
                                    <li>
                                        <strong>Date d'ajout :</strong>
                                        {{ array_key_exists('created_at', $selectedMenage)
                                            ? \Carbon\Carbon::parse($selectedMenage['created_at'])->format('d/m/Y H:i')
                                            : 'Non renseignée' }}
                                    </li>
                                </ul>
                            </div>

                            <!-- Photo du ménage -->
                            <div class="col-md-6 text-center">
                                @if (!empty($selectedMenage['image']))
                                    <img src="{{ asset('storage/' . $selectedMenage['image']) }}"
                                        alt="Photo du ménage"
                                        class="img-fluid rounded shadow-sm"
                                        style="max-height: 200px;">
                                @else
                                    <div class="text-muted fst-italic">Aucune image disponible</div>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <!-- Liste des adresses -->
                        <h6 class="mt-3 text-muted">Adresses enregistrées</h6>
                        @if (!empty($userAddressList) && count($userAddressList) > 0)
                            <div class="list-group">
                                @foreach($userAddressList as $adresse)
                                    <div class="list-group-item">
                                        <p class="mb-1"><strong>Quartier :</strong> {{ $adresse['quartier'] ?? '---' }}</p>
                                        <p class="mb-1"><strong>Ville :</strong> {{ $adresse['ville'] ?? '---' }}</p>
                                        <p class="mb-1"><strong>Coordonnées GPS :</strong>
                                            @if(array_key_exists("latitude", $adresse ) )
                                                <span class="badge bg-info" style="color:#fff">
                                                    <strong>Latitude :</strong> {{ $adresse['latitude'] ?? '---' }}
                                                    <strong>Longitude :</strong> {{ $adresse['longitude'] ?? '---' }}
                                                </span>
                                            @else
                                                somewhere in lomé
                                            @endif
                                        </p>
                                        {{-- @if(!empty($adresse['domicileId']))
                                            <span class="badge bg-primary">Domicile</span>
                                        @endif --}}

                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted fst-italic">Aucune adresse enregistrée</p>
                        @endif
                    </div>
                </div>




                <!-- Filtres -->
                {{-- <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label for="type" class="form-label">Type de déchet</label>
                                <select id="type"  class="form-control">
                                    <option value="">Tous</option>
                                    <option value="plastique">Plastique</option>
                                    <option value="papier">Papier</option>
                                    <option value="organique">Organique</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="date_debut" class="form-label">Date début</label>
                                <input type="date" id="date_debut" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="date_fin" class="form-label">Date fin</label>
                                <input type="date" id="date_fin" class="form-control">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Appliquer</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- Statistiques Résumées -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Statistiques de performance</h5>

                        <!-- Chiffres clés -->


                        <div class="row text-center g-3">

                            <!-- Demandes traitées -->
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <h6>Demandes traitées</h6>
                                        <h3 class="text-info">{{ $selectedMenage['requestesolvedcount'] ?? 0 }}</h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Demandes en attente -->
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <h6>Demandes en attente</h6>
                                        <h3 class="text-warning">{{ $userRequestList->count() - $selectedMenage['requestesolvedcount'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Détails -->
                        <p><strong>Dernière collecte :</strong> {{ $stats['derniere_collecte'] ?? 'Aucune' }}</p>
                    </div>
                </div>

                <!-- Historique des collectes -->
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Historique des collectes</h5>

                        @if (!empty($userRequestList) && count($userRequestList))

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date demande</th>
                                        <th>Statut</th>
                                        <th>Coordonnées</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($userRequestList as $index => $data)
                                        <tr>
                                            <td> {{ $data['id'] ?? '---' }} </td>
                                            <td> {{ array_key_exists("dateDeCollecte", $data ) ?  \Carbon\Carbon::parse($data['dateDeCollecte']) : '2025-23-12'  }}</td>
                                            <td>
                                                <span class="badge bg-{{ $data['statut'] == 'validé' ? 'success' : ($data['statut'] == 'refusé' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($data['statut']) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info" style="color:#fff">
                                                    <strong>Latitude :</strong> {{ $data['latitude'] ?? '---' }}
                                                    <strong>Longitude :</strong> {{ $data['longitude'] ?? '---' }}
                                                </span>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Aucune demande trouvée</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @else
                            <p class="text-muted">Aucune collecte enregistrée pour ce ménage.</p>
                        @endif
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


            {{-- <div class="col-md-12">
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
            </div> --}}
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom du ménage</th>
                                <th>Téléphone</th>
                                {{-- <th>Zone</th> --}}
                                <th>Type</th>
                                <th>Date d'ajout</th>
                                {{-- <th>État</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menages as $menage)
                                <tr>
                                    <td>{{ $menage['id'] ?? '—' }}</td>
                                    <td>{{ $menage['nom'] ?? '—' }} {{ $menage['prenom'] ?? '—' }}</td>
                                    <td>{{ $menage['telephone'] ?? '—' }}</td>
                                    {{-- <td>{{ $menage['zone']['nom'] ?? '—' }}</td> --}}
                                    <td>{{ $menage['type'] ?? '—' }}</td>
                                    <td>{{ array_key_exists("created_at", $menage ) ?  \Carbon\Carbon::parse($menage['created_at'] ): '2025-23-12'  }}</td>
                                    {{-- <td>
                                        @if(isset($menage['active']) && $menage['active'])
                                            <span class="badge badge-success " >Actif</span>
                                        @else
                                            <span class="badge badge-secondary">Inactif</span>
                                        @endif
                                    </td> --}}
                                <td>
                                    <button wire:click="selectMenage('{{  $menage['id'] ?? 0 }}')" class="btn btn-sm btn-info">Voir</button>
                                    {{-- <a href="{{ route('menages.edit', 1) }}" class="btn btn-sm btn-warning">Modifier</a> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

</div>
