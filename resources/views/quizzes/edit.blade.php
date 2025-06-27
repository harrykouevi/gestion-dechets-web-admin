@extends('layouts.app')

@section('title', '🎯 Crée ton Quiz !')

@push('styles')
    <!-- style sheets and font icons  -->
    <link rel="stylesheet" href="{{ asset('css/accounting.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.css" rel="stylesheet">

    <style>
    body {
            background: #f7f9fb;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }
        .card {
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .btn-primary {
            background-color: #4da6ff;
            border-color: #4da6ff;
        }
        .btn-primary:hover {
            background-color: #3399ff;
        }

        .custom-checkbox {
            transition: all 0.3s ease-in-out;
            border: 1px solid #0d6efd;
            width: 2rem;
            height: 1rem;
            cursor: pointer;
        }

        .custom-checkbox:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .form-check-label {
            margin-left: 0.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold text-primary">
            {{ isset($id) ? '✏️ Mise à jour de ton Quiz' : '🎉 Création d’un nouveau Quiz' }}
        </h2>
        <p class="text-muted">
            En route pour un nouveau défi intellectuel 😎 !<br>
            Complète les champs ci-dessous pour créer un quiz amusant et éducatif.
        </p>
    </div>
    
    

    <div class="card border-0 shadow-lg rounded-4 bg-light-subtle">
        <div class="card-body p-4">

    
            @livewire('quiz-form', isset($id) ? ['id' => $id] : ['postId' => $postId])
        </div>
    </div>

    {{-- <div class="container mt-4">
        <div class="mb-4">
            <h2 class="fw-bold text-primary">
                {{ isset($id) ? '✏️ Mise à jour de ton Quiz' : '🎉 Création d’un nouveau Quiz' }}
            </h2>
            <p class="text-muted">
                En route pour un nouveau défi intellectuel 😎 !<br>
                Complète les champs ci-dessous pour créer un quiz amusant et éducatif.
            </p>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow-sm text-success text-center fs-6 fw-semibold">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-lg rounded-4 bg-light-subtle">
            <div class="card-body p-4">

            
                @if (session('success'))
                    <div class="alert alert-success mb-4">
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

                    
                    <div class="mb-4">
                        <label for="course_id" class="form-label fw-bold text-secondary">
                            📘 Choisis le cours concerné
                        </label>
                        <select id="course_id" wire:model="course_id" class="form-control shadow-sm rounded-3">
                            <option value="">-- Sélectionne un cours --</option>
                            {{-- @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->nom }}</option>
                            @endforeach --}}
                        {{-- </select>
                        @error('course_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                

                    Titre 
                    <div class="mb-4">
                        <label for="titre" class="form-label fw-bold text-secondary">
                            📝 Titre du Quiz
                        </label>
                        <input type="text" id="titre" wire:model="titre" class="form-control rounded-3 shadow-sm" placeholder="Ex: Quiz sur les capitales">
                        @error('titre') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    
                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold text-secondary">
                            📄 Description
                        </label>
                        <textarea id="description" wire:model="description" class="form-control rounded-3 shadow-sm" rows="3" placeholder="Décris brièvement le but de ce quiz..."></textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    
                    <hr class="my-4">
                    <h4 class="text-success mb-3">🧠 Les Questions</h4>

                    @isset($quiz)
                        @foreach($quiz['questions'] as $index => $question)
                        <div class="card mb-4 shadow-sm rounded-3 border-0 bg-white">
                            <div class="card-body">
                                <h5 class="mb-3 text-primary">🔹 Question {{ $index + 1 }}</h5>

                                

                                <div class="mb-4 p-4 rounded shadow-sm border bg-light-subtle">
                                    <div class="mb-3">
                                        <label class="form-label">Texte</label>
                                        <input type="text" name="questions[{{ $index }}][text]" class="form-control" placeholder="Tape ici la question..." value="{{ $question['text'] ?? '' }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-primary">
                                            🎯 Nombre de points
                                        </label>
                                        <input 
                                            type="number" 
                                            name="questions[{{ $index }}][points]" 
                                            class="form-control border-primary shadow-sm" 
                                            value="{{ $question['points'] ?? '' }}" 
                                            placeholder="Ex : 5"
                                            required
                                        >
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label fw-bold text-primary">
                                            💡 Propositions
                                        </label>
                                    </div>

                                    @php
                                        $propositions = $question['propositions'] ?? collect([null, null]);
                                    @endphp

                                    @foreach($propositions as $i => $prop)
                                        <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                                            <input 
                                                type="text" 
                                                name="questions[{{ $index }}][propositions][{{ $i }}][text]" 
                                                value="{{ $prop['text'] ?? '' }}" 
                                                class="form-control me-3 border-info shadow-sm" 
                                                placeholder="Ex : Réponse possible..." 
                                                required
                                            >
                                           

                                            
                                            <div class="form-check form-switch">
                                                <input 
                                                    class="form-check-input custom-checkbox" 
                                                    type="checkbox" 
                                                    name="questions[{{ $index }}][propositions][{{ $i }}][is_correct]" 
                                                    id="correct_{{ $index }}_{{ $i }}"
                                                    {{ $prop['is_correct'] ?? false ? 'checked' : '' }}
                                                >
                                                <label class="form-check-label fw-semibold" for="correct_{{ $index }}_{{ $i }}">
                                                    Bonne réponse
                                                </label>
                                            </div>
                                        
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endisset

                    <div class="mb-4">
                        <button type="button" class="btn btn-outline-primary rounded-pill px-4" onclick="addQuestion()">
                            ➕ Ajouter une question
                        </button>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 shadow">
                            {{ $id ? '💾 Mettre à jour le Quiz' : '🚀 Lancer le Quiz' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script> 

<script>



    function initSummernoteWhenReady($el) {
        let tries = 0;
        const maxTries = 3;
        const interval = setInterval(() => {
           
            const contenu = $el.val();
            // Vérifie que l’élément est présent et que le contenu n’est pas vide
            if ($el.length && contenu && contenu.trim() !== '') {
                clearInterval(interval);
                $el.summernote({
                    height: 200,
                    placeholder: 'Écrivez votre contenu ici...',
                   
                });
            }

            if (++tries >= maxTries){ 
                $el.summernote({
                    height: 200,
                    placeholder: 'Écrivez votre contenu ici...',
                   
                });
                clearInterval(interval);
            }
        }, 300);
    }

    document.addEventListener('livewire:init', 
        function () {
            let summernote = $('textarea#description');
            initSummernoteWhenReady(summernote);

            document.addEventListener('submit', function (e) {
                
                const form = e.target;

                if (form.hasAttribute('question-form-attached')) {
                    e.preventDefault();
                    
                    const index = form.id.replace('QuizQuestionsForm', '');
                    const componentEl = form.closest('[wire\\:id]');
                    const component = Livewire.find(componentEl.getAttribute('wire:id'));

                    if (!component) {
                        alert('Composant Livewire non prêt');
                        return;
                    }

                    //  Gestion bouton de chargement
                    const submitBtn = form.querySelector('#saveButton');
                    const defaultLabel = submitBtn.querySelector('.default-label');
                    const loadingLabel = submitBtn.querySelector('.loading-label');
                    
                    component.set('requestontheway', true)
                    submitBtn.disabled = true;
                    defaultLabel.classList.add('d-none');
                    loadingLabel.classList.remove('d-none');

                    component.call('saveQuestion', index).then(() => {
                        // Réactiver le bouton après l'opération
                        const status = component.get('requestontheway');
                        if(status == false){
                            submitBtn.disabled = false;
                            defaultLabel.classList.remove('d-none');
                            loadingLabel.classList.add('d-none');
                        }
                    });
                }

                if(form?.id == "QuizForm"){
                    e.preventDefault();

                    const componentEl = document.querySelector('[wire\\:id]');
                    const component = Livewire.find(componentEl.getAttribute('wire:id'));
                    if (!component) {
                        alert('Composant Livewire non encore prêt.');
                        return;
                    }


                    // Gestion bouton de chargement
                    const submitBtn = form.querySelector('#saveButton');
                    const defaultLabel = submitBtn.querySelector('.default-label');
                    const loadingLabel = submitBtn.querySelector('.loading-label');
                    
                    component.set('requestontheway', true)
                    submitBtn.disabled = true;
                    defaultLabel.classList.add('d-none');
                    loadingLabel.classList.remove('d-none');
                    
                    // const submitBtn = document.querySelector('saveButton');
                    // submitBtn.disabled = true;
                    let contents = summernote.summernote('code');
                    component.set('quizz_description', contents).then(
                        () => {
                            component.call('saveQuiz').then(() => {
                                // Réactiver le bouton après l'opération
                                const status = component.get('requestontheway');
                                if(status == false){
                                    submitBtn.disabled = false;
                                    defaultLabel.classList.remove('d-none');
                                    loadingLabel.classList.add('d-none');
                                }
                            });
                        }
                    );
                }
            });

        }
    );

      
  </script>
@endpush

