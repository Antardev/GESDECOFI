@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Synthèse des Formations</h2>

    <!-- Formulaire de sélection -->
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

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th style="background-color: #007bff; color: white;">Secteur d’activité</th>
                    <th style="background-color: #28a745; color: white;">Termes des formations (Module)</th>
                    <th class="text-center" style="background-color: #dc3545; color: white;">Nbre d'heures</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-info">
                    <td colspan="2"><strong>Professionnelle (DECOFI)</strong></td>
                    <td class="text-center"></td>
                </tr>

                @php
                    $totalHours = 0;
                @endphp

                @foreach($jts as $jt)
                    @php
                        preg_match('/JT(\d+)/', $jt->jt_name, $matches);
                        $sectionNumber = isset($matches[1]) ? $matches[1] : 'Inconnue';
                    @endphp

                    <tr class="table-light">
                        <td>Section {{ $sectionNumber }} Année : {{$jt->jt_year}}</td>
                        <td>
                            <ul>
                                @php
                                    $hours = 0;
                                @endphp
                                @foreach($jt->modules as $module)
                                    @php
                                        $hours += $module->nb_hour;
                                    @endphp
                                    <li>Module : {{$module->name}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center">{{$hours}} H</td>
                    </tr>

                    @php
                        $totalHours += $hours;
                    @endphp
                @endforeach

                {{-- Total --}}
                <tr class="table-warning">
                    <td class="text-end"><strong>TOTAL</strong></td>
                    <td class="text-center"></td>
                    <td class="text-center"><strong>{{ $totalHours }} H</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection