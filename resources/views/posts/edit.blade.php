@extends('layouts.app')

@section('title', '🎯 Crée ton Post !')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }

    .form-check-label {
        margin-left: 0.5rem;
    }
</style>
@endpush



@section('content') 
    <div class="mb-4">
        <h2 class="fw-bold text-primary">
            {{ isset($id) ? '✏️ Mise à jour de ton Post' : '🎉 Création d’un nouveau Post' }}
        </h2>
        <p class="text-muted">
            En route pour un nouveau défi intellectuel 😎 !<br>
            Complète les champs ci-dessous pour créer un post amusant et éducatif.
        </p>
    </div>
    
    
  
   

    <div class="card border-0 shadow-lg rounded-4 bg-light-subtle">
        <div class="card-body p-4">

        
            @livewire('post-form', isset($id) ? ['id' => $id] : [])
        </div>
    </div>
    

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs4.min.js"></script> 

<script>
    $(document).ready(function() {

       
        // $("textarea").length > 0 && $("textarea#post_content").summernote({
        //     height: 200
        // }),
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


    });

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

            let summernote = $('textarea#post_content');

            initSummernoteWhenReady(summernote);
           
            document.getElementById('myForm').addEventListener('submit', 
                function(e) {
                    e.preventDefault();

                    const componentEl = document.querySelector('[wire\\:id]');
                    const component = Livewire.find(componentEl.getAttribute('wire:id'));
                    if (!component) {
                        alert('Composant Livewire non encore prêt.');
                        return;
                    }
                    // const submitBtn = document.querySelector('saveButton');
                    // submitBtn.disabled = true;
                    let contents = summernote.summernote('code');
                    component.set('post_content', contents).then(
                        () => {
                            component.call('save')
                            // .then(
                            //     () => {
                                    // setTimeout(() => {
                                    //     alert(contents) ;
                                    //     // submitBtn.disabled = false; // re-enable after save done
                                    // }, 2250);
                            //     }
                            // ); 
                            
                        }
                    );
                }
            );
        }
    );

      
  </script>
@endpush
