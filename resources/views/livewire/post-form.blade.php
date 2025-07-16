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

        

        <div class="mb-4">
            <label class="form-label fw-bold text-secondary">Médias</label>

            <div class="mb-4">
                @foreach($medias_to_show as $index => $media)
                    <div class="d-flex align-items-start gap-3 mb-3">
                        {{-- Aperçu à gauche --}}
                        @if (isset($post_medias[$index]['file']) && $post_medias[$index]['file'])
                            <div class="flex-shrink-0 mr-2">
                                <img src="{{ $post_medias[$index]['file']->temporaryUrl() }}"
                                    alt="media preview"
                                    class="img-thumbnail shadow-sm"
                                    style="width: 120px; height: auto;">
                            </div>
                        @else
                            @if (isset($media['path']) && $media['path'])
                            <div class="flex-shrink-0 mr-2">
                                <img src="{{ $media['path'] }}"
                                    alt="media preview"
                                    class="img-thumbnail shadow-sm"
                                    style="width: 120px; height: auto;">
                            </div>
                            @endif
                        @endif

                        {{-- Input file + type + delete --}}
                        <div class="flex-grow-1">
                            <div class="d-flex gap-2 mb-2 align-items-center">
                                <input type="file" wire:model="post_medias.{{ $index }}.file" class="form-control shadow-sm mr-2">
                                
                                <select id="post_type" wire:model="post_medias.{{ $index }}.type" class="form-control rounded-3 shadow-sm mr-2" style="width:150px;">
                                    <option value="">Type</option>
                                    <option value="image">Image</option>
                                </select>
                                <button type="button" class="btn btn-sm btn-danger" >✖</button>
                            </div>
                            @error("post_medias.$index.file") <small class="text-danger">{{ $message }}</small> @enderror
                            @error("post_medias.$index.type") <small class="text-danger">{{ $message }}</small> @enderror
                            <div wire:loading wire:target="post_medias.{{ $index }}.file" class="text-info">Chargement du média…</div>
                        </div>
                    </div>
                @endforeach
                @foreach($post_medias as $index => $media)
                @if (!isset($medias_to_show[$index]))

                    <div class="d-flex align-items-start gap-3 mb-3">
                        {{-- Aperçu à gauche --}}
                        @if (isset($media['file']) && $media['file'])
                            <div class="flex-shrink-0 mr-2">
                                <img src="{{ $media['file']->temporaryUrl() }}"
                                    alt="media preview"
                                    class="img-thumbnail shadow-sm"
                                    style="width: 120px; height: auto;">
                            </div>
                        @endif

                        {{-- Input file + type + delete --}}
                        <div class="flex-grow-1">
                            <div class="d-flex gap-2 mb-2 align-items-center">
                                <input type="file" wire:model="post_medias.{{ $index }}.file" class="form-control shadow-sm mr-2 ">
                                
                                <select id="post_type" wire:model="post_medias.{{ $index }}.type" class="form-control rounded-3 shadow-sm mr-2 " style="width:150px;">
                                    <option value="">Type</option>
                                    <option value="image">Image</option>
                                </select>
                                <button type="button" class="btn btn-sm btn-danger " >✖</button>
                            </div>
                            @error("post_medias.$index.file") <small class="text-danger">{{ $message }}</small> @enderror
                            @error("post_medias.$index.type") <small class="text-danger">{{ $message }}</small> @enderror
                            <div wire:loading wire:target="post_medias.{{ $index }}.file" class="text-info">Chargement du média…</div>
                        </div>
                    </div>
                @endif
                @endforeach

                <button type="button" class="btn btn-sm btn-outline-primary" wire:click.prevent="addMedia">+ Ajouter une image</button>
            </div>
            <div class="mb-4">
                <label for="post_video_url" class="form-label fw-bold text-secondary">Video</label>
                <input type="text" id="post_video_url" wire:model="post_video_url" class="form-control rounded-3 shadow-sm" placeholder="Url d'une video">
                @error('post_video_url') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
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
            <button 
                type="submit" 
                class="btn btn-primary px-5 py-2 shadow"
                wire:loading.attr="disabled"
                wire:target="@foreach($post_medias as $index => $m) medias.{{ $index }}.file, @endforeach"
            >

                {{ $postId ? '💾 Mettre à jour le Post' : '🚀 Enrégistrer' }}
            </button>
            @if( ! $postId)
            <button 
            type="submit" 
            class="btn btn-outline-secondary px-5 py-2 shadow"
            wire:loading.attr="disabled"
            wire:target="@foreach($post_medias as $index => $m) post_medias.{{ $index }}.file, @endforeach"  >
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
    @push('scripts')
        <script>
               document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById('vimeo-player-container');
        container.addEventListener('click', function () {
            container.innerHTML = `
                <iframe src="https://player.vimeo.com/video/22439234" 
    width="560" height="315" frameborder="0"
    allow="autoplay; fullscreen; picture-in-picture" 
    allowfullscreen>
</iframe>`;
        });
    });
        </script>
    @endpush

</div>
