<div>
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
       

            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form wire:submit.prevent="save">
                    @csrf
                    @error('_mess_') 
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('general') 
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="row">
                        <!-- Nom -->
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" id="nom" wire:model="nom" class="form-control" placeholder="Entrez le nom de l'agent">
                            @error('nom') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prénom -->
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" id="prenom" wire:model="prenom" class="form-control" placeholder="Entrez le prénom">
                            @error('prenom') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="col-md-6 mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" id="telephone" wire:model="telephone" class="form-control" placeholder="Ex : 90 00 00 00">
                            @error('telephone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" id="email" wire:model="email" class="form-control" placeholder="Ex : agent@mail.com">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Zone d’affectation -->
                        <div class="col-md-6 mb-3">
                            <label for="zone_id" class="form-label">Zone d’affectation</label>
                            <select id="zone_id" wire:model="zone_id" class="form-control">
                                <option value="">-- Sélectionnez une zone --</option>
                                {{-- @foreach($zones as $zone)
                                    <option value="{{ $zone['id'] }}">{{ $zone['nom'] }}</option>
                                @endforeach --}}
                            </select>
                            @error('zone_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Statut -->
                        <div class="col-md-6 mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select id="statut" wire:model="statut" class="form-control">
                                <option value="">-- Choisissez --</option>
                                <option value="actif">Actif</option>
                                <option value="inactif">Inactif</option>
                            </select>
                            @error('statut') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" id="password" wire:model="password" class="form-control" placeholder="Mot de passe de l’agent">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirmation du mot de passe -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" id="password_confirmation" wire:model="password_confirmation" class="form-control" placeholder="Répétez le mot de passe">
                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ $agentId ? 'Mettre à jour l\'agent' : 'Créer l\'agent' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
