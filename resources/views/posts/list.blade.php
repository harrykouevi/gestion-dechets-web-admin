@extends('layouts.app')

@section('title', 'Les posts éducatifs')



@section('content') 
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">🗂️ Gestion des posts éducatifs</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Content Row -->
    
    @livewire('list-of-posts') <!-- Include the Livewire component -->
    

  
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
                component.set('postIdToDelete', id).then(() => {
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
        // component.set('postIdToDelete', null).then(() => {
            document.getElementById('closeModalLabel').click();
        // });
    });

    
</script>
@endpush