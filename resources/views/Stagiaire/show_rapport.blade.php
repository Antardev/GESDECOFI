@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border rounded-3 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Détails de Votre Rapport</h3>
                </div>
                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-info text-center">
                            {{ session('message') }}
                        </div>
                    @endif

                    @php
                    $se = [
                        'R1' => 'Rapport Semestre 1',
                        'R2' => 'Rapport Semestre 2',
                        'R3' => 'Rapport Semestre 3',
                        'R4' => 'Rapport Semestre 4',
                        'R5' => 'Rapport Semestre 5',
                        'R6' => 'Rapport Semestre 6',
                    ];
                    @endphp

                    <div class="mb-4">
                        <h5 class="fw-bold">Nom du Rapport</h5>
                        <p class="border p-2 rounded bg-light">{{ $se[$rapport->rapport_name] }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold">Date de Soumission</h5>
                        <p class="border p-2 rounded bg-light">{{ $rapport->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold">Date Limite</h5>
                        <p class="border p-2 rounded bg-light">{{ \Carbon\Carbon::parse($rapport->stagiaire->dead_0_semester)->format('d/m/Y') }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold">Statut</h5>
                        <p class="border p-2 rounded bg-light">
                            {{ \Carbon\Carbon::parse($rapport->created_at) > \Carbon\Carbon::parse($rapport->stagiaire->dead_0_semester) ? 'Retard' : 'À Jour' }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold">Fichier PDF du Rapport</h5>
                        <div class="border rounded p-3 bg-light">
                            @if($rapport->rapport_file)
                                <a href="{{ asset('storage/' . $rapport->rapport_file) }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-file-pdf me-2"></i>Voir le rapport PDF
                                </a>
                                <small class="d-block mt-2 text-muted">Taille: {{ round(filesize(storage_path('app/public/' . $rapport->file_path)) / 1024, 2) }} KB</small>
                            @else
                                <p class="text-danger">Aucun fichier PDF trouvé</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold">Action</h5>
                        <div class="d-grid gap-2">
                            <button id="sanctionBtn" class="btn btn-outline-danger" style="cursor: pointer;">Signaler un Problème</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border {
        border: 1px solid #ced4da;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sanctionBtn = document.getElementById('sanctionBtn');
        sanctionBtn.addEventListener('click', function() {
            alert('Pour signaler un problème, veuillez contacter votre enseignant ou le responsable.');
        });
    });
</script>
@endsection