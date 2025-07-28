@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>Ajouter une nouvelle catégorie
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{route('save_categorie')}}">
                        
                        @csrf
                        
                        <div class="mb-3">
                            <label for="categorie_name" class="form-label">Nom de la categorie </label>
                            <input type="text" class="form-control @error('categorie_name') is-invalid @enderror" 
                                   id="categorie_name" name="categorie_name" 
                                   value="{{ old('categorie_name') }}" 
                                   placeholder="" required>
                            
                            @error('categorie_name')
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