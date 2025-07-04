@extends('welcome')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Liste des Missions</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nom de la mission </th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Catégories</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($missions as $mission)
                        <tr>
                            <td>{{ $mission->mission_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($mission->mission_begin_date)->format('d/m/Y') }}</td>

                            <td>{{ \Carbon\Carbon::parse($mission->mission_end_date)->format('d/m/Y') }}</td>
                            <td>
                                {{ $mission->categorie_name}} 
                              {{-- @foreach($mission->categories as $category)
                                    {{ $category->name }}@if(!$loop->last), @endif
                                @endforeach --}}
                            <td>
                                <button class="btn btn-secondary" data-id="{{ $mission->id }}"> voir</button>
                         
                            </td>
                        </tr>
                       
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucune mission trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-secondary');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const missionId = this.getAttribute('data-id');
                window.location.href = `/stagiaire/mission_details/${missionId}`;
            });
        });
    });
    const buttons = document.querySelectorAll('.btn-secondary');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const missionId = this.getAttribute('data-id');
            window.location.href = `/stagiaire/mission_details/${missionId}`;
        });
    });

    
</script>