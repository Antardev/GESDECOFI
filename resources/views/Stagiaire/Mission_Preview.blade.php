@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 text-center">Vérifiez les Détails de la Mission</h3>
                </div>
                
                @php

            foreach($cat1 as $ca)
            {
                $cat[$ca->id] = $ca->name;
            }

            foreach($subcat1 as $subc)
            {
                $subcat[$subc->id] = ['categorie_id' => $subc->categorie_id, 'categorie_name' => $subc->categorie_name, 'subcategorie_name' => $subc->subcategorie_name];
            }


            @endphp
                <div class="card-body">
                    <!-- Display Mission Details -->
                    <div class=" lg-4 mb-4">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-info-circle me-2"></i>Informations Générales
                        </h4>
                        
                        <p class="fw-bold mb-1">Nom de la mission</p>
                        <p class="text-muted">{{ $mission_name }}</p>

                        <p class="fw-bold mb-1">Date de début</p>
                        <p class="text-muted">{{ $mission_begin_date }}</p>

                        <p class="fw-bold mb-1">Date de fin</p>
                        <p class="text-muted">{{ $mission_end_date }}</p>

                        <p class="fw-bold mb-1">Catégorie</p>
                        <p class="text-muted">{{ $cat[$categorie_mission] }}</p>

                        <p class="fw-bold mb-1">Description</p>
                        <p class="text-muted">{{ $mission_description }}</p>

                        <!-- Add more fields as necessary -->
                    </div>
                    <div class="lg-4">
                                                
                        @if($sous_categories)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Sous-catégorie</th>
                                        <th width="120" class="text-end">Heures</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @php
                                            $nb_hours=0;
                                        @endphp
                                    @foreach($sous_categories as $index => $subcategory)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $subcat[$subcategory['ref']]['subcategorie_name'] }}</td>
                                        <td class="text-end">{{ $subcategory['heures'] }} h</td>
                                        @php
                                            $nb_hours+=$subcategory['heures'];
                                        @endphp
                                    </tr>
                                    @endforeach
                                    <tr class="table-active">
                                        <td colspan="2" class="fw-bold">Total</td>
                                        <td class="text-end fw-bold">{{$nb_hours}} h</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="card-footer bg-light">
                    <form action="{{ route('stagiaire.ajout_mission') }}" method="POST">
                        @csrf
                        <input type="hidden" name="mission_name" value="{{ $mission_name }}">
                        <input type="hidden" name="mission_begin_date" value="{{ $mission_begin_date }}">
                        <input type="hidden" name="mission_end_date" value="{{ $mission_end_date }}">
                        <input type="hidden" name="categorie_mission" value="{{ $categorie_mission }}">
                        <input type="hidden" name="mission_description" value="{{ $mission_description }}">
                        
                        @if(!empty($rapport_path))
                        <input type="hidden" name="rapport" value="{{ !empty($rapport_path)?$rapport_path:'' }}">
                        @endif

                        <input type="hidden" name="semester" value="{{ $semester }}">
                        @foreach ($sous_categories as $index => $sous_categorie)
                            <input type="hidden" name="sous_categories[{{ $index }}][ref]" value="{{ $sous_categorie['ref'] }}">
                            <input type="hidden" name="sous_categories[{{ $index }}][nom]" value="{{ $sous_categorie['nom'] }}">
                            <input type="hidden" name="sous_categories[{{ $index }}][heures]" value="{{ $sous_categorie['heures'] }}">
                        @endforeach
                        
                        @if(!empty($rapport_path))
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pdfModal">
                            <i class="fas fa-file-pdf me-1"></i> Consulter le rapport
                        </button>
                        @endif
                        <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>  Modifier
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check me-1"></i> Confirmer et Soumettre
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal pour afficher le PDF -->
       @if(!empty($rapport_path))
        <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="pdfModalLabel">Rapport de mission: {{ $mission_name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="ratio ratio-16x9">
                            <iframe 
                                src="{{ asset('storage/' .(!empty($rapport_path)?$rapport_path:'')) }}#toolbar=0&view=FitH" 
                                style="width: 100%; height: 100%; border: none;"
                                allowfullscreen
                            ></iframe>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ asset('storage/' .(!empty($rapport_path)?$rapport_path:'')) }}" 
                        class="btn btn-success" 
                        download="Rapport_{{ $mission_name }}.pdf">
                            <i class="fas fa-download me-1"></i> Télécharger
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

 