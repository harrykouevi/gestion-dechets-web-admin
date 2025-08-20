<div>
    <div class="container mt-4">


        <div class="card shadow-sm">

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @error('general_erreur')
                    <div class="alert alert-danger">
                        {!! $message !!}
                        @error('post_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>
                @enderror
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
                            <input type="text" id="nom" wire:model="agent_nom" class="form-control" placeholder="Entrez le nom de l'agent">
                            @error('agent_nom') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prénom -->
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" id="prenom" wire:model="agent_prenom" class="form-control" placeholder="Entrez le prénom">
                            @error('prenom') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="col-md-6 mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" id="telephone" wire:model="agent_telephone" class="form-control" placeholder="Ex : 90 00 00 00">
                            @error('telephone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" id="email" wire:model="agent_email" class="form-control" placeholder="Ex : agent@mail.com">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Zone d’affectation -->
                        {{-- <div class="col-md-6 mb-3">
                            <label for="zone_id" class="form-label">Zone d’affectation</label>
                            <select id="zone_id" wire:model="agent_zone_id" class="form-control">
                                <option value="">-- Sélectionnez une zone --</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone['id'] }}">{{ $zone['nom'] }}</option>
                                @endforeach
                            </select>
                            @error('zone_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> --}}

                        <div class="col-md-6  offset-md-6 mb-3">
                            <label for="type" class="form-label">Type de collecteur</label>
                            <select id="type" wire:model="agent_type_collecteur" class="form-control">
                                <option value="">-- Choisissez --</option>
                                <option value="interne">Interne</option>
                                <option value="externe">Externe</option>
                            </select>
                            @error('agent_type_collecteur') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Statut -->
                        {{-- <div class="col-md-6 mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select id="statut" wire:model="agent_statut" class="form-control">
                                <option value="">-- Choisissez --</option>
                                <option value="actif">Actif</option>
                                <option value="inactif">Inactif</option>
                            </select>
                            @error('statut') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> --}}

                        <!-- Mot de passe -->
                        <div class="col-md-6  mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" id="password" wire:model="agent_password" class="form-control" placeholder="Mot de passe de l’agent">
                            @error('agent_password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirmation du mot de passe -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" id="password_confirmation" wire:model="agent_password_confirmation" class="form-control" placeholder="Répétez le mot de passe">
                            @error('agent_password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        @if(!$agentId)
                        <button type="submit" class="btn btn-primary">
                            {{ $agentId ? 'Mettre à jour l\'agent' : 'Créer l\'agent' }}
                        </button>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
