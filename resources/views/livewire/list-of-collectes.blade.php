<div>
    <div class="@if ($selectedCollect) mb-4 @else d-none @endif">
        @php
            $statut = $selectedCollect['statut'] ?? 'terminée';
            $color = match($statut) {
                'planifiée'  => 'warning',
                'en cours'   => 'info',
                'terminée'   => 'success',
                'échouée'    => 'danger',
                "accepte" => 'info',
                default      => 'secondary',
            };
        @endphp

        <!-- En-tête -->
        <div class="mb-4">
            <h3>Collecte # {{ $selectedCollect['numero_collecte'] ?? 'N/A' }}</h3>
            <span class="badge bg-{{ $color }}">{{ ucfirst($selectedCollect['statut'] ?? 'accepté') }}</span>
        </div>

        <!-- Détails -->
        <div class="row mb-4">
            <div class="col-md-6">

                <!-- Infos ménage -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="text-muted"><strong>Ménage collecté</strong></h6>
                        <p class="mb-1"><strong>Nom :</strong> {{ $selectedCollect['request']['nom'] ?? 'Famille X' }}</p>
                        @if(!is_null($selectedCollect))
                        <p class="mb-1"><strong>Adresse :</strong>
                            @if(array_key_exists("latitude", $selectedCollect ) )
                                <span class="badge bg-info" style="color:#fff">
                                    <strong>Latitude :</strong> {{ $selectedCollect['latitude'] ?? '---' }}
                                    <strong>Longitude :</strong> {{ $selectedCollect['longitude'] ?? '---' }}
                                </span>
                            @else
                                somewhere in lomé
                            @endif
                        </p>
                        @endif
                        <p class="mb-1"><strong>Zone :</strong> {{ $selectedCollect['request']['quartier'] ?? 'N/A' }} {{ $selectedCollect['request']['ville'] ?? 'N/A' }} </p>
                    </div>
                </div>

                <!-- Déchets collectés -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="text-muted"><strong>Déchets collectés</strong></h6>
                        <p class="mb-1"><strong>Type :</strong> {{ $selectedCollect['request']['typeDeceht'] ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Quantité :</strong> {{ $selectedCollect['quantite_collectee'] ?? '0' }} kg</p>
                    </div>
                </div>

            </div>

            <div class="col-md-6">

                <!-- Agent responsable -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="text-muted"><strong>Agent responsable</strong></h6>
                        @if(isset($selectedCollect['agent']))
                            <p class="mb-1"><strong>Nom :</strong> {{ $selectedCollect['agent']['nom'] ?? 'N/A' }} {{ $selectedCollect['agent']['prenom'] ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>ID :</strong> {{ $selectedCollect['agent']['id'] }}</p>
                            <p class="mb-1"><strong>Téléphone :</strong> {{ $selectedCollect['agent']['telephone'] }}</p>
                        @else
                            <p class="text-muted">Aucun agent assigné.</p>
                        @endif
                    </div>
                </div>

                <!-- Suivi de collecte -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="text-muted"><strong>Suivi de la collecte</strong></h6>
                        <p class="mb-1"><strong>Date prévue :</strong> {{ $selectedCollect['request']['dateDeCollecte'] ?? '---' }}</p>
                        <p class="mb-1"><strong>Date effective :</strong> {{ $selectedCollect['date_collecte'] ?? '---' }}</p>
                        <p class="mb-1"><strong>Observations :</strong> {{ $selectedCollect['observations'] ?? 'Aucune' }}</p>
                        <p class="mb-1"><strong>Incidents :</strong> {{ $selectedCollect['incident'] ?? 'Aucun' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte de localisation -->
        <div class="card mb-4">
            <div class="card-body" wire:ignore>
                <h6 class="card-title mb-3">Localisation</h6>
                <div id="map" style="height: 400px;" class="rounded border"></div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2">
            <a href="/collectes" class="btn btn-secondary">Retour</a>
            {{-- <a href="/collectes/{{ $selectedCollect['id'] ?? 'id' }}/edit" class="btn btn-outline-primary">Modifier</a> --}}
        </div>
    </div>

    <!-- Liste des collectes -->
    <div class="@if ($selectedCollect) d-none @else row mb-4 @endif">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    {{-- <div>
                        <!-- Choix du mode -->

                        <h1 class="h5 mb-4 text-gray-800">Filtre </h1>
                        <!-- Filtres généraux incidents -->
                        <div class="row g-3"  >

                            <div class="col-md-6">
                                <label class="form-label">Statut (public/privé)</label>
                                <select  wire:model.lazy="filterstatus" class="form-control">
                                    <option value="">Tous</option>
                                    <option value="accepte">Accepté</option>
                                    <option value="en attente">En attente</option>
                                    <option value="termine">Termine</option>
                                    <option value="en cours">En cours</option>
                                </select>
                            </div>


                        </div>

                        <div class="row align-items-end">
                            <!-- Affichage du total -->
                            <div class="col-md-6 text-md-end mt-4 ">
                                <div class="fw-bold text-muted">
                                    Total : {{ count($collectes) }} éléments
                                </div>
                            </div>
                        </div>

                    </div> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" wire:ignore>
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Demande de collecte</th>
                                    <th>Agent</th>
                                    <th>Type de déchet</th>
                                    <th>Quantité (kg)</th>
                                    <th>Addresse</th>
                                    <th>État</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($collectes as $collecte)
                                <tr>
                                    <td  style="font-size: 12px;">{{ $collecte['numero_collecte'] }}</td>
                                    <td>{{ array_key_exists("date_collecte", $collecte ) ? \Carbon\Carbon::parse($collecte['date_collecte'])->format('d/m/Y H:i') : 'aucune' }}</td>
                                    <td  style="font-size: 12px;">{{ $collecte['demande_collecte_id'] ?? '---' }}</td>
                                    <td  style="font-size: 12px;">{{ $collecte['collecteur_id'] ?? '---' }}</td>
                                    <td  style="font-size: 12px;">{{ $collecte['dechet_id'] }}</td>
                                    <td>{{ $collecte['quantite_collectee'] }}</td>
                                    <td>
                                        @if(array_key_exists("latitude", $collecte ) )
                                            <span class="badge bg-info" style="color:#fff">
                                                <strong>Latitude :</strong> {{ $collecte['latitude'] ?? '---' }}
                                                <strong>Longitude :</strong> {{ $collecte['longitude'] ?? '---' }}
                                            </span>
                                        @else
                                            somewhere in lomé
                                        @endif
                                    </td>
                                    <td><span class="badge bg-success">{{ ucfirst($collecte['statut']) }}</span></td>
                                    <td>
                                        <button wire:click="selectCollect('{{ $collecte['id'] }}')" class="btn btn-sm btn-info">Voir</button>
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
</div>
