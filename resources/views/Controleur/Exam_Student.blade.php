@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border rounded-3 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Validation de Soumission de Rapport</h3>
                </div>
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
                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-info text-center">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form action="" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="rapport_name" class="form-label fw-bold">Nom du Rapport</label>
                            <input type="text" class="form-control" id="rapport_name" value="{{ $se[$rapport->rapport_name] }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="date_submission" class="form-label fw-bold">Date de Soumission</label>
                            <input type="text" class="form-control" id="date_submission" value="{{ $rapport->created_at->format('d/m/Y H:i') }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="deadline" class="form-label fw-bold">Date Limite</label>
                            <input type="text" class="form-control" id="deadline" value="{{ \Carbon\Carbon::parse($rapport->stagiaire->dead_0_semester)->format('d/m/Y') }}" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">Statut</label>
                            <input type="text" class="form-control" id="status" 
                                   value="{{ \Carbon\Carbon::parse($rapport->created_at) > \Carbon\Carbon::parse($rapport->stagiaire->dead_0_semester) ? 'Retard' : 'À Jour' }}" readonly>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Fichier PDF du Rapport</label>
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
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Valider le Rapport
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control[readonly] {
        background-color: #f8f9fa;
        color: #495057;
    }
</style>
@endsection