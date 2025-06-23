<?php

use Illuminate\Support\Facades\Route;



// routes/web.php
use Illuminate\Support\Facades\Http;



Route::get('/login', [\App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.submit');
Route::get('/waste-types', [\App\Http\Controllers\WasteTypeController::class, 'index'])->name('getwastetypes');


Route::middleware(['microauth'])->group(function () {
  
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/utilisateurs', [\App\Http\Controllers\UserController::class, 'index'])->name('getusers');
    Route::get('/agents-de-collecte', [\App\Http\Controllers\AgentController::class, 'index'])->name('agents.index');
    Route::get('/agents-de-collecte/{id}/edit', [\App\Http\Controllers\AgentController::class, 'update'])->name('agents.edit');
    Route::get('/agents-de-collecte/ajouter-nouvel-agent', [\App\Http\Controllers\AgentController::class, 'create'])->name('agents.create');

    
    Route::get('/menage', [\App\Http\Controllers\MenageController::class, 'index'])->name('menages.index');
    Route::get('/menage/{id}/edit', [\App\Http\Controllers\MenageController::class, 'update'])->name('menages.edit');
    Route::get('/menage/ajouter-menage', [\App\Http\Controllers\MenageController::class, 'create'])->name('menages.create');


    Route::get('/declarations', [\App\Http\Controllers\DeclarationController::class, 'index'])->name('getsubmissions');

    Route::get('/quizzes', [\App\Http\Controllers\QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/create', [\App\Http\Controllers\QuizController::class, 'create'])->name('quizzes.create');
    // Route::post('/quizzes', [\App\Http\Controllers\QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{id}/edit', [\App\Http\Controllers\QuizController::class, 'edit'])->name('quizzes.edit');
    // Route::put('/quizzes/{id}', [\App\Http\Controllers\QuizController::class, 'update'])->name('quizzes.update');
    // Route::delete('/quizzes/{id}', [\App\Http\Controllers\QuizController::class, 'destroy'])->name('quizzes.destroy') ;
    
    Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [\App\Http\Controllers\PostController::class, 'create'])->name('posts.create');
    // Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [\App\Http\Controllers\PostController::class, 'edit'])->name('posts.edit');
    // Route::put('/posts/{id}', [\App\Http\Controllers\PostController::class, 'update'])->name('posts.update');
    // Route::delete('/posts/{id}', [\App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy') ;

    Route::get('/proxy-carte', function () {
        $response = Http::withToken(session('token'))
            ->get(env('MAP_SERVICE_URL').'/api/map-directions?start=48.857547,2.351376&end=48.866547,2.351376&alternatives=3');
        return response($response->body(), 200)
            ->header('Content-Type', 'text/html');
    })->name('proxy-carte') ;
});