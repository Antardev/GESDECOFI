@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Tableau 2 : Récapitulatif du Volume Horaire Effectué Durant le Stage</h2>

    <!-- Formulaire de sélection 
        <form method="GET" action="" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="year" class="form-label">Choisir l'année</label>
                    <select name="y" id="year" class="form-select">
                    <option value="">-- Sélectionnez une année --</option>
                        <option value="1" {{ request('y') == 1 ? 'selected' : '' }}>Année 1</option>
                        <option value="2" {{ request('y') == 2 ? 'selected' : '' }}>Année 2</option>
                        <option value="3" {{ request('y') == 3 ? 'selected' : '' }}>Année 3</option>

                    </select>
                </div>
                <div class="col-md-4">
                    <label for="semester" class="form-label">Choisir le semestre</label>
                    <select name="s" id="semester" class="form-select">
                        <option value="">-- Sélectionnez un semestre --</option>
                    <option value="1" {{ request('s') == 1 ? 'selected' : '' }}>Semestre 1</option>
                    <option value="2" {{ request('s') == 2 ? 'selected' : '' }}>Semestre 2</option>
                    </select>
                </div>
                <div class="col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                </div>
            </div>
        </form> 
    -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th style="background-color: #007bff; color: white;">ACTIVITES</th>
                    <th style="background-color: #28a745; color: white;" class="text-center">1er</th>
                    <th style="background-color: #ffc107; color: white;" class="text-center">2ème</th>
                    <th style="background-color: #17a2b8; color: white;" class="text-center">3ème</th>
                    <th style="background-color: #dc3545; color: white;" class="text-center">4ème</th>
                    <th style="background-color: #6f42c1; color: white;" class="text-center">5ème</th>
                    <th style="background-color: #fd7e14; color: white;" class="text-center">6ème</th>
                    <th style="background-color: #343a40; color: white;" class="text-center">TOTAL PAR ACTIVITE</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hours1 = 0;

                    $hours2[1] = 0;
                    $hours2[2] = 0;
                    $hours2[3] = 0;
                    $hours2[4] = 0;
                    $hours2[5] = 0;
                    $hours2[6] = 0;

                @endphp

                @foreach($semesters as $semester)
                <tr>
                @php
                    $hours = 0;

                @endphp

                    <td style="background-color: #f8f9fa;"><strong>{{$semester[1]['category']}}</strong></td>
                    @foreach($semester as $i => $semester1)

                        <td class="text-center">{{$semester1['hour']}}</td>
                        @php
                            $hours+=$semester1['hour'];
                            $hours2[$i]+=$semester1['hour'];
                        @endphp
                    @endforeach
                    <td class="text-center" style="background-color: #f8f9fa;"><strong>{{$hours}}</strong></td>
                </tr>
                @php
                    $hours1+=$hours;

                @endphp
                @endforeach
                </tr>
                <tr class="table-warning">
                    <td class="text-end" style="font-weight: bold;">TOTAL PAR SEMESTRE</td>
                    @foreach($semester as $i => $semester1)

                        <td class="text-center">{{$hours2[$i]}}</td>

                    @endforeach
                    <td class="text-center" style="font-weight: bold;">{{$hours1}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection