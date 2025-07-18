<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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