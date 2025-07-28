@extends('welcome')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Liste des Missions</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{route('SearchMission')}}" style="display: flex">

                <input type="text" placeholder="Rechercher" class="form-control no-border-input" name="search" id="searchInput">
                <button class="btn btn-primary" type="submit"> Rechercher</button>
            </form>
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
                                {{ $mission->categorie->categorie_name}} 
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
            <div class="d-flex justify-content-center mt-4">
                {{ $missions->links() }}
            </div>
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