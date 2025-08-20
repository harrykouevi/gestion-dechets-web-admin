<div>

    <div  class="@if ($selectedType) d-none @else row mb-4 @endif">
        <!-- Bouton Ajouter -->
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route('types-dechets.create') }}" class="btn btn-success">
                + Ajouter 
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="@if ($selectedType) d-none @else row mb-4 @endif">

        <div class="col-md-12">
            <div class="card shadow mb-4">
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="incidentTypesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Prix</th>
                                    <th>Par unité</th>
                                    <th>Status</th>
                                    <th>Date de création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wastetype as $type)
                                <tr>
                                    <td>{{ array_key_exists("id", $type ) ?  $type['id'] : 1}}</td>
                                    <td>{{ array_key_exists("nom", $type ) ?  $type['nom'] : 'nom' }}</td>
                                    <td>{{ array_key_exists("description", $type ) ?  $type['description'] : 'description'}}</td>
                                    <td>{{ array_key_exists("prix", $type ) ?  $type['prix'] : 'prix'}}</td>
                                    <td>{{ array_key_exists("unite", $type ) ?  $type['unite'] : 'unite'}}</td>
                                    <td>
                                        <span class="badge " style="background:{{ (array_key_exists("actif", $type ) &&  $type['actif'] == true ) ?  'green' : 'red' }} ">
                                            {{ array_key_exists("actif", $type ) ? ($type['actif'] == true ? 'oui' : 'non' ) : 'rouge' }}
                                        </span> 
                                       
                                    </td>
                                    <td>{{ array_key_exists("created_at", $type ) ?  $type['created_at'] : 2025-05-13 }}</td>
                                    <td>
                                        <a href="{{ route('types-dechets.edit', $type['id']?? 1) }}" class="btn btn-sm btn-warning">Modifier</a>
                                        <button class="btn btn-sm btn-danger open-delete-modal" data-id="{{ $type['id'] }}">
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
                    Voulez-vous vraiment supprimer ce type ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal" wire:click="$set('wastetypeIdToDelete', null)">Annuler</button>

                    <button wire:click="delete()" class="btn btn-danger" data-bs-dismiss="modal">
                        Confirmer la suppression
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
