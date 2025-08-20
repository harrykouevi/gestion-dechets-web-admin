<div>
    {{-- ===================== Détails d’une demande sélectionnée ===================== --}}
    <div class="@if ($selectedCollect) mb-4 @else d-none @endif">
        @php
            $statut = $selectedCollect['statut'] ?? 'En attente';
            $color = match($statut) {
                'en attente' => 'warning',
                'en cours'     => 'success',
                'refusé'     => 'danger',
                default      => 'secondary',
            };
        @endphp

        <!-- En-tête -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Demande de collecte #{{ $selectedCollect['id'] ?? 'ID' }}</h3>
            <span class="badge bg-{{ $color }}">{{ ucfirst($statut) }}</span>
        </div>

        <div class="row mb-4">
            <!-- Infos ménage -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="text-muted">Ménage demandeur</h6>
                        <p><strong>Nom :</strong> {{ $selectedCollect['menage']['nom'] ?? 'Famille X' }}</p>
                        <p><strong>ID :</strong> {{ $selectedCollect['menage']['numero'] ?? '#MEN-000' }}</p>
                        <p><strong>Adresse :</strong> {{ $selectedCollect['menage']['adresse'] ?? 'Adresse non renseignée' }}</p>
                        <p><strong>Zone :</strong> {{ $selectedCollect['menage']['zone'] ?? 'Zone inconnue' }}</p>
                    </div>
                </div>

                <!-- Infos déchets -->
                {{-- <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="text-muted">Déchets demandés</h6>
                        <p><strong>Type :</strong> {{ $selectedCollect['typeDechet'] ?? 'Non précisé' }}</p>
                        <p><strong>Quantité :</strong> {{ $selectedCollect['quantite'] ?? '-' }} kg</p>
                        <p><strong>Référence type :</strong> #{{ $selectedCollect['ref_type'] ?? '---' }}</p>
                    </div>
                </div> --}}

                <!-- Bouton assignation -->
                <div class="d-grid mt-3">
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#assignModal">
                        Assigner un agent
                    </button>
                </div>
            </div>

            <!-- Infos agent + collecte -->
            <div class="col-md-6">
                <!-- Agent -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="text-muted">Agent responsable</h6>
                        @if(isset($selectedCollect['agent']))
                            <p><strong>Nom :</strong> {{ $selectedCollect['agent']['nom'] ?? '---' }}</p>
                            <p><strong>ID :</strong> {{ $selectedCollect['agent']['numero'] ?? '---' }}</p>
                            <p><strong>Téléphone :</strong> {{ $selectedCollect['agent']['telephone'] ?? '---' }}</p>
                        @else
                            <p class="text-primary">Aucun agent assigné pour le moment.</p>
                        @endif
                    </div>
                </div>

                <!-- Informations collecte -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="text-muted">Informations de collecte</h6>
                        <p><strong>Date prévue :</strong> {{ $selectedCollect !== null && array_key_exists("dateDeCollecte", $selectedCollect ) ?  \Carbon\Carbon::parse($selectedCollect['dateDeCollecte'] ): '2025-23-12'  }}</p>
                        <p><strong>Date effective :</strong> {{ $selectedCollect !== null && array_key_exists("created_at", $selectedCollect ) ?  \Carbon\Carbon::parse($selectedCollect['created_at'] ): '2025-23-12'  }}</p>

                        <p><strong>Instructions :</strong> {{ $selectedCollect['instructions'] ?? 'Aucune instruction' }}</p>
                        <p><strong>Observations :</strong> {{ $selectedCollect['observations'] ?? 'Aucun incident' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte localisation -->
        <div class="card mb-4">
            <div class="card-body" wire:ignore>
                <h6 class="mb-3">Localisation du ménage</h6>
                <div id="map" style="height: 400px;" class="rounded border"></div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('collectes.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>

    {{-- ===================== Liste des demandes ===================== --}}
    <div class="@if ($selectedCollect) d-none @else row mb-4 @endif">
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route('collectes.create') }}" class="btn btn-success">
                + Nouvelle demande
            </a>
        </div>
    </div>

    <div class="@if ($selectedCollect) d-none @else row mb-4 @endif">
        <div class="col-md-12">
            <!-- Tableau des demandes -->
            <div class="card">
                <div class="card-body">
                    <!-- Section filtres -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-secondary mb-3">Filtrer les demandes</h6>
                        <div class="row g-3 align-items-end">

                            <div class="col-md-6">
                                <label class="form-label">Statut</label>
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
                                    Total : {{ count($datas) }} éléments
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" >
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Date demande</th>
                                    <th>Ménage</th>
                                    <th>Type de déchet</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($datas as $index => $data)
                                    @php $collapseId = 'collapseAttempt' . $index; @endphp
                                    <tr>
                                        <td wire:ignore> <button class="btn btn-sm " type="button" data-toggle="collapse" data-target="#{{ $collapseId }}"> {{ $isCollapsed ? '-' : '+' }} </button>
                                        <td> {{ array_key_exists("created_at", $data ) ?  \Carbon\Carbon::parse($data['created_at']) : '2025-23-12'  }}</td>
                                        <td>{{ $data['nom'] ?? '---' }} </td>
                                        <td>{{ $data['typeDeceht'] ?? '---' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $data['statut'] == 'validé' ? 'success' : ($data['statut'] == 'refusé' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($data['statut']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button wire:click="selectCollect('{{ $data['id'] }}')" class="btn btn-sm btn-info">
                                                Voir
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Ligne collapse -->
                                    <tr class="collapse bg-white" id="{{ $collapseId }}"> <td colspan="7"> <div class="p-4 bg-light rounded border shadow-sm"> <h6 class="text-primary mb-3">Détail sur la collecte</h6> @if(isset($data['agent'])) <p><strong>Statut :</strong> {{ $data['statut'] }}</p> <p><strong>Traitée par :</strong> {{ $data['agent']['nom'] }}</p> <p><strong>Date de traitement :</strong> {{ \Carbon\Carbon::parse($data['agent']['date_traitement'])->format('d/m/Y H:i') }}</p> @if(!empty($data['agent']['remarques'])) <p><strong>Remarques :</strong> {{ $data['agent']['remarques'] }}</p> @endif @else <p class="text-muted">Aucune collecte faite pour cette demande.</p> @endif </div> </td> </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Aucune demande trouvée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== Modal assignation ===================== --}}
    <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/collectes/{{ $selectedCollect['id'] ?? 0 }}/assign">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assigner un agent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <label for="agent_id" class="form-label">Sélectionner un agent</label>
                        <select class="form-select" name="agent_id" id="agent_id" required>
                            <option value="">-- Choisir --</option>
                            <option value="12">Aïcha Ndiaye (#12)</option>
                            <option value="13">Oumar Diallo (#13)</option>
                            <option value="14">Fatou Seck (#14)</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Assigner</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
