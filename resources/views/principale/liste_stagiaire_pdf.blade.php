<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Stagiaires</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* force l'adaptation */
            word-wrap: break-word; /* coupe le texte si trop long */
            font-size: 9px; /* réduire légèrement */
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }
        thead th {
            background-color: #e2efda;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Liste des Stagiaires</h2>
    <table>
        <thead>
            <tr>
                <th colspan="1">N° demande</th>
                <th colspan="8">I- INFORMATIONS DU STAGIAIRE</th>
                <th colspan="11">II- INFORMATIONS SUR LE STAGE</th>
                <th colspan="1">ACTION</th>
            </tr>
            <tr>
                <th rowspan="2">N°</th>
                <th rowspan="2">N° matricule</th>
                <th rowspan="2">Nom & prénom(s)</th>
                <th rowspan="2">Date de naissance</th>
                <th rowspan="2">Lieu de naissance</th>
                <th rowspan="2">Nationalité</th>
                <th rowspan="2">Adresse</th>
                <th rowspan="2">Téléphone</th>
                <th rowspan="2">Email</th>
                <th rowspan="2">Date début</th>
                <th rowspan="2">Date fin</th>
                <th rowspan="2">Contrôleur de stage</th>
                <th colspan="4">Maître de stage</th>
                <th colspan="4">Structure d'accueil</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                <th>Nom & prénom</th>
                <th>Ordre affiliation</th>
                <th>N° affiliation</th>
                <th>Date affiliation</th>
                <th>Raison sociale</th>
                <th>Ordre affiliation</th>
                <th>N° affiliation</th>
                <th>Date affiliation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stagiaires as $index => $Stagiaire)
                <tr>
                    <td>{{ $Stagiaire->numerodemande ?? '-' }}</td>
                    <td>{{ $Stagiaire->matriculestagiaire ?? '-' }}</td>
                    <td>{{ $Stagiaire->nomstagiaire ?? '-' }}</td>
                    <td>{{ $Stagiaire->datenaissance ? \Carbon\Carbon::parse($Stagiaire->datenaissance)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $Stagiaire->lieunaissance ?? '-' }}</td>
                    <td>{{ $Stagiaire->nationalite ?? '-' }}</td>
                    <td>{{ $Stagiaire->adresse ?? '-' }}</td>
                    <td>{{ $Stagiaire->phonecontact ?? '-' }}</td>
                    <td>{{ $Stagiaire->email ?? '-' }}</td>
                    <td>{{ $Stagiaire->datedebutstage ? \Carbon\Carbon::parse($Stagiaire->datedebutstage)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $Stagiaire->datefinstage ? \Carbon\Carbon::parse($Stagiaire->datefinstage)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $Stagiaire->prenomcontrolleurstage ?? '-' }}</td>
                    <td>{{ $Stagiaire->prenomaitrestage ?? '-' }}</td>
                    <td>{{ $Stagiaire->orderaffimaitstage ?? '-' }}</td>
                    <td>{{ $Stagiaire->numeroaffimaitstage ?? '-' }}</td>
                    <td>{{ $Stagiaire->dateaffimaitstage ? \Carbon\Carbon::parse($Stagiaire->dateaffimaitstage)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $Stagiaire->raisonsociastructure ?? '-' }}</td>
                    <td>{{ $Stagiaire->ordreaffilistructure ?? '-' }}</td>
                    <td>{{ $Stagiaire->numeroaffilistructure ?? '-' }}</td>
                    <td>{{ $Stagiaire->dateaffilistructure ? \Carbon\Carbon::parse($Stagiaire->dateaffilistructure)->format('d/m/Y') : '-' }}</td>
                    <td>Voir</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 