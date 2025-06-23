@extends('layouts.app')

@section('title', 'Les Quizs')



@section('content') 
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Liste des Quiz</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- Content Row -->
    
    {{-- @livewire('list-of-waste-types') <!-- Include the Livewire component --> --}}
    <div  class="@if ($selectedQuiz) d-none @else row mb-4 @endif">
        <!-- Bouton Ajouter -->
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ route('quizzes.create') }}" class="btn btn-success">
                + Ajouter un nouveau quiz
            </a>
        </div>
    </div>
    <div class="@if ($selectedQuiz) d-none @else row mb-4 @endif">
        <!-- Content Row -->
        <div class="col-md-12">

            <div class="card shadow mb-4">
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="incidentTypesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Titre</th>
                                    <th>Cours</th>
                                    <th>Questions</th>
                                    <th>Points</th>
                                    <th>Date de création</th>

                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr>
                                    <td>{{ array_key_exists("id", $data ) ?  $data['id'] : 1}}</td>
                                    <td>{{ array_key_exists("title", $data ) ?  $data['title'] : 'title' }}</td>
                                    <td>{{ array_key_exists("course->title", $data ) ?  $data['course->title'] : 'course->title'}}</td>
                                    <td>{{ array_key_exists("questions->count", $data ) ?  $data['questions->count'] : 'questions->count'}}</td>
                                    <td>{{ array_key_exists("total_points", $data ) ?  $data['total_points'] : 'total_points'}}</td>
                                
                                    <td>{{ array_key_exists("created_at", $data ) ?  $data['created_at'] : 2025-05-13 }}</td>
                                    <td>
                                        <a href="{{ route('quizzes.edit', ['id' => 1 ]) }}" class="btn btn-sm btn-warning">Modifier</a>
                                        <form action="{{-- route('admin.quizzes.destroy', $data->id) --}}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce type ?')">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        

    </div>

  
@endsection