@extends('welcome')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Liste des Journées Techniques</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nom </th>
                        <th>Date </th>
                        <th>Ordre </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jts as $jt)
                        <tr>
                            <td>
                                @if (preg_match('/^JT(\d+)$/', $jt->jt_name, $matches))
                                    Section {{ $matches[1] }}
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($jt->jt_date)->format('d/m/Y') }}</td>
                            <td>{{ $jt->affiliation_order }}</td>
                            <td>
                                <a class="btn btn-secondary" href="{{route('jt.show',['id'=>$jt->id])}}"> voir</a>
                            </td>
                        </tr>
                       
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucune JT trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
<script>
    
</script>