@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-layers me-2"></i>Ajouter un sous-domaine
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('save_sous_domaine') }}">
                        {{-- Use the route helper to generate the action URL --}}
                        @csrf

                        <!-- Sélection du domaine parent -->
                        <div class="mb-3">
                            <label for="domain" class="form-label">Domaine parent</label>
                            <select class="form-select @error('domain') is-invalid @enderror" 
                                    id="domain" name="domain" required>
                                <option value="">Sélectionnez un domaine</option>
                                @foreach($domains as $domain)
                                    <option value="{{ $domain->id }}" 
                                        {{ old('domain') == $domain->id ? 'selected' : '' }}>
                                        {{ $domain->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('domain')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Nom du sous-domaine -->
                        <div class="mb-3">
                            <label for="nom_sous_domaine" class="form-label">Nom du sous-domaine</label>
                            <input type="text" class="form-control @error('nom_sous_domaine') is-invalid @enderror" 
                                   id="nom_sous_domaine" name="nom_sous_domaine" 
                                   value="{{ old('nom_sous_domaine') }}" 
                                   placeholder="" required>
                            
                            @error('nom_sous_domaine')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Description optionnelle -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optionnel)</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Retour
                            </a>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection