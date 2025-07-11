@extends('welcome')

@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white text-black">
                <h2 class="mb-0 text-center">Liste des stagiaires du : {{$country}}</h2>
                <h1>
                    <i class="bi bi-person-check text-primary me-2"></i>

                </h1>
            </div>
            @if(session('success'))
                <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Succès</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            @if (session('access_denied'))
            {{-- <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto"> Accès refusé </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div> --}}

            <div class="toast-container position-fixed top-50 start-50 translate-middle p-3" style="z-index: 9999;">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" style="min-width: 350px;">
                    <div class="toast-header bg-danger text-white border-0 rounded-top">
                        <div class="d-flex align-items-center">
                            <div class="pulse-animation me-2">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <strong class="me-auto">Erreur</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="toast-body bg-white rounded-bottom shadow-lg p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 text-success me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ session('acces_denied') }}</h5>
                                <p class="mb-0">{{ session('access_denied') }}</p>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" 
                                 role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                 .bg-gradient-primary {
                    background: linear-gradient(135deg, #4361ee, #3a0ca3);
                }
                
                .pulse-animation {
                    animation: pulse 2s infinite;
                }
                
                @keyframes pulse {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.1); }
                    100% { transform: scale(1); }
                }
                
                .toast {
                    border: none;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
                }
                
                .toast-body {
                    border-left: 4px solid #4bb543;
                }
            </style>
            @endif
                            
                                   
            

            <div class="card-body">

                <div class="row mb-3 g-2">
                    
                        <form action="{{route('SearchStagiare')}}" style="display: flex">

                            <input type="text" placeholder="Rechercher" class="form-control no-border-input" name="search" id="searchInput" value="{{ request()->input('search') ?? '' }}">
                            <button class="btn btn-primary" type="submit"> Rechercher</button>
                        </form>
                        
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Matricule</th>
                                <th>Stagiaire</th>
                                <th>Coordonnées</th>
                                <th>Informations</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stagiaires as $stagiaire)
                            <tr>
                                <td class="fw-semibold text-primary">
                                    {{ $stagiaire->matricule }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px">
                                            {{ substr($stagiaire->firstname, 0, 1) }}{{ substr($stagiaire->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $stagiaire->firstname }} {{ $stagiaire->name }}</div>
                                            <small class="text-muted">
                                                {{ Carbon\Carbon::parse($stagiaire->birthdate)->age }} ans
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><i class="bi bi-envelope me-2"></i>{{ $stagiaire->email }}</div>
                                    <div><i class="bi bi-telephone me-2"></i>
                                        @if($stagiaire->phone)
                                            {{ $stagiaire->phone }}
                                        @else
                                            <span class="text-muted">Non renseigné</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div><i class="bi bi-calendar me-2"></i>
                                        {{ Carbon\Carbon::parse($stagiaire->birthdate)->format('d/m/Y') }}
                                    </div>
                                    <div><i class="bi bi-globe me-2"></i>
                                        {{ $stagiaire->country ?? 'Non spécifié' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $stagiaire->validated == 1 ? 'success' : 'warning' }}">
                                        {{ $stagiaire->validated == 1 ? 'validé' : 'Non-validé' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-secondary" data-id="{{ $stagiaire->matricule }}"> Voir </button>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    
                    {{-- {{ $stagiaires->links()}} --}}
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    // Activation des tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(t => new bootstrap.Tooltip(t));

        // Gestion des clics sur les boutons "Voir"
        const voirButtons = document.querySelectorAll('.btn-secondary');

        voirButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (id) {
                    window.location.href = `/valider_stagiaire/${id}`;
                } else {
                    console.error('ID de stagiaire non trouvé');
                }
            });
        });
    });
</script>
