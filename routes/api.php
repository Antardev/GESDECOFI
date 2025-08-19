<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StagiaireController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Dans routes/api.php
Route::get('/sous-domaines/{domaine}', function ($domaineId) {
    return App\Models\SubDomain::with('domain') // Charge la relation domain
        ->where('domain_id', $domaineId)
        ->get();
});

Route::get('/domains/{domain}/subdomains', function(Domain $domain) {
    return response()->json($domain->subdomains);
});

Route::post('/categories/quick-add', function(Request $request) {
    $request->validate(['name' => 'required|string|max:255|unique:categories,name']);
    
    $category = App\Models\BookCategorie::create(['name' => $request->name]);
    
    return response()->json($category);
})->middleware('auth');

Route::get('/stagiaire/get/{matricule}', [StagiaireController::class, 'getByMatricule']);