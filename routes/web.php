<?php

use Illuminate\Support\Facades\Route;

/*

    État
        ✅ Terminé
        ❌ Pas commencé
        ⚠️ Partiel

    Icône apparence	Icône données liées
        🎨✅     🧩✅
        🎨❌ 	🧩❌
        🎨⚠️	 🧩⚠️
*/

// routes/web.php
use Illuminate\Support\Facades\Http;



Route::get('/login', [\App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.submit');


Route::middleware(['microauth'])->group(function () {

    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');


    Route::get('/utilisateurs', [\App\Http\Controllers\UserController::class, 'index'])->name('getusers');
    //🎨✅ 🧩❌
    Route::get('/agents-de-collecte', [\App\Http\Controllers\AgentController::class, 'index'])->name('agents.index');
    //🎨✅ 🧩❌
    Route::get('/agents-de-collecte/{id}/edit', [\App\Http\Controllers\AgentController::class, 'update'])->name('agents.edit');
    //🎨✅ 🧩❌
    Route::get('/agents-de-collecte/ajouter-nouvel-agent', [\App\Http\Controllers\AgentController::class, 'create'])->name('agents.create');
    // Performances par agent/ménage (optionnel)
    //🎨✅ 🧩❌
    Route::get('/agents-de-collecte/{id}/performances', [\App\Http\Controllers\AgentController::class, 'performance'])->name('agents.performance');

    //🎨✅ 🧩❌
    Route::get('/menage', [\App\Http\Controllers\MenageController::class, 'index'])->name('menages.index');
    //🎨✅ 🧩❌
    Route::get('/menage/{id}/edit', [\App\Http\Controllers\MenageController::class, 'update'])->name('menages.edit');
    //🎨✅ 🧩❌
    Route::get('/menage/ajouter-menage', [\App\Http\Controllers\MenageController::class, 'create'])->name('menages.create');
    // Performances par agent/ménage (optionnel)
    //🎨✅ 🧩❌
    Route::get('/menages/{id}/historique', [\App\Http\Controllers\MenageController::class, 'historique'])->name('menages.historique');


    Route::get('/quizzes', [\App\Http\Controllers\QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/create', [\App\Http\Controllers\QuizController::class, 'create'])->name('quizzes.create');
    Route::get('/quizzes/{id}/edit', [\App\Http\Controllers\QuizController::class, 'edit'])->name('quizzes.edit');
    Route::get('/quizzes-results', [\App\Http\Controllers\QuizController::class, 'showResult'])->name('quizzes.results.show');


    Route::get('/rewards', [\App\Http\Controllers\RewardController::class, 'index'])->name('rewards.index');
    Route::get('/rewards/create', [\App\Http\Controllers\RewardController::class, 'create'])->name('rewards.create');
    Route::get('/rewards/{id}/edit', [\App\Http\Controllers\RewardController::class, 'edit'])->name('rewards.edit');
    // Route::put('/quizzes/{id}', [\App\Http\Controllers\QuizController::class, 'update'])->name('quizzes.update');
    // Route::delete('/quizzes/{id}', [\App\Http\Controllers\QuizController::class, 'destroy'])->name('quizzes.destroy') ;


    Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [\App\Http\Controllers\PostController::class, 'create'])->name('posts.create');
    // Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [\App\Http\Controllers\PostController::class, 'edit'])->name('posts.edit');


    // Collectes

    //🎨✅ 🧩✅
    Route::get('/types-dechets', [\App\Http\Controllers\WasteTypeController::class, 'index'])->name('types-dechets.index');
    //🎨✅ 🧩✅
    Route::get('/types-dechets/create', [\App\Http\Controllers\WasteTypeController::class, 'create'])->name('types-dechets.create');
    //🎨✅ 🧩✅
    Route::get('/types-dechets/{id}/edit', [\App\Http\Controllers\WasteTypeController::class, 'edit'])->name('types-dechets.edit');


    //🎨❌ 🧩❌
    // Route::get('/declarations', [\App\Http\Controllers\DeclarationController::class, 'index'])->name('getsubmissions');
    //🎨✅ 🧩❌
    Route::get('/demande-collectes', [\App\Http\Controllers\RequestedCollectController::class, 'index'])->name('requestcollects.index');
    //🎨✅ 🧩✅
    Route::get('/demande-collectes/create', [\App\Http\Controllers\RequestedCollectController::class, 'create'])->name('requestcollects.create');
    //🎨✅ 🧩❌
    Route::get('/demande-collectes/{id}/edit', [\App\Http\Controllers\RequestedCollectController::class, 'show'])->name('requestcollects.edit');
    //🎨✅ 🧩❌
    Route::get('/demande-collectes/stats', [\App\Http\Controllers\RequestedCollectController::class, 'index'])->name('requestcollects.stats');



    //🎨✅ 🧩❌
    Route::get('/collectes', [\App\Http\Controllers\CollectController::class, 'index'])->name('collectes.index');
    //🎨✅ 🧩✅
    Route::get('/collectes/create', [\App\Http\Controllers\CollectController::class, 'create'])->name('collectes.create');
    //🎨✅ 🧩❌
    Route::get('/collectes/{id}/edit', [\App\Http\Controllers\CollectController::class, 'show'])->name('collectes.edit');
    //🎨✅ 🧩❌
    Route::get('/collectes/stats', [\App\Http\Controllers\CollectController::class, 'index'])->name('collectes.stats');

});
