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

                    <form action="{{route('controleur.rapport.validate')}}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="rapport_name" class="form-label fw-bold">Nom du Rapport</label>
                            <input type="text" class="form-control" id="rapport_name" value="{{ $se[$rapport->rapport_name] }}" readonly>
                        </div>

                        <input type="hidden" id="rapport_id" name="rapport_id" value="{{ $rapport->id }}">

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

                        <div class="border rounded p-3 bg-light">
                            <span id="sanctionBtn" class="btn btn-outline-danger" style="cursor: pointer;">Appliquer sanction</span>
                            <div id="sanctionInputContainer" style="display: none; margin-top: 10px;">
                                <div class="input-group">
                                    <span class="input-group-text">Ajouter JT</span>
                                    <input type="number" id="sanctionInput" class="form-control" placeholder="Nombre de jours de sanction" min="1">
                                    <button type="button" id="confirmSanction" class="btn btn-primary">Confirmer</button>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Valider le Rapport</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sanctionBtn = document.getElementById('sanctionBtn');
        const sanctionInputContainer = document.getElementById('sanctionInputContainer');
        const confirmSanction = document.getElementById('confirmSanction');
        const reportValidationBtn = document.querySelector('button[type="submit"]'); // Select the submit button
        const form = document.querySelector('form'); // Select the form

        // Toggle input visibility
        sanctionBtn.addEventListener('click', function() {
            sanctionInputContainer.style.display = sanctionInputContainer.style.display === 'none' ? 'block' : 'none';
        });

        // Confirm sanction action
        confirmSanction.addEventListener('click', function() {
            const jours = document.getElementById('sanctionInput').value;
            const rapportId = document.getElementById('rapport_id').value;
            const stagiaireId = null; // You need to set this if available

            if (jours && jours > 0) {
                // Display "Application de la sanction"
                sanctionBtn.textContent = 'Application de la sanction...';
                
                fetch('{{ route("controleur.punish") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        rapport_id: rapportId,
                        stagiaire_id: stagiaireId,
                        jt_number: jours,
                        reason: '' // Include reason if needed
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Display success message and update button text
                        setTimeout(() => {
                            sanctionBtn.textContent = 'Sanction appliquée';
                            reportValidationBtn.textContent = 'Validation du Rapport...';
                            // Wait for 2 seconds before submitting the form
                            setTimeout(() => {
                                form.submit();
                            }, 2000);
                        }, 1000);
                    } else {
                        alert(data.message); // Display error message
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                alert('Veuillez entrer un nombre valide de jours');
            }
        });
    });
</script>
@endsection