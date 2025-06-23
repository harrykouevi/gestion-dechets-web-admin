@extends('layouts.app')

@section('title', 'Agents de collectes')



@section('content') 
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Agents de collecte</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Content Row -->
    
    @livewire('list-of-agents') <!-- Include the Livewire component -->

@endsection