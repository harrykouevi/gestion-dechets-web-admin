<div>
    
    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @error('general_erreur') 
        <div class="alert alert-danger">
            {!! $message !!}
            @error('wastetype_id') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror

        </div>
    @enderror

        
                
    <form wire:submit="save">
        @error('_mess_') 
            <span class="text-danger">{{ $message }}</span>
        @enderror
        @error('general') 
            <span class="text-danger">{{ $message }}</span>
        @enderror
    
        <div class="mb-4">
            <label for="wastetype_unite" class="form-label fw-bold text-secondary">Unité</label>
            <select id="wastetype_unite" wire:model="wastetype_unite" class="form-control rounded-3 shadow-sm">
                <option value="Kg" >Kg</option>
                <option value="Litre" >Litre</option>
            </select>
            @error('wastetype_unite') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4">
            <label for="wastetype_prix" class="form-label fw-bold text-secondary">Prix</label>
            <input type="text" id="wastetype_prix" wire:model="wastetype_prix" class="form-control rounded-3 shadow-sm" >
            @error('wastetype_prix') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        
        <div class="mb-4">
            <label for="wastetype_nom" class="form-label fw-bold text-secondary">Libellé</label>
            <input type="text" id="wastetype_nom" wire:model="wastetype_nom" class="form-control rounded-3 shadow-sm" >
            @error('wastetype_nom') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-4">
            <label for="wastetype_description" class="form-label fw-bold text-secondary">Description</label>
            <textarea id="wastetype_description" wire:model="wastetype_description" class="form-control rounded-3 shadow-sm" rows="2" placeholder="Rédige ici une description"></textarea>
            @error('wastetype_description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>


        {{-- <div class="mb-4">
            <label class="form-label fw-bold text-secondary">Médias</label>

            <div class="mb-4">
                @foreach($medias_to_show as $index => $media)
                    <div class="d-flex align-items-start gap-3 mb-3">
                        @if (isset($wastetype_medias[$index]['file']) && $wastetype_medias[$index]['file'])
                            <div class="flex-shrink-0 mr-2">
                                <img src="{{ $wastetype_medias[$index]['file']->temporaryUrl() }}"
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

                        <div class="flex-grow-1">
                            <div class="d-flex gap-2 mb-2 align-items-center">
                                <input type="file" wire:model="wastetype_medias.{{ $index }}.file" class="form-control shadow-sm mr-2">
                                
                                <select id="wastetype_unite" wire:model="wastetype_medias.{{ $index }}.type" class="form-control rounded-3 shadow-sm mr-2" style="width:150px;">
                                    <option value="">Type</option>
                                    <option value="image">Image</option>
                                </select>
                                <button type="button" class="btn btn-sm btn-danger" >✖</button>
                            </div>
                            @error("wastetype_medias.$index.file") <small class="text-danger">{{ $message }}</small> @enderror
                            @error("wastetype_medias.$index.type") <small class="text-danger">{{ $message }}</small> @enderror
                            <div wire:loading wire:target="wastetype_medias.{{ $index }}.file" class="text-info">Chargement du média…</div>
                        </div>
                    </div>
                @endforeach
                @foreach($wastetype_medias as $index => $media)
                @if (!isset($medias_to_show[$index]))

                    <div class="d-flex align-items-start gap-3 mb-3">
                        @if (isset($media['file']) && $media['file'])
                            <div class="flex-shrink-0 mr-2">
                                <img src="{{ $media['file']->temporaryUrl() }}"
                                    alt="media preview"
                                    class="img-thumbnail shadow-sm"
                                    style="width: 120px; height: auto;">
                            </div>
                        @endif

                        <div class="flex-grow-1">
                            <div class="d-flex gap-2 mb-2 align-items-center">
                                <input type="file" wire:model="wastetype_medias.{{ $index }}.file" class="form-control shadow-sm mr-2 ">
                                
                                <select id="wastetype_unite" wire:model="wastetype_medias.{{ $index }}.type" class="form-control rounded-3 shadow-sm mr-2 " style="width:150px;">
                                    <option value="">Type</option>
                                    <option value="image">Image</option>
                                </select>
                                <button type="button" class="btn btn-sm btn-danger " >✖</button>
                            </div>
                            @error("wastetype_medias.$index.file") <small class="text-danger">{{ $message }}</small> @enderror
                            @error("wastetype_medias.$index.type") <small class="text-danger">{{ $message }}</small> @enderror
                            <div wire:loading wire:target="wastetype_medias.{{ $index }}.file" class="text-info">Chargement du média…</div>
                        </div>
                    </div>
                @endif
                @endforeach

                <button type="button" class="btn btn-sm btn-outline-primary" wire:click.prevent="addMedia">+ Ajouter une image</button>
            </div>
            <div class="mb-4">
                <label for="wastetype_video_url" class="form-label fw-bold text-secondary">Video</label>
                <input type="text" id="wastetype_video_url" wire:model="wastetype_video_url" class="form-control rounded-3 shadow-sm" placeholder="Url d'une video">
                @error('wastetype_video_url') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div> --}}

        <div class="mb-4">
            <label for="wastetype_actif" class="form-label fw-bold text-secondary">Actif</label>
            <select id="wastetype_actif" wire:model="wastetype_actif" class="form-control rounded-3 shadow-sm">
                <option value="0">Non</option>
                <option value="1">Oui</option>
            </select>
            @error('wastetype_actif') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="text-end">
            <button 
                type="submit" 
                class="btn btn-primary px-5 py-2 shadow"
                wire:loading.attr="disabled" >

                {{ $wastetypeId ? '💾 Mettre à jour le type' : '🚀 Enrégistrer' }}
            </button>
         

            
        
        </div>
    </form>
   

</div>
