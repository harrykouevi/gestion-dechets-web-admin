<div>
    <div  class="@if ($selectedPost) d-none @else row mb-4 @endif">
        <!-- Bouton Ajouter -->
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route('posts.create') }}" class="btn btn-success">
                + Ajouter un nouveau post
            </a>
        </div>
    </div>

    <div class="@if ($selectedPost) d-none @else row mb-4 @endif">
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
                                <label class="form-label">Statut (public/privé)</label>
                                <select wire:model="filterType" class="form-control">
                                    <option value="">Tous</option>
                                    <option value="admin">public</option>
                                    <option value="client">privé</option>
                                </select>
                            </div>

                            <hr class="my-4">

                            <div class="col-md-12">
                                <h1 class="h5 mt-4 text-gray-800">Date de création</h1>


                            </div>

                            <div class="col-md-6">

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
                        <button wire:click="resetFilters" class="btn btn-outline-secondary mr-2 disabled">🔄 Réinitialiser</button>

                        <button class="btn btn-primary disabled" wire:click="applyFilters">Filtrer</button>

                    </div>
                </div>

            </div>
        </div> --}}
        <div class="col-md-12">
            <div class="card shadow mb-4">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="incidentTypesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>Titre</th>
                                    <th>Extrait</th>
                                    <th>Quiz lié</th>
                                    <th>Visibilité</th>
                                    <th>Date de création</th>

                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr>
                                    {{-- <td>{{ array_key_exists("id", $data ) ?  $data['id'] : 1}}</td> --}}
                                    <td>{{ array_key_exists("titre", $data ) ?  $data['titre'] : 'titre' }}</td>
                                    <td>{{ array_key_exists("content", $data ) ? Str::limit(strip_tags($data['content']), 60) : '...' }}</td>
                                    <td>
                                        @if(array_key_exists("quizz", $data ) &&  !is_null($data["quizz"]))
                                        <a href="{{ route('quizzes.edit',['id'=>$data["quizz"]['id']]) }}" class="text-bold text-dark">{{ Str::limit(  $data["quizz"]['titre'], 60)}}</a>
                                        @else
                                        ❌ Aucun
                                        @endif
                                    </td>
                                    <td>
                                        @if(array_key_exists("visibility", $data ))
                                            @if ($data['visibility'] == 'public')
                                                <span class="badge bg-success">Public</span>
                                            @else
                                                <span class="badge bg-secondary">Privé</span>
                                            @endif
                                        @else
                                            <span class="badge bg-success">Public</span>
                                        @endif
                                    </td>

                                    <td>{{ array_key_exists("createdAt", $data ) ? \Carbon\Carbon::parse( $data['createdAt'])->format('d M Y') : '2025-05-13' }}</td>
                                    <td>

                                        <a href="{{ route('posts.edit',  $data['id']) }}" class="btn btn-sm btn-warning">✏️ Modifier</a>

                                        <button class="btn btn-sm btn-danger open-delete-modal" data-id="{{ $data['id'] }}">
                                            🗑️ Supprimer
                                        </button>

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

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                    <button type="button" id="closeModalLabel" class="btn-close " data-dismiss="modal"  aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment supprimer ce post ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal" wire:click="$set('postIdToDelete', null)">Annuler</button>

                    <button wire:click="delete()" class="btn btn-danger" data-bs-dismiss="modal">
                        Confirmer la suppression
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
