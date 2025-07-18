@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Synthèse des Activités</h2>
    {{-- <p class="text-muted mb-4">Période du {{ $startDate }} au {{ $endDate }}</p> --}}

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th style="width: 50%">Activités</th>
                    <th class="text-center">Nbre de dossiers</th>
                    <th class="text-center">Nbre d'heures</th>
                </tr>
            </thead>
          
            <tbody>
                @foreach($categories as $category)
                <tr class="table-primary">
                    <td colspan="3"><strong>{{ $loop->iteration }}. {{ $category->categorie_name }}</strong></td>
                </tr>
                
                @php
                    $categoryDossiers = 0;
                    $categoryHeures = 0;
                @endphp
                {{-- @dd($category->subCategories); --}}
                <!-- Loop through subcategories -->
                @foreach($category->subCategories as $subCategory)
                    @php
                        $missions = $missions->where('subcategory_id', $subCategory->id);
                        $dossierCount = $missions->count();
                        $hoursTotal = $missions->sum('hours');
                        $categoryDossiers += $dossierCount;
                        $categoryHeures += $hoursTotal;
                    @endphp
                    @dd($category->subCategories )
                    <tr>
                        <td class="pl-4">{{ $subCategory->subcategorie_name}}</td>
                        <td class="text-center">{{ $dossierCount }}</td>
                        <td class="text-center">{{ $hoursTotal }}</td>
                    </tr>
                @endforeach
                
                <tr class="table-active">
                    <td class="text-end"><strong>Total ({{ romanNumerals($loop->iteration) }})</strong></td>
                    <td class="text-center"><strong>{{ $categoryDossiers }}</strong></td>
                    <td class="text-center"><strong>{{ $categoryHeures }}</strong></td>
                </tr>
                @endforeach

                <!-- Total Général -->
                <tr class="table-dark">
                    <td class="text-end"><strong>TOTAL GENERAL</strong></td>
                    <td class="text-center"><strong>{{ $totalDossiers }}</strong></td>
                    <td class="text-center"><strong>{{ $totalHeures }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@php
function romanNumerals($number) {
    $map = ['I', 'II', 'III', 'IV', 'V'];
    return $map[$number-1] ?? $number;
}
@endphp