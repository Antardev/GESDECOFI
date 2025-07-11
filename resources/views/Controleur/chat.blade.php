@extends('welcome')
@section('content')
<div class="container">
    @php
    // Données de démonstration (à remplacer par vos vraies données)
    $messages = [
        [
            'expediteur' => 'Admin',
            'sujet' => 'Bienvenue sur la plateforme',
            'contenu' => 'Nous vous confirmons votre inscription...',
            'date' => '2023-05-15 14:30',
            'lu' => false
        ],
        [
            'expediteur' => 'Support',
            'sujet' => 'Votre demande #1234',
            'contenu' => 'Votre ticket a été résolu...',
            'date' => '2023-05-14 09:15',
            'lu' => true
        ],
        // Ajoutez d'autres messages ici...
    ];
@endphp

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-envelope me-2"></i>Boîte de réception
        </h5>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </th>
                        <th>Expéditeur</th>
                        <th>Sujet</th>
                        <th>Contenu</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $index => $message)
                    <tr class="{{ !$message['lu'] ? 'table-primary' : '' }}">
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                    {{ substr($message['expediteur'], 0, 1) }}
                                </div>
                                {{ $message['expediteur'] }}
                            </div>
                        </td>
                        <td class="fw-semibold">{{ $message['sujet'] }}</td>
                        <td>
                            <div class="text-truncate" style="max-width: 250px;">
                                {{ $message['contenu'] }}
                            </div>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($message['date'])->format('d/m/Y H:i') }}
                            </small>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Voir">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <select class="form-select form-select-sm" style="width: 80px;">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Précédent</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Suivant</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
    }
    
    .table-primary {
        --bs-table-bg: rgba(13, 110, 253, 0.05);
    }
    
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script>
    // Activation des tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltips.map(function(tooltip) {
            return new bootstrap.Tooltip(tooltip);
        });
    });
</script>
</div>
@endsection