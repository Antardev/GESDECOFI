
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Liste des Stagiaires</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 7px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header .subtitle {
            color: #7f8c8d;
            font-size: 14px;
        }
        .logo {
            height: 80px;
            margin-bottom: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th {
            background-color: #3498db;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        .table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .status-valid {
            color: #27ae60;
            font-weight: bold;
        }
        .status-invalid {
            color: #e74c3c;
            font-weight: bold;
        }
        .date {
            text-align: right;
            margin-bottom: 20px;
            font-size: 11px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="header">
    
        <div class="header">
            <div class="company-name">GestionDecofi</div>
            <h1>
                Liste des Stagiaires {{!empty($country)? 'du '.$country.' ':''}} 
                @if(!empty($toSend['year']))
                    Année : {{$toSend['year']}}
                @endif
            </h1> 
            
        </div>

    <div class="date">
        Généré le: {{ now()->format('d/m/Y à H:i') }}
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Numéro Cnss</th>
                <th>Début de stage</th>
                <th>Entité de stage</th>
                <th>Maître de stage</th>
                <th>Date de naissance</th>
                <th>Pays</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stagiaires as $s)
            <tr>
                <td>{{ $s->matricule }}</td>
                <td>{{ $s->firstname }}</td>
                <td>{{ $s->name }}</td>
                <td>{{ $s->email }}</td>
                <td>{{ $s->phone }}</td>
                <td>{{ $s->numero_cnss }}</td>
                <td>{{ $s->stage_begin }}</td>
                <td>{{ $s->nom_cabinet }}</td>
                <td>{{ $s->nom_maitre.' '.$s->prenom_maitre }}</td>
                <td>{{ \Carbon\Carbon::parse($s->birthdate)->format('d/m/Y') }}</td>
                <td>{{ $s->country }}</td>
                <td class="status-{{ $s->validated ? 'valid' : 'invalid' }}">
                    {{ $s->validated ? 'Validé' : 'Non validé' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} GestionDECOFI. Tous droits réservés.
    </div>
</body>
</html>