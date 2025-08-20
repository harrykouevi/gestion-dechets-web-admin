<div>
    
    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @error('general_erreur') 
        <div class="alert alert-danger">
            {!! $message !!}
            @error('collect_id') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror

        </div>
    @enderror

        
                
    <form id="myForm" wire:submit="save">
        @csrf

        {{-- Global Errors --}}
        @error('_mess_') <span class="text-danger">{{ $message }}</span> @enderror
        @error('general') <span class="text-danger">{{ $message }}</span> @enderror

        {{-- Utilisateur --}}
        <div class="mb-4" wire:ignore>
            <label for="user_id" class="form-label fw-bold text-secondary">Sélectionner un utilisateur</label>
            <select id="user_id" class="form-select rounded-3 shadow-sm" style="width: 100%" required></select>
            @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Type de déchets --}}
        <div class="mb-4">
            <label for="collect_dechet_id" class="form-label fw-bold text-secondary">♻️ Type de déchets</label>
            <select id="collect_dechet_id" wire:model="collect_dechet_id" class="form-control rounded-3 shadow-sm">
                <option value="public">Public</option>
                <option value="private">Privé</option>
            </select>
            @error('collect_dechet_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Adresse prédéfinie ou manuelle --}}
        <div class="mb-4">
            <label for="collect_adresse_id" class="form-label fw-bold text-secondary">Adresse (liste)</label>
            <select id="collect_adresse_id" wire:model="collect_adresse_id" class="form-control rounded-3 shadow-sm">
                <option value="">🔍 Sélectionner une adresse</option>
                {{-- @foreach($adresses as $adresse)
                    <option value="{{ $adresse->id }}">{{ $adresse->nom }}</option>
                @endforeach --}}
            </select>
            @error('collect_adresse_id') <small class="text-danger">{{ $message }}</small> @enderror

            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="toggleMapBtn">
                ➕ Ajouter manuellement sur la carte
            </button>
        </div>

        {{-- Carte interactive --}}
        <div id="mapSection" class="mb-4" style="display:none;" wire:ignore>
            <label class="form-label fw-bold text-secondary">Sélectionner un emplacement sur la carte</label>
            <div id="map" style="height: 300px; border-radius: 10px; overflow: hidden;"></div>

            <input type="hidden" wire:model="collect_longitude" id="longitude">
            <input type="hidden" wire:model="collect_latitude" id="latitude">

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="latitude" class="form-label fw-bold text-secondary">Latitude</label>
                    <input type="text" wire:model.lazy="collect_latitude" id="latitude" class="form-control rounded-3 shadow-sm" readonly>
                </div>
                <div class="col-md-6">
                    <label for="longitude" class="form-label fw-bold text-secondary">Longitude</label>
                    <input type="text" wire:model.lazy="collect_longitude" id="longitude" class="form-control rounded-3 shadow-sm" readonly>
                </div>
            </div>
        </div>

        {{-- Date --}}
        <div class="mb-4">
            <label for="collect_date_demande" class="form-label fw-bold text-secondary">Date de collecte</label>
            <input type="date" id="collect_date_demande" wire:model="collect_date_demande" class="form-control rounded-3 shadow-sm">
            @error('collect_date_demande') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label for="collect_description" class="form-label fw-bold text-secondary">Détails complémentaires</label>
            <textarea id="collect_description" wire:model="collect_description" class="form-control rounded-3 shadow-sm" rows="2" placeholder="Rédige ici une description"></textarea>
            @error('collect_description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Boutons --}}
        <div class="text-end">
            <button 
                type="submit" 
                class="btn btn-primary px-5 py-2 shadow"
                wire:loading.attr="disabled"
                wire:target="@foreach($collect_medias as $index => $m) medias.{{ $index }}.file, @endforeach"
            >
                {{ $collectId ? '💾 Mettre à jour une collecte' : '🚀 Enregistrer' }}
            </button>

            @if(! $collectId)
                <button 
                    type="submit" 
                    class="btn btn-outline-secondary px-5 py-2 shadow"
                    wire:loading.attr="disabled"
                    wire:target="@foreach($collect_medias as $index => $m) collect_medias.{{ $index }}.file, @endforeach"
                >
                    🚀 Enregistrer et créer un quiz
                </button>
            @endif

            @if ($collectId)
                <a href="{{ route('quizzes.create').'?postId='.$collectId }}" class="btn btn-outline-success px-5 py-2 shadow ms-3">
                    🎯 Aller au Quiz
                </a>
            @endif
        </div>
    </form>


   

</div>
