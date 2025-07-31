@extends('welcome')
@section('title', 'Mes Diligences')
@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-bell-fill text-primary me-2"></i>Mes Diligences
                    </h1>
                    <span class="badge bg-primary rounded-pill">
                        ..
                    </span>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">

                            <div class="list-group-item unread-notification">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="bi bi-calendar-check fs-3 text-warning"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="mb-1">Nombre de stagiaires en attente de validation</h3>
                                            <span class="badge bg-success rounded-pill">{{$stagiaires_not_validated?$stagiaires_not_validated:0}}</span>
                                        </div>
                                        <p class="mb-2 text-muted">Les étudiants de votre pays qui se sont inscrits et attendent que vous validiez leur inscription.</p>
                                        <div class="d-flex gap-2 mt-3">
                                            <a href="{{route('CN.diligences_table').'?a=sav'}}" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-lg me-1"></i> Voir la liste
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <style>
        .list-group-item {
            transition: background-color 0.2s;
        }
        .list-group-item:hover {
            background-color: #f8f9fa !important;
        }
        .notification-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .unread-notification {
            border-left: 4px solid #0d6efd;
            background-color: #f8f9fa;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection 
{{-- 
@extends('welcome')
@section('title', 'Mes Diligences')
@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="bi bi-bell-fill text-primary me-2"></i>Mes Diligences
                </h1>
                <span class="badge bg-primary rounded-pill">3</span>
            </div>

            <!-- Carte principale -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-card-checklist me-2"></i>Diligences
                </div>
                <div class="card-body">
                    <!-- Première ligne - Statistiques -->
                    <div class="row mb-4">
                        <!-- Carte Attestations en attente -->
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="card h-100 border-start border-primary border-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-subtitle text-muted">Attestations à délivrer</h6>
                                            <h2 class="text-primary mt-2">4</h2>
                                            <small class="text-muted">En attente de validation</small>
                                        </div>
                                        <i class="bi bi-file-earmark-text fs-1 text-primary opacity-25"></i>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="#" class="btn btn-sm btn-outline-primary w-100">
                                        <i class="bi bi-eye me-1"></i> Voir la liste
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Autres cartes statistiques (exemples) -->
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="card h-100 border-start border-success border-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-subtitle text-muted">Attestations valider </h6>
                                            <h2 class="text-success mt-2">12</h2>
                                            <small class="text-muted">Validées ce mois</small>
                                        </div>
                                        <i class="bi bi-file-earmark-check fs-1 text-success opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card h-100 border-start border-warning border-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-subtitle text-muted">Stages</h6>
                                            <h2 class="text-warning mt-2">7</h2>
                                            <small class="text-muted">En cours</small>
                                        </div>
                                        <i class="bi bi-briefcase fs-1 text-warning opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Liste des notifications -->
                    {{-- <h5 class="mb-3"><i class="bi bi-list-check me-2"></i>Dernières demandes</h5>
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3 text-warning">
                                    <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Validation d'attestation urgente</h6>
                                        <span class="badge bg-danger">Aujourd'hui</span>
                                    </div>
                                    <p class="mb-0 small text-muted">Étudiant: Jean Dupont - Promotion 2023</p>
                                </div>
                                <button class="btn btn-sm btn-outline-primary ms-3">
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3 text-primary">
                                    <i class="bi bi-file-earmark-text fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Attestation de stage</h6>
                                        <span class="badge bg-secondary">Hier</span>
                                    </div>
                                    <p class="mb-0 small text-muted">Étudiant: Marie Martin - Promotion 2023</p>
                                </div>
                                <button class="btn btn-sm btn-outline-primary ms-3">
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .list-group-item {
        transition: background-color 0.2s;
        border-left: none;
        border-right: none;
    }
    .list-group-item:first-child {
        border-top: none;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .border-4 {
        border-width: 4px !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection--}}