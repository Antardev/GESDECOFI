@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <!-- En-tête avec badge de statut -->
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-person-gear me-2"></i>
                        Fiche du Contrôleur
                    </h2>
                    <span class="badge bg-{{ $controleur->type === 'National' ? 'danger' : ($controleur->type === 'Regional' ? 'warning' : 'info') }}">
                        {{ $controleur->type }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Colonne gauche - Avatar et info basique -->
                        <div class="col-md-4 text-center mb-4">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 120px; height: 120px; font-size: 2.5rem">
                                {{ substr($controleur->firstname, 0, 1) }}{{ substr($controleur->name, 0, 1) }}
                            </div>
                            <h4>{{ $controleur->firstname }} {{ $controleur->name }}</h4>
                            <p class="text-muted">{{ $controleur->affiliation ?? 'Aucune affiliation' }}</p>
                        </div>

                        <!-- Colonne droite - Détails -->
                        <div class="col-md-8">
                            <div class="row g-3">
                                <!-- Carte Coordonnées -->
                                <div class="col-12">
                                    <div class="card border-light mb-3">
                                        <div class="card-header bg-light">
                                            <i class="bi bi-person-lines-fill me-2"></i>Coordonnées
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <p><strong>Email :</strong> {{ $controleur->email }}</p>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <p><strong>Téléphone :</strong> 
                                                        @if($controleur->phone)
                                                            +{{ $controleur->phone_code }} {{ $controleur->phone }}
                                                        @else
                                                            <span class="text-muted">Non renseigné</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <p><strong>Pays d'affiliation:</strong> {{ $controleur->country }}</p>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <p><strong>Pays où il est controleur :</strong> {{ $controleur->country_contr }}</p>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <p><strong>Date d'enregistrement :</strong> 
                                                        {{ $controleur->created_at->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Carte Informations complémentaires -->
                                <div class="col-12">
                                    <div class="card border-light">
                                        <div class="card-header bg-light">
                                            <i class="bi bi-info-circle me-2"></i>Informations complémentaires
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <p><strong>Type :</strong> 
                                                        <span class="badge bg-{{ $controleur->type === 'National' ? 'danger' : ($controleur->type === 'Regional' ? 'warning' : 'info') }}">
                                                            {{ $controleur->type }}
                                                        </span>
                                                        @if($controleur->type=== 'CN')
                                                        <h6> Controleur nationale</h6>
                                                        @else
                                                        <h6>
                                                            Controleur Regionale
                                                        </h6>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <p><strong>Affiliation :</strong> 
                                                        {{ $controleur->affiliation ?? 'Aucune affiliation spécifiée' }}
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <p><strong>Date d'enregistrement :</strong> 
                                                        {{ $controleur->created_at->format('d/m/Y à H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                               <a href="{{url()->previous()}}" class="btn btn-outline-secondary"> 
                                <i class="align-item" data-feather="arrow-left"></i> Retour à la liste
                                
                                </a>
                                @if(!$controleur->validated)
                                <form action="{{route('admin.validate_controleur')}}">
                                    <input type="text" name="id" value="{{$controleur->id}}" hidden>

                                    <input type="text" name="type" value="{{$controleur->type}}" hidden>

                                    <div class="btn-group">
                                        <button trype="submit" class="btn btn-primary">
                                           <i class="align-item" date-feather="check"></i> valider
                                        </button>
                                    </div>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection