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

    <!-- Fil d’Ariane -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('posts.index') }}">🗂️ Gestion des posts éducatifs</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('quizzes.index') }}">📋 Liste des Quiz</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ isset($id) ? '✏️ Modifier un Quiz' : '🎉 Nouveau Quiz' }}
            </li>
        </ol>
    </nav>

    <!-- Titre principal + bouton retour -->
    
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary mb-0">
                {{ isset($id) ? '✏️ Mise à jour de ton Quiz' : '🎉 Création d’un nouveau Quiz' }}
            </h2>
            <a href="{{ route('quizzes.index') }}" class="btn btn-sm btn-secondary">
                ← Retour à la liste des quiz
            </a>
        </div>
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

