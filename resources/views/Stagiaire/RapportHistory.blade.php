@extends('welcome')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border rounded-3 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Historique des Soumissions de Rapports</h3>
                </div>
                <div class="card-body">
                    @if($rapports->isEmpty())
                        <div class="alert alert-info text-center">
                            <strong>Aucune soumission trouvée.</strong> Vous n'avez pas encore soumis de rapport.
                        </div>
                    @else
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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Nom du Rapport</th>
                                    <th scope="col">Date de Soumission</th>
                                    <th scope="col">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rapports as $rapport)
                                    <tr>
                                        <td>{{ $se[$rapport->rapport_name] }}</td>
                                        <td>{{ $rapport->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($rapport->is_delayed)
                                                <span class="badge bg-danger">Retard</span>
                                            @else
                                                <span class="badge bg-success">À jour</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge {
        font-size: 0.9rem;
    }
</style>
@endsection