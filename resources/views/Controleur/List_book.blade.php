{{-- @extends('welcome')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                <!-- En-tête avec fond coloré -->
                <div class="card-header bg-gradient-primary text-white py-4">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-book-open fa-3x me-4"></i>
                        <div>
                            <h2 class="mb-1 text-center">Liste des livres</h2>
                            <p class="mb-0 text-center opacity-75">Gestion des livres disponibles</p>
                        </div>
                    </div>
                </div>
                
                <!-- Corps du tableau -->
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($books->isEmpty())
                        <p class="text-center py-4">Aucun livre disponible pour le moment.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Titre</th>
                                        <th>Sous-titre</th>
                                        <th>Catégorie</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($books as $book)
                                        <tr>
                                            <td class="fw-bold">{{ $book->title }}</td>
                                            <td class="text-muted">{{ $book->subtitle ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $book->category }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ asset('storage/'.$book->file_path) }}" 
                                                       class="btn btn-sm btn-primary"
                                                       title="Télécharger">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <form action="" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')"
                                                                title="Supprimer">
                                                            <i class="align-middle" datat-feather="trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


@extends('welcome')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="bi bi-book me-2"></i>Liste des Livres
                </h2>
                <a href="{{route('add_book')}}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Ajouter un livre
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Titre</th>
                                    <th>Sous-titre</th>
                                    <th>Catégories</th>
                                    <th>Fichier</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($books as $book)
                                <tr>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->subtitle ?? '-' }}</td>
                                    <td>
                                        @foreach($book->categories as $category)
                                            <span class="badge bg-primary me-1">{{ $category->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ $book->file_url }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-file-earmark-pdf"></i> Voir
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="{{route('books.delete', $book->id)}}" method="POST">
                                                @csrf
                                                <input type="text" name="book_id" value="{{$book->id}}" hidden>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Aucun livre trouvé</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


<style>
    .badge {
        font-size: 0.85em;
        font-weight: normal;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
</style>
