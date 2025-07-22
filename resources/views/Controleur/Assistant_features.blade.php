@extends('welcome')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-user-tie align-middle"></i>
                        Détails de l'assistant
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Colonne gauche - Avatar et infos personnelles -->
                        <div class="col-md-4">
                            <div class="position-relative mx-auto" style="width: 100px; height: 100px;">
                                @if($assistant->picture_path)
                                    <img src="{{ asset('storage/' . $assistant->picture_path) }}" 
                                         class="rounded-circle w-100 h-100 object-fit-cover border border-3 border-white shadow-sm"
                                         alt="Photo de {{ $assistant->firstname }} {{ $assistant->lastname }}">
                                @else
                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center w-100 h-100 fs-2 fw-bold shadow-sm">
                                        {{ substr($assistant->firstname, 0, 1) }}{{ substr($assistant->lastname, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <h4 class="mt-3 text-center">{{ $assistant->firstname }} {{ $assistant->lastname }}</h4>
                            <p class="text-muted mb-2 text-center">Email: {{ $assistant->email }}</p>
                            
                            <!-- Informations personnelles -->
                            <div class="mt-4">
                                <h6 class="border-bottom pb-2">Informations personnelles</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-phone-alt text-primary me-2"></i> 
                                        Téléphone: {{ $assistant->phone ?? 'Non renseigné' }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        Date de naissance: {{$assistant->birth_date?Carbon\Carbon::parse($assistant->birth_date)->format('d/m/Y'):'Non renseigné' }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        Localisation: {{ $assistant->city ?$assistant->country.' '.$assistant->city : 'Non spécifié' }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Colonne droite - Attribution des rôles -->
                        <div class="col-md-8">
                            <h6 class="border-bottom pb-2">
                                <i class="fas fa-user-shield me-2"></i>Attribution des rôles
                            </h6>
                            <form method="POST" action="{{ route('controller.assign_roles') }}">
                                @csrf

                                <input type="hidden" name="assistant_id" value="{{ $assistant->id }}">

                                <div class="mb-3">
                                    <label class="form-label">Sélectionnez les rôles:</label>
                                    <div>
                                        @foreach($roles as $role)
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                    type="checkbox" 
                                                    name="roles[]" 
                                                    value="{{ $role->id }}" 
                                                    id="role_{{ $role->id }}"
                                                    {{ $role->checked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="role_{{ $role->id }}">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check-circle me-1"></i> Attribuer des rôles
                                </button>
                            </form>
                            @if($assistant->activated)
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-check-circle me-1"></i> Désactiver le compte
                                </button>
                            @elseif(!$assistant->activated)
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-check-circle me-1"></i> Activer le compte
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace();
    });
</script>