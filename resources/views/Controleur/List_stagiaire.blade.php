@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white text-black">
            <h2 class="mb-0 text-center">Liste des stagiaires</h2>
            <h1>
                <i class="bi bi-person-check text-primary me-2"></i>
               
            </h1>
        </div>
        
        <div class="card-body">
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
