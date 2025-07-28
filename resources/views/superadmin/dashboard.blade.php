@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tableau de bord - Stagiaires</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title text-white">Total Stagiaires</h5>
                    <p class="card-text fs-4">{{ $total }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title text-white">Validés</h5>
                    <p class="card-text fs-4">{{ $valides }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title text-white">Non-validés</h5>
                    <p class="card-text fs-4">{{ $non_valides }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <canvas id="stagiairesParPaysChart" height="100"></canvas>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('CR.stagiaires.export.excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i> Exporter Excel
        </a>
        <a href="{{ route('CR.stagiaires.export.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Exporter PDF
        </a>
    </div>
</div>
@endsection

@section('scripts_down')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('stagiairesParPaysChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($parPays->keys()) !!},
            datasets: [{
                label: 'Nombre de stagiaires par pays',
                data: {!! json_encode($parPays->values()) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endsection
