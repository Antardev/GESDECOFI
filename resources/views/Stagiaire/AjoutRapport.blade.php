@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <form action="{{ route('stagiaire.save_rapport') }}" method="POST" enctype="multipart/form-data" class="border rounded-3 shadow-lg overflow-hidden">
                @csrf
                <div class="modal-header bg-primary text-white p-4">
                    <div class="d-flex align-items-center">
                        <i class="feather-icon me-2" data-feather="file-text" style="width: 24px; height: 24px;"></i>
                        <h3 class="modal-title fw-bold mb-0">Envoyer un rapport</h3>
                    </div>
                    <i class="feather-icon" data-feather="alert-circle" style="width: 24px; height: 24px;"></i>
                </div>
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Rapport semestriel</h2>
                        <p class="text-muted">Veuillez renseigner les informations concernant le rapport</p>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label for="rapport_name" class="form-label fw-bold">Nom du la rapport <span class="text-danger text-small">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-heading text-primary"></i>
                            </span>
                            <select name="rapport_name" class="form-select @error('rapport_name') is-invalid @enderror" id="rapport_name" required>
                                <option value="default" {{old('rapport_name')==''?'selected':''}}>
                                    Non du rapport
                                </option>
                                <option value="R1" {{old('rapport_name')=='R1'?'selected':''}}>
                                    Rapport Semestre 1
                                </option>
                                <option value="R2" {{old('rapport_name')=='R2'?'selected':''}}>
                                    Rapport Semestre 2
                                </option>
                                <option value="R3" {{old('rapport_name')=='R3'?'selected':''}}>
                                    Rapport Semestre 3
                                </option>
                                <option value="R4" {{old('rapport_name')=='R4'?'selected':''}}>
                                    Rapport Semestre 4
                                </option>
                                <option value="R5" {{old('rapport_name')=='R5'?'selected':''}}>
                                    Rapport Semestre 5
                                </option>
                                <option value="R6" {{old('rapport_name')=='R6'?'selected':''}}>
                                    Rapport Semestre 6
                                </option>
                            </select>
                            <span id='default' class="input-group-text bg-warning text-dark fw-bold">
                                Délai: Sélectionnez
                            </span>
                            <span id='R1' style="display:none;" class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $year['first']['limite'] }}
                            </span>
                            <span id='R2' style="display:none;" class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $year['second']['limite'] }}
                            </span>
                            <span id='R3' style="display:none;" class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $year['third']['limite'] }}
                            </span>
                            <span id='R4' style="display:none;" class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $year['fourth']['limite'] }}
                            </span>
                            <span id='R5' style="display:none;" class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $year['fifth']['limite'] }}
                            </span>
                            <span id='R6' style="display:none;" class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $year['sixth']['limite'] }}
                            </span>
                            @error('rapport_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror  
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="rapport_comment" class="form-label fw-bold">Commentaire(facultatif)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light align-items-start pt-2">
                                <i class="fas fa-align-left text-primary"></i>
                            </span>
                            <textarea class="form-control @error('rapport_comment') is-invalid @enderror" id="rapport_comment" name="rapport_comment" rows="4" placeholder="Décrivez le contenu de la JT..." >{{old('rapport_comment')}}</textarea>
                            @error('rapport_comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="rapport" class="form-label fw-bold">Rapport (PDF) <span class="text-danger text-small">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-file-pdf text-primary"></i>
                            </span>
                            <input type="file" class="form-control @error('rapport') is-invalid @enderror" id="rapport" name="rapport" accept=".pdf" required>
                            @error('rapport')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Format accepté: PDF (max 5MB)</small>
                    </div>

                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold">
                            <i class="fas fa-save me-2"></i>{{ __('message.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ajout des icônes Feather -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>

<!-- Ajout de Font Awesome pour les autres icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .feather-icon {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .form-label {
        margin-bottom: 0.5rem;
        color: #495057;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupération des éléments
        const rapportSelect = document.querySelector('select[name="rapport_name"]');
        const deadlineSpans = {
            default: document.getElementById('default'),
            R1: document.getElementById('R1'),
            R2: document.getElementById('R2'),
            R3: document.getElementById('R3'),
            R4: document.getElementById('R4'),
            R5: document.getElementById('R5'),
            R6: document.getElementById('R6'),
        };

        // Fonction pour gérer le changement de sélection
        function updateDeadlineDisplay() {
            // Masquer tous les spans de délai
            Object.values(deadlineSpans).forEach(span => {
                span.style.display = 'none';
            });

            // Afficher le span correspondant ou le span par défaut
            const selectedValue = rapportSelect.value;
            if (selectedValue && deadlineSpans[selectedValue]) {
                deadlineSpans[selectedValue].style.display = 'inline-block';
            } else {
                deadlineSpans.default.style.display = 'inline-block';
            }
        }

        rapportSelect.addEventListener('change', updateDeadlineDisplay);

        // Initialisation au chargement de la page
        updateDeadlineDisplay();
    });

</script>
@endsection