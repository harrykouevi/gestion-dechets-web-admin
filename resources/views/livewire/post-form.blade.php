<div>
    
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

        
                
    <form id="myForm" wire:submit.prevent>
        @csrf
        @error('_mess_') 
            <span class="text-danger">{{ $message }}</span>
        @enderror
        @error('general') 
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="mb-4">
            <label for="post_type" class="form-label fw-bold text-secondary">Type de contenu</label>
            <select id="post_type" wire:model="post_type" class="form-control rounded-3 shadow-sm">
                <option value="educatif">Educatif</option>
            </select>
            @error('post_type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        
        <div class="mb-4">
            <label for="post_titre" class="form-label fw-bold text-secondary">Titre du Post</label>
            <input type="text" id="post_titre" wire:model="post_titre" class="form-control rounded-3 shadow-sm" placeholder="Titre du post éducatif">
            @error('post_titre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4">
            <label for="post_description" class="form-label fw-bold text-secondary">Description Post</label>
            <textarea id="post_description" wire:model="post_description" class="form-control rounded-3 shadow-sm" rows="2" placeholder="Rédige ici une description"></textarea>
            @error('post_description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4"  wire:ignore>
            <label for="post_content" class="form-label fw-bold text-secondary">Contenu du Post</label>
            <textarea   id="post_content" wire:model="post_content"  class="form-control rounded-3 shadow-sm" rows="5" placeholder="Rédige ici le contenu éducatif…"   style="display:none" ></textarea>
            
            @error('post_content') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4">
            <label for="post_visibility" class="form-label fw-bold text-secondary">Visibilité</label>
            <select id="post_visibility" wire:model="post_visibility" class="form-control rounded-3 shadow-sm">
                <option value="public">🌍 Public</option>
                <option value="private">🔒 Privé</option>
            </select>
            @error('post_visibility') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="text-end">
            <button type="submit" id="saveButton" class="btn btn-primary  px-5 py-2 shadow">
                {{ $postId ? '💾 Mettre à jour le Post' : '🚀 Enrégistrer' }}
            </button>
            @if( ! $postId)
            <button type="submit" class="btn btn-default px-5 py-2 shadow">
                {{ '🚀 Enrégistrer et créer un quiz' }}
            </button>
            @endif

            
            @if ($postId)
                <a href="{{ route('quizzes.create'). '?postId='.$postId }}" class="btn btn-outline-success px-5 py-2 shadow ms-3">
                    🎯 Aller au Quiz
                </a>
            @endif
        </div>
    </form>


</div>
