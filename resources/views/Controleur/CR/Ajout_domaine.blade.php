@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>Ajouter un nouveau domaine
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{route('save_domaine')}}">
                        {{-- Use the route helper to generate the action URL --}}
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nom_domaine" class="form-label">Nom du domaine</label>
                            <input type="text" class="form-control @error('nom_domaine') is-invalid @enderror" 
                                   id="nom_domaine" name="nom_domaine" 
                                   value="{{ old('nom_domaine') }}" 
                                   placeholder="" required>
                            
                            @error('nom_domaine')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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