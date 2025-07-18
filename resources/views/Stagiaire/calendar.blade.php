
@extends('welcome')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">📅 Mon Calendrier annuel</h2>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            @if($stagiaire->picture_path)
                                <img src="{{ asset('storage/'.$stagiaire->picture_path) }}" 
                                     class="rounded-circle me-3" 
                                     width="60" height="60" 
                                     style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-user-graduate text-primary"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0">{{ $stagiaire->name }} {{ $stagiaire->firstname }}</h4>
                            <small>Matricule: {{ $stagiaire->matricule }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($stagiaire->stage_begin)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Date de début de stage: 
                        <strong>{{ \Carbon\Carbon::parse($stagiaire->stage_begin)->isoFormat('LL') }}</strong>
                    </div>

                    <div class="mb-4">
                        <div id="calendar" class="fc-calendar"></div>
                    </div>

                    <div class="mt-5">
                        <h5 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-calendar-week me-2"></i>
                            Détail des semestres
                        </h5>
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="15%">Période</th>
                                        <th width="25%">Début</th>
                                        <th width="25%">Fin</th>
                                        <th width="15%">Durée</th>
                                        <th width="40%">Échéance de depot rapport</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stagiaire->semesters as $semester)
                                    <tr>
                                        <td>
                                            <span class="badge rounded-pill {{ $semester['number'] % 2 == 0 ? 'bg-primary' : 'bg-warning text-dark' }}">
                                                Semestre {{ $semester['number'] }}
                                            </span>
                                        </td>
                                        <td>{{ $semester['start']->isoFormat('LL') }}</td>
                                        <td>{{ $semester['end']->isoFormat('LL') }}</td>
                                        <td>6 mois</td>
                                        <td class="{{ now() > $semester['end'] ? 'text-danger' : 'text-success' }}">
                                            {{ $semester['end']->addDays(46)->isoFormat('LL') }}
                                            @if(now() > $semester['end'])
                                            <i class="" data-feather="exclamation-circle"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-1">Aucune date de début définie</h5>
                                <p class="mb-0">Votre calendrier de formation sera disponible une fois votre date de début de stage enregistrée.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .fc-calendar {
        height: 500px;
        border-radius: 0.5rem;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    }
    .fc-header-toolbar {
        padding: 1rem;
        margin: 0;
        background-color: #f8fafc;
        border-radius: 0.5rem 0.5rem 0 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    .fc-toolbar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
    }
    .fc-daygrid-day-number {
        color: #4a5568;
        font-weight: 500;
    }
    .fc-event {
        cursor: pointer;
        font-size: 0.85rem;
        border-radius: 0.25rem;
        padding: 0.15rem 0.3rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .fc-event:hover {
        opacity: 0.9;
    }
    .card {
        transition: all 0.3s ease;
        border: none;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.175) !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
    }
</style>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($stagiaire->stage_begin)
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            week: 'Semaine',
            list: 'Liste'
        },
        navLinks: true,
        editable: false,
        dayMaxEvents: true,
        eventDisplay: 'block',
        events: [
            @foreach($stagiaire->semesters as $semester)
            {
                title: 'Semestre {{ $semester["number"] }}',
                start: '{{ $semester["start"]->format("Y-m-d") }}',
                end: '{{ $semester["end"]->addDay()->format("Y-m-d") }}', // +1 jour pour inclure le dernier jour
                color: '{{ $semester["number"] % 2 == 0 ? "#3b82f6" : "#f59e0b" }}',
                extendedProps: {
                    description: 'Semestre {{ $semester["number"] }}\n' +
                                'Du {{ $semester["start"]->isoFormat("LL") }}\n' +
                                'Au {{ $semester["end"]->isoFormat("LL") }}\n' +
                                'Échéance: {{ $semester["end"]->addDays(45)->isoFormat("LL") }}'
                }
            },
            @endforeach
        ],
        eventClick: function(info) {
            alert(info.event.extendedProps.description);
            info.jsEvent.preventDefault();
        },
        eventDidMount: function(info) {
            // Ajout d'une icône aux événements
            const icon = document.createElement('i');
            icon.className = 'fas fa-calendar-day ms-1';
            info.el.querySelector('.fc-event-title').prepend(icon);
        }
    });
    calendar.render();
    @endif
});
</script>
@endsection