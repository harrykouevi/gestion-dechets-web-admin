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

       

    
    <form id="QuizForm" >
        @csrf

        {{-- Erreurs générales --}}
        @error('_mess_') 
            <span class="text-danger">{{ $message }}</span>
        @enderror
        @error('general') 
            <span class="text-danger">{{ $message }}</span>
        @enderror

        {{-- Cours --}}
        <div class="mb-4">
            <label for="post_id" class="form-label fw-bold text-secondary">
                📘 Choisis le cours concerné
            </label>
            <select id="post_id" wire:model="quizz_postId" class="form-control shadow-sm rounded-3" disabled>
                <option value="">-- Sélectionne un cours --</option>
                @if(is_array($post))
                    <option value="{{ $post['id'] }}" selected>{{ $post['titre'] ?? 'key:'.$post['id'] }}</option>
                @else
                    <option value="">Aucun</option>
                @endif
            </select>
            @error('quizz_post_id') <small class="text-danger">{{ $message }}</small> @enderror
            @error('quizz_postId') <small class="text-danger">{{ $message }}</small> @enderror
            
        </div>

        {{-- Titre --}}
        <div class="mb-4">
            <label for="titre" class="form-label fw-bold text-secondary">
                📝 Titre du Quiz
            </label>
            <input type="text" id="titre" wire:model="quizz_titre" class="form-control rounded-3 shadow-sm" placeholder="Ex: Quiz sur les capitales">
            @error('quizz_titre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Description (facultatif selon règle actuelle) --}}
        <div class="mb-4" wire:ignore>
            <label for="description" class="form-label fw-bold text-secondary">
                📄 Description
            </label>
            <textarea id="description"  wire:model="quizz_description"  class="form-control rounded-3 shadow-sm" rows="3" placeholder="Décris brièvement le but de ce quiz..."></textarea>
            @error('quizz_description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Score de réussite --}}
        <div class="mb-4">
            <label for="passing_score" class="form-label fw-bold text-secondary">
                ✅ Score de passage (%)
            </label>
            <input type="number" id="passing_score" wire:model="quizz_passing_score" class="form-control rounded-3 shadow-sm" min="0" max="100" placeholder="Ex: 70">
            @error('quizz_passing_score') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Nombre de questions --}}
        <div class="mb-4">
            <label for="nombre_question" class="form-label fw-bold text-secondary">
                ❓ Nombre de questions
            </label>
            <input type="number" id="nombre_question" wire:model.defer="quizz_nombre_question" class="form-control rounded-3 shadow-sm"  placeholder="Ex: 5">
            @error('quizz_nombre_question') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

    
        {{-- Récompenses (facultatif) --}}
        {{-- <div class="mb-4">
            <label class="form-label fw-bold text-secondary">🎁 Récompenses (optionnel)</label>
            @foreach ($reward_to_add as $i => $reward)
                <div class="input-group mb-2">
                    <input type="text" wire:model.defer="reward_to_add.{{ $i }}" class="form-control" placeholder="Récompense {{ $i + 1 }}">
                    <button type="button" wire:click="removeReward({{ $i }})" class="btn btn-outline-danger">🗑</button>
                </div>
            @endforeach
            <button type="button" wire:click.prevent="addReward" class="btn btn-sm btn-outline-secondary">+ Ajouter une récompense</button>
        </div>  --}}
        @if( is_null($quizzId) )
        <div class="mb-4">
            <label class="form-label fw-bold text-secondary">🧠 Questions (il est important de renseigner au moins une question )</label>
            @if(empty($quizz_questions))
               
                <div class="card rounded-3 border-0 bg-white">
                    <div class="card-body">
                        
                        <div class=" p-4 rounded shadow-sm border bg-light-subtle">
                        
                            <div class="mb-3">
                                <label for="post_id" class="form-label fw-bold text-secondary">
                                    📘 Type de question
                                </label>
                                <select id="post_id" wire:model="quizz_questions.0.type" class="form-control shadow-sm rounded-3" >
                                    <option value="">-- Sélectionne un cours --</option>
                                    <option selected value="single_choice">Question à choix unique</option>
                                    <option  value="multiple_choice">Uestion à choix multiple</option>
                                </select>
                                @error('quizz_questions.0.type') <small class="text-danger">{{ $message }}</small> @enderror

                            </div>

                            <div class="mb-3">
                                <label class="form-label">Libellé de la question</label>
                                <input type="text"  wire:model="quizz_questions.0.texte" class="form-control" placeholder="Tape ici la question..." value="{{ $question['text'] ?? '' }}" >
                                @error('quizz_questions.0.texte') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">
                                    🎯 Nombre de points
                                </label>
                                <input 
                                    type="number" 
                                    wire:model="quizz_questions.0.points" 
                                    class="form-control border-primary shadow-sm" 
                                    placeholder="Ex : 5"
                                    disabled
                                >
                                @error('quizz_questions.0.points') <small class="text-danger">{{ $message }}</small> @enderror

                            </div>

                        
                            <div class="mb-2">
                                <label class="form-label fw-bold text-primary"> 💡 Propositions (optionnel) </label>
                            </div>

                            @php
                                $propositions = $quizz_questions[0]['reponses'] ;
                            @endphp

                            
                            <div class="mb-4">
                            
                                @foreach ($propositions as $i => $prop)
                                
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                                    {{-- Champ de réponse --}}
                                    <div class="input-group mb-2">
                                        <input  id="question_0_prop{{ $i }}"  type="number"  wire:model="quizz_questions.0.reponses.{{ $i }}.texte" class="form-control me-3 border-info shadow-sm" placeholder="Réponse possible ... {{ $i }}">
                                        {{-- Bouton de suppression de la proposition --}}
                                        <button  type="button"  wire:click="removeProposition(0, {{ $i }})"  class="btn btn-outline-danger" > 🗑 </button>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-primary">
                                            🎯 Nombre de points
                                        </label>
                                        <input 
                                            type="number" 
                                            wire:model.lazy="quizz_questions.0.reponses.{{ $i }}.points" 
                                            class="form-control border-primary shadow-sm" 
                                            placeholder="Ex : 5"
                                            
                                        >
                                        @error('quizz_questions.0.points') <small class="text-danger">{{ $message }}</small> @enderror

                                    </div>

                                    {{-- Case à cocher pour indiquer la bonne réponse --}}
                                    <div class="form-check form-switch">
                                        <input  class="form-check-input custom-checkbox"  type="checkbox"  wire:model="quizz_questions.0.reponses.{{ $i }}.isCorrect" id="correct_quest_0_prop{{ $i }}">
                                        <label class="form-check-label fw-semibold" for="correct_quest_0_prop{{ $i }}"> Bonne réponse </label>
                                    </div>
                                    @error('quizz_questions.0.reponses.'. $i.'.texte') <small class="text-danger">{{ $message }}</small> @enderror
                                    @error('quizz_questions.0.reponses.'. $i.'.is_correct') <small class="text-danger">{{ $message }}</small> @enderror
                                    @error('quizz_questions.0.reponses.'. $i.'.isCorrect') <small class="text-danger">{{ $message }}</small> @enderror
                                    @error('quizz_questions.0.reponses.'. $i.'.points') <small class="text-danger">{{ $message }}</small> @enderror
                            
                                </div>
                            
                                @endforeach
                                <button type="button" wire:click.prevent="addPropositions(0)" class="btn btn-sm btn-outline-secondary">+ Ajouter une réponse</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @foreach($quizz_questions as $index => $question)
                @if($index==0)
                <div class="card rounded-3 border-0 bg-white">
                    <div class="card-body">
                        
                        <div class=" p-4 rounded shadow-sm border bg-light-subtle">
                        
                            <div class="mb-3">
                                <label for="post_id" class="form-label fw-bold text-secondary">
                                    📘 Type de question
                                </label>
                                <select id="post_id" wire:model="quizz_questions.{{ $index }}.type" class="form-control shadow-sm rounded-3" >
                                    <option value="">-- Sélectionne un cours --</option>
                                    <option value="single_choice" selected >Question à choix unique</option>
                                    <option  value="multiple_choice" >Uestion à choix multiple</option>
                   
                                </select>
                                @error('quizz_questions.0.type') <small class="text-danger">{{ $message }}</small> @enderror

                            </div>

                            <div class="mb-3">
                                <label class="form-label">Libellé de la question</label>
                                <input type="text"  wire:model="quizz_questions.{{ $index }}.texte" class="form-control" placeholder="Tape ici la question..." >
                                @error('quizz_questions.0.texte') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-primary">
                                    🎯 Nombre de points
                                </label>
                                <input 
                                    type="number" 
                                    wire:model="quizz_questions.{{ $index }}.points" 
                                    class="form-control border-primary shadow-sm" 
                                    placeholder="Ex : 5"
                                   disabled
                                >
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-bold text-primary"> 💡 Propositions (optionnel) </label>
                            </div>

                            @php
                                $propositions = $question['reponses'] ?? collect([null, null]);
                            @endphp

                            
                            <div class="mb-4">
                            
                                @foreach ($propositions as $i => $prop)
                                
                                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                                    {{-- Champ de réponse --}}
                                    <div class="input-group mb-2">
                                        <input  id="question_{{ $index }}_prop{{ $i }}"  type="text"  wire:model="quizz_questions.{{ $index }}.reponses.{{ $i }}.texte" class="form-control me-3 border-info shadow-sm" placeholder="Réponse possible ... {{ $i }}">
                                        {{-- Bouton de suppression de la proposition --}}
                                        <button  type="button"  wire:click="removeProposition({{ $index }}, {{ $i }})"  class="btn btn-outline-danger disabled" > 🗑 </button>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-primary">
                                            🎯 Nombre de points
                                        </label>
                                        <input 
                                            type="number" 
                                            wire:model.lazy="quizz_questions.{{ $index }}.reponses.{{ $i }}.points" 
                                            class="form-control border-primary shadow-sm" 
                                            placeholder="Ex : 5"
                                            
                                        >
                                        @error('quizz_questions.{{ $index }}.points') <small class="text-danger">{{ $message }}</small> @enderror

                                    </div>
                                    {{-- Case à cocher pour indiquer la bonne réponse --}}
                                    <div class="form-check form-switch">
                                        <input  class="form-check-input custom-checkbox"  type="checkbox"  wire:model="quizz_questions.{{ $index }}.reponses.{{ $i }}.isCorrect" id="correct_quest_{{ $index }}_prop{{ $i }}">
                                        <label class="form-check-label fw-semibold" for="correct_quest_{{ $index }}_prop{{ $i }}"> Bonne réponse </label>
                                    </div>
                                    @error('quizz_questions.0.reponses.'. $i.'.texte') <small class="text-danger">{{ $message }}</small> @enderror
                                    @error('quizz_questions.0.reponses.'. $i.'.is_correct') <small class="text-danger">{{ $message }}</small> @enderror
                                    @error('quizz_questions.0.reponses.'. $i.'.isCorrect') <small class="text-danger">{{ $message }}</small> @enderror
                            
                                </div>
                            
                                @endforeach
                                <button type="button" wire:click.prevent="addPropositions({{ $index }})" class="btn btn-sm btn-outline-secondary">+ Ajouter une réponse</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            @endif
            @error('questions') <small class="text-danger d-block">{{ $message }}</small> @enderror
        </div>
        @endif
       

        {{-- Bouton submit --}}
        <div class="mb-4">
            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 shadow" id="saveButton">
                <span class="default-label">
                    {{ isset($quizzId) && !is_null($quizzId) ? '💾 Mettre à jour le Quiz' : '🚀 Enrégistrer le Quiz' }}
                </span>
                <span class="loading-label d-none">
                    ⏳ Enregistrement…
                </span>
            </button>
            @if( isset($quizzId) && !is_null($quizzId))

                
                <a href="{{ route('rewards.create',['quizId'=>$quizzId]) }}" class="btn btn-success rounded-pill px-5 py-2 shadow ">🚀 Ajouter une récompenses</a>
                                      
            
            @endif
        </div>
       
    </form>

    @if( isset($quizzId) && !is_null($quizzId) )
    
       
        <hr class="my-4">
        <h4 class="text-success mb-3">🧠 Les Questions</h4>

      
        @foreach($quizz_questions as $index => $question)
        

            <div class="card rounded-3 border-0 bg-white">
                <div class="card-body">
                    <form  id="QuizQuestionsForm{{ $index }}" question-form-attached="true" >
                    @csrf
                    <div class=" p-4 rounded shadow-sm border bg-light-subtle">
                        <input type="hidden"  wire:model="quizz_questions.{{ $index }}.id" class="form-control" placeholder="Tape ici la question..." value="{{ $question['text'] ?? '' }}" >
                        
                        <div class="mb-3">
                            <label for="post_id" class="form-label fw-bold text-secondary">
                                📘 Type de question
                            </label>
                            <select id="post_id" wire:model="quizz_questions.{{ $index }}.type" class="form-control shadow-sm rounded-3" >
                                <option value="">-- Sélectionne un cours --</option>
                                <option selected value="single_choice">Question à choix unique</option>
                                <option  value="multiple_choice">Uestion à choix multiple</option>
                            </select>
                            @error('quizz_questions.'.$index.'.type') <small class="text-danger">{{ $message }}</small> @enderror

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Libellé de la question</label>
                            <input type="text"  wire:model="quizz_questions.{{ $index }}.texte" class="form-control" placeholder="Tape ici la question..." value="{{ $question['text'] ?? '' }}" >
                            @error('quizz_questions.'.$index.'.texte') <small class="text-danger">{{ $message }}</small> @enderror
                            
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-primary">
                                🎯 Nombre de points
                            </label>
                            <input 
                                type="number" 
                                wire:model="quizz_questions.{{ $index }}.points" 
                                class="form-control border-primary shadow-sm" 
                                placeholder="Ex : 5"
                                disabled
                            >
                            @error('quizz_questions.{{ $index }}.points') <small class="text-danger">{{ $message }}</small> @enderror

                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-bold text-primary"> 💡 Propositions (optionnel) </label>
                        </div>

                        @php
                            $propositions = $quizz_questions[$index]['reponses'] ;
                        @endphp

                        
                        <div class="mb-4">
                            
                            @foreach ($propositions as $i => $prop)
                                
                            <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                                {{-- Champ de réponse --}}
                                <div class="input-group mb-2">
                                    <input  id="question_{{ $index }}_prop{{ $i }}"  type="text"  wire:model="quizz_questions.{{ $index }}.reponses.{{ $i }}.texte" class="form-control me-3 border-info shadow-sm" placeholder="Réponse possible ... {{ $i }}">
                                    {{-- Bouton de suppression de la proposition --}}
                                    <button  type="button"  wire:click="removeProposition({{ $index }}, {{ $i }})"  class="btn btn-outline-danger" > 🗑 </button>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-primary">
                                        🎯 Nombre de points
                                    </label>
                                    <input 
                                        type="number" 
                                        wire:model.lazy="quizz_questions.{{ $index }}.reponses.{{ $i }}.points" 
                                        class="form-control border-primary shadow-sm" 
                                        placeholder="Ex : 5"
                                        
                                    >
                                    @error('quizz_questions.'.$index.'.points') <small class="text-danger">{{ $message }}</small> @enderror

                                </div>
                                {{-- Case à cocher pour indiquer la bonne réponse --}}
                                <div class="form-check form-switch">
                                    <input  class="form-check-input custom-checkbox"  type="checkbox"  wire:model="quizz_questions.{{ $index }}.reponses.{{ $i }}.isCorrect" id="correct_quest_{{ $index }}_prop{{ $i }}">
                                    <label class="form-check-label fw-semibold" for="correct_quest_{{ $index }}_prop{{ $i }}"> Bonne réponse </label>
                                </div>
                                @error('quizz_questions.'.$index .'.reponses.'. $i.'.texte') <small class="text-danger">{{ $message }}</small> @enderror
                                @error('quizz_questions.'.$index .'.reponses.'. $i.'.is_correct') <small class="text-danger">{{ $message }}</small> @enderror
                                @error('quizz_questions.'.$index .'.reponses.'. $i.'.isCorrect') <small class="text-danger">{{ $message }}</small> @enderror
                                @error('quizz_questions.'.$index .'.reponses.'. $i.'.points') <small class="text-danger">{{ $message }}</small> @enderror
                                
                            </div>

                            @endforeach
                            @if(count($propositions)  < 5)
                            <button type="button" wire:click="addPropositions({{ $index }})" class="btn btn-sm btn-outline-secondary">+ Ajouter une réponse</button>
                            @endif
                        </div>

                        <div class="mb-4">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 shadow " id="saveButton">
                                    <span class="default-label">
                                         {{ isset($question['id']) ? '💾 Mettre à jour une question' : '💾  Enrégistrer une question' }}
                                    </span>
                                    <span class="loading-label d-none">
                                        ⏳ Enregistrement…
                                    </span>
                                    
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>  
                </div>
            </div>
        
        @endforeach
        
        @if($quizz_nombre_question >  count($quizz_questions) )
        <div class="mb-4">
            <button type="button" class="btn btn-outline-primary rounded-pill px-4" wire:click="addQuestion">
                ➕ Ajouter une question
            </button>
        </div>
        @endif

        
        
    
    @endif
</div>
