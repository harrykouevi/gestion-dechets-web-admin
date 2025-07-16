<div>
    
    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @error('general_erreur') 
        <div class="alert alert-danger">
            {!! $message !!}
            @error('reward_id') 
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
    
          <div class="mb-4">
            <label for="reward_id" class="form-label fw-bold text-secondary">
                📘 Choisis le quiz concerné
            </label>
            <select id="reward_id" wire:model="reward_quizzId" class="form-control shadow-sm rounded-3" disabled>
                <option value="">-- Sélectionne un cours --</option>
                @if(is_array($quizz))
                    <option value="{{ $quizz['id'] }}" selected>{{ $quizz['titre'] ?? 'key:'.$quizz['id'] }}</option>
                @else
                    <option value="">Aucun</option>
                @endif
            </select>
            @error('reward_id') <small class="text-danger">{{ $message }}</small> @enderror
            @error('reward_quizzId') <small class="text-danger">{{ $message }}</small> @enderror
            
        </div>
        <div class="mb-4">
            <label for="reward_type" class="form-label fw-bold text-secondary">Type de contenu</label>
            <select id="reward_type" wire:model.lazy="reward_type" class="form-control rounded-3 shadow-sm">
                <option value="points">Points</option>
                <option value="badge">Badge</option>
            </select>
            @error('reward_type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        
        <div class="mb-4">
            <label for="reward_name" class="form-label fw-bold text-secondary">Nom de la recompense</label>
            <input type="text" id="reward_name" wire:model="reward_name" class="form-control rounded-3 shadow-sm" placeholder="Nom">
            @error('reward_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4">
            <label for="reward_description" class="form-label fw-bold text-secondary">Description</label>
            <textarea id="reward_description" wire:model="reward_description" class="form-control rounded-3 shadow-sm" rows="2" placeholder="Rédige ici une description"></textarea>
            @error('reward_description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4">
            <label for="reward_value" class="form-label fw-bold text-secondary">Points</label>
            <input type="text" id="reward_value" wire:model="reward_value" class="form-control rounded-3 shadow-sm" placeholder="Entrez des points">
            @error('reward_value') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        @if ($reward_type === 'badge')
        <div class="mb-4">
                <label for="reward_badge_title" class="form-label fw-bold text-secondary">Titre du badge</label>
                <input type="text" id="reward_badge_title" wire:model="reward_badge_title" class="form-control rounded-3 shadow-sm" placeholder="Titre du badge">
                @error('reward_badge_title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-secondary">Médias</label>

                <div class="mb-4">
    <div class="d-flex align-items-start gap-3 mb-3">
        {{-- Aperçu à gauche --}}
        @if ((isset($reward_image_file) && $reward_image_file) || (isset($reward_imageUrl) && $reward_imageUrl))
            <div class="flex-shrink-0 mr-2">
                @if (isset($reward_image_file) && $reward_image_file && method_exists($reward_image_file, 'temporaryUrl'))
                    <!-- Image temporaire uploadée via Livewire -->
                    <img src="{{ $reward_image_file->temporaryUrl() }}"
                        alt="Aperçu du badge"
                        class="img-thumbnail shadow-sm"
                        style="width: 120px; height: auto;">
                @elseif (isset($reward_imageUrl) && $reward_imageUrl)
                    <!-- Image existante (URL ou chemin stocké) -->
                    <img src="{{ $reward_imageUrl }}"
                        alt="Aperçu du badge"
                        class="img-thumbnail shadow-sm"
                        style="width: 120px; height: auto;">
                @endif
            </div>
        @endif

        {{-- Input file + feedback --}}
        <div class="flex-grow-1">
            <div class="d-flex gap-2 mb-2 align-items-center">
                <input type="file" wire:model="reward_image_file" class="form-control shadow-sm mr-2" accept="image/*">
            </div>
            @error('reward_image_file') <small class="text-danger">{{ $message }}</small> @enderror
            <div wire:loading wire:target="reward_image_file" class="text-info">Chargement du média…</div>
        </div>
    </div>
</div>

                
            </div>
        @endif

       
       

        <div class="text-end">
            {{-- <button 
                type="submit" 
                class="btn btn-primary px-5 py-2 shadow"
                wire:loading.attr="disabled"
            >

                {{ $rewardId ? '💾 Mettre à jour la recompense' : '🚀 Enrégistrer' }}
            </button> --}}
            @if(!$rewardId)
           <button 
                type="submit" 
                class="btn btn-primary px-5 py-2 shadow"
                wire:loading.attr="disabled"
            >🚀 Enrégistrer
            </button> 
            @endif
        </div>
    </form>
   

</div>
