{{-- @extends('welcome')

@section('content')

        <form action="{{ route('stagiaire.create') }}" method="POST">
            @csrf
                <div class="modal-header bg-primary text-white">
                    <h3 class="modal-title font-bold py-2">
                        <i class="align-middle me-2 py-2" data-feather="file-text"></i>
                        Ajouter une activité
                    </h3>
                    <i class="align-middle me-2 py-2 text-white" data-feather="alert-circle"></i>
                </div>

                <div class="modal-body">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <h2 class="mb-4">Entrez les informations à propos de la Journée Technique</h2>

                            <hr class="my-4">

                            <div class="mb-3 text-start">
                                <label for="jt_name" class="form-label">Entrez le nom de la JT</label>
                                <input type="text" class="form-control @error('jt_name') is-invalid @enderror" id="jt_name" name="jt_name" value="{{old('jt_name')}}" required>
                                @error('jt_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-start">
                                <label for="name" class="form-label">Quand-est-ce que vous avez eu à faire cette JT</label>
                                <input type="text" class="form-control @error('jt_date') is-invalid @enderror" id="name" name="name" value="{{ old('jt_date') }}" required>
                                @error('jt_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 text-start">
                                <label for="jt_year" class="form-label">Année JT (délai: {{ $delai }})</label>
                                <input type="text" class="form-control" id="jt_year" name="jt_year" value="{{$year}}" readonly>
                            </div>

                            <div class="mb-3 text-start">
                                <label for="jt_description" class="form-label">Ajoutez une description</label>
                                <textarea type="text" class="form-control @error('jt_description') is-invalid @enderror" id="jt_description" name="jt_description" value="{{old('jt_description')}}" required>
                                @error('jt_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                </textarea>
                            </div>

                            <div class="mb-3 text-start">
                                <label for="rapport" class="form-label">Ajoutez un rapport</label>
                                <input type="file" class="form-control @error('rapport') is-invalid @enderror" id="email" name="rapport" value="" required>
                                @error('rapport')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('message.save') }}
                            </button>

                        </div>
                    </div>
                </div>
            </form>
@endsection --}}

@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <form action="{{ route('stagiaire.ajout_jt') }}" method="POST" enctype="multipart/form-data" class="border rounded-3 shadow-lg overflow-hidden">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="modal-header bg-primary text-white p-4">
                    <div class="d-flex align-items-center">
                        <i class="feather-icon me-2" data-feather="file-text" style="width: 24px; height: 24px;"></i>
                        <h3 class="modal-title fw-bold mb-0">Ajouter une activité</h3>
                    </div>
                    <i class="feather-icon" data-feather="alert-circle" style="width: 24px; height: 24px;"></i>
                </div>

                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Journée Technique</h2>
                        <p class="text-muted">Veuillez renseigner les informations concernant votre JT</p>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label for="jt_name" class="form-label fw-bold">Nom de la JT</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-heading text-primary"></i>
                            </span>
                            <select name="jt_name" class="form-select @error('jt_name') is-invalid @enderror" id="jt_name" required>
                                <option value="JT1" {{old('jt_name')=='JT1'?'selected':''}}>
                                    Journée Technique 1
                                </option>
                                <option value="JT2" {{old('jt_name')=='JT2'?'selected':''}}>
                                    Journée Technique 2
                                </option>
                                <option value="JT3" {{old('jt_name')=='JT3'?'selected':''}}>
                                    Journée Technique 3
                                </option>
                            </select>
                            @error('jt_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror  
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="jt_date" class="form-label fw-bold">Date de la JT</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="far fa-calendar-alt text-primary"></i>
                            </span>
                            <input type="date" class="form-control @error('jt_date') is-invalid @enderror" id="jt_date" name="jt_date" value="{{ old('jt_date') }}" max="{{date('Y-m-d')}}" required>
                            @error('jt_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="jt_location" class="form-label fw-bold">Lieu de tenue de la Journée technique</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </span>
                            <input type="text" class="form-control @error('jt_location') is-invalid @enderror" id="jt_location" name="jt_location" value="{{ old('jt_location') }}" required>
                            @error('jt_location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Année de mission
                    <div class="mb-4 bg-white p-3 rounded shadow-sm">
                        <label for="year" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>Semestre de la JT
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-lock text-primary"></i>
                            </span>
                            <select name="year" class="form-select form-select-lg @error('year') is-invalid @enderror" id="">
                                <option value="">Selectionnez un semestre</option>
                                <option value="first">Première semestre {{ $year['first']['begin'].' '.$year['first']['end'] }}</option>
                                <option value="second">Deuxième semestre {{ $year['second']['begin'].' '.$year['second']['end'] }}</option>     
                            </select>
                            <span id='default' class="input-group-text bg-warning text-dark fw-bold">
                                Délai: Sélectionnez
                            </span>
                            <span id='first' style="display:none;" class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $year['first']['limite'] }}
                            </span>
                            <span id='second' style="display:none;" class="input-group-text bg-warning text-dark fw-bold">
                                Délai: {{ $year['second']['limite'] }}
                            </span>
                        </div>
                        
                        @error('year')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div> 
                    -->
                    <div class="mb-4">
                    
                        <label for="affiliation_order" class="form-label fw-bold">Ordre d'Affiliation</label>

                        <select name="affiliation_order" class="form-select @error('affiliation_order') is-invalid @enderror" id="affiliation_order">
                            @foreach($affiliation_orders as $affiliation_order)
                                <option value="{{$affiliation_order->id}}">
                                    {{$affiliation_order->name}}
                                </option>
                            @endforeach
                        </select>
                        @error('affiliation_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="jt_description" class="form-label fw-bold">Commentaire</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light align-items-start pt-2">
                                <i class="fas fa-align-left text-primary"></i>
                            </span>
                            <textarea class="form-control @error('jt_description') is-invalid @enderror" id="jt_description" name="jt_description" rows="4" placeholder="Décrivez le contenu de la JT..." required>{{old('jt_description')}}</textarea>
                            @error('jt_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="rapport" class="form-label fw-bold">Rapport (PDF) (facultatif)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-file-pdf text-primary"></i>
                            </span>
                            <input type="file" class="form-control @error('rapport') is-invalid @enderror" id="rapport" name="rapport" accept=".pdf">
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
    const semestreSelect = document.querySelector('select[name="year"]');
    const deadlineSpans = {
        default: document.getElementById('default'),
        first: document.getElementById('first'),
        second: document.getElementById('second'),
    };

    // Fonction pour gérer le changement de sélection
    function updateDeadlineDisplay() {
        // Masquer tous les spans de délai
        Object.values(deadlineSpans).forEach(span => {
            span.style.display = 'none';
        });

        // Afficher le span correspondant ou le span par défaut
        const selectedValue = semestreSelect.value;
        if (selectedValue && deadlineSpans[selectedValue]) {
            deadlineSpans[selectedValue].style.display = 'inline-block';
        } else {
            deadlineSpans.default.style.display = 'inline-block';
        }
    }

    // Écouteur d'événement pour le changement de sélection
    semestreSelect.addEventListener('change', updateDeadlineDisplay);

    // Initialisation au chargement de la page
    updateDeadlineDisplay();
});
</script>
@endsection