
    <div>
    <div class="container mt-4">
   
        <div class="card shadow-sm">
            <div class="card-body">
                @if ($successMessage)
                    <div class="alert alert-success">
                        {{ $successMessage }}
                    </div>
                @endif
                @error('general_erreur') 
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror

                <form wire:submit.prevent="save">
                    @csrf

                    <div class="row">
                        <!-- Nom du responsable de ménage -->
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom du responsable de ménage</label>
                            <input type="text" id="nom" wire:model="nom" class="form-control" placeholder="Entrez le nom du responsable de ménage">
                            @error('nom') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prénom du responsable de ménage -->
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom du responsable de ménage</label>
                            <input type="text" id="prenom" wire:model="prenom" class="form-control" placeholder="Entrez le prénom">
                            @error('prenom') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="col-md-6 mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" id="telephone" wire:model="telephone" class="form-control" placeholder="Ex : 90 00 00 00">
                            @error('telephone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Adresse -->
                        <div class="col-md-6 mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" id="adresse" wire:model="adresse" class="form-control" placeholder="Quartier, rue, etc.">
                            @error('adresse') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Zone géographique -->
                        <div class="col-md-6 mb-3">
                            <label for="zone_id" class="form-label">Zone géographique</label>
                            <select id="zone_id" wire:model="zone_id" class="form-control">
                                <option value="">-- Sélectionnez une zone --</option>
                                {{-- @foreach($zones as $zone)
                                    <option value="{{ $zone['id'] }}">{{ $zone['nom'] }}</option>
                                @endforeach --}}
                            </select>
                            @error('zone_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Nombre de personnes dans le ménage -->
                        <div class="col-md-6 mb-3">
                            <label for="nb_personnes" class="form-label">Nombre de personnes</label>
                            <input type="number" id="nb_personnes" wire:model="nb_personnes" class="form-control" placeholder="Ex : 4">
                            @error('nb_personnes') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email (optionnel) -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Adresse email (facultatif)</label>
                            <input type="email" id="email" wire:model="email" class="form-control" placeholder="Ex : menage@mail.com">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                         <!-- Mot de passe -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" id="password" wire:model="password" class="form-control" placeholder="Mot de passe">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" id="password_confirmation" wire:model="password_confirmation" class="form-control" placeholder="Répétez le mot de passe">
                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ $menageId ? 'Mettre à jour le ménage' : 'Créer le ménage' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


