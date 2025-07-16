@extends('layouts.app')

@section('title', 'Les posts éducatifs')



@section('content') 
    <!-- Fil d'Ariane -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('posts.index') }}">🗂️ Gestion des posts éducatifs</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                📋 Liste des recompenses
            </li>
        </ol>
    </nav>


    <!-- Titre principal + bouton retour -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 mb-0">📋 Liste des recompenses</h1>
        <a href="{{ route('posts.index') }}" class="btn btn-sm btn-secondary">
            ← Retour à la gestion des posts
        </a>
    </div>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Content Row -->
    
    @livewire('list-of-rewards') <!-- Include the Livewire component -->
    

  
@endsection



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.open-delete-modal').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                
                let component = Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));
                if (!component) return;

                // ✅ 4. Met à jour la propriété (ceci déclenche le re-render)
                component.set('rewardIdToDelete', id).then(() => {
                    // ✅ Ce bloc s'exécute après que Livewire a mis à jour la DOM
                    const modalElement = document.getElementById('confirmDeleteModal');
                    if (modalElement) {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    }
                });
            });
        });
    });

    window.addEventListener('post-deleted', function () {
       
        // let component = Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));
        // if (!component) return;
        // component.set('rewardIdToDelete', null).then(() => {
            document.getElementById('closeModalLabel').click();
        // });
    });

    
</script>
@endpush