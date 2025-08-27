<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation Demande</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 13px; background-color:#f9f9f9; padding:20px;">
    <center>
        <table width="700" cellpadding="0" cellspacing="0" style="background:#fff; border:1px solid #ddd; padding:20px; border-radius:6px;">
            <tr>
                <td align="center">
                    <h2 style="color:#007bff; text-transform:uppercase; font-size:18px; margin:10px 0;">
                        Confirmation de votre demande d’attestation
                    </h2>
                    <p style="font-size:14px; color:#333;">
                        Bonjour <strong>{{ $stagiaire->prenomstagiaire }} {{ $stagiaire->nomstagiaire }}</strong>,<br>
                        Nous avons bien reçu votre <strong>demande d'attestation de fin de stage</strong>.
                    </p>
                    <p style="font-size:14px; color:#333;">
                        <strong>Numéro de demande :</strong> {{ $stagiaire->numerodemande }}
                    </p>
                    <p style="font-size:14px; color:#555; margin-bottom:20px;">
                        Voici le récapitulatif de votre demande :
                    </p>
                </td>
            </tr>

            {{-- Tableau 1 --}}
            <tr>
                <td>
                    <table width="100%" border="1" cellspacing="0" cellpadding="6" style="border-collapse:collapse; font-size:12px; margin-bottom:15px;">
                        <tr style="background:#f0f0f0;">
                            <td colspan="8" align="center"><strong>I- INFORMATIONS DU STAGIAIRE</strong></td>
                        </tr>
                        <tr style="background:#e9ecef; font-weight:bold;">
                            <td>Matricule</td>
                            <td>Nom & Prénom(s)</td>
                            <td>Date Naissance</td>
                            <td>Lieu Naissance</td>
                            <td>Nationalité</td>
                            <td>Adresse</td>
                            <td>Téléphone</td>
                            <td>Email</td>
                        </tr>
                        <tr>
                            <td>{{ $stagiaire->matriculestagiaire ?? '' }}</td>
                            <td>{{ $stagiaire->nomstagiaire ?? '' }} {{ $stagiaire->prenomstagiaire ?? '' }}</td>
                            <td>{{ $stagiaire->datenaissance ? $stagiaire->datenaissance->format('d/m/Y') : 'Non spécifié' }}</td>
                            <td>{{ $stagiaire->lieunaissance ?? '' }}</td>
                            <td>{{ $stagiaire->nationalite ?? '' }}</td>
                            <td>{{ $stagiaire->adresse ?? '' }}</td>
                            <td>{{ $stagiaire->phonecontact ?? '' }}</td>
                            <td>{{ $stagiaire->email ?? '' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- Tableau 2 --}}
            <tr>
                <td>
                    <table width="100%" border="1" cellspacing="0" cellpadding="6" style="border-collapse:collapse; font-size:12px; margin-bottom:15px;">
                        <tr style="background:#f0f0f0;">
                            <td colspan="8" align="center"><strong>II- INFORMATIONS SUR LE STAGE</strong></td>
                        </tr>
                        <tr style="background:#e9ecef; font-weight:bold;">
                            <td>Date Début</td>
                            <td>Date Fin</td>
                            <td>Contrôleur</td>
                            <td>Maître Stage</td>
                            <td>Ordre</td>
                            <td>Numéro</td>
                            <td>Date</td>
                            <td>Structure</td>
                        </tr>
                        <tr>
                            <td>{{ $stagiaire->datedebutstage ? $stagiaire->datedebutstage->format('d/m/Y') : 'Non spécifié' }}</td>
                            <td>{{ $stagiaire->datefinstage ? $stagiaire->datefinstage->format('d/m/Y') : 'Non spécifié' }}</td>
                            <td>{{ $stagiaire->nomcontrolleurstage ?? '' }} {{ $stagiaire->prenomcontrolleurstage ?? '' }}</td>
                            <td>{{ $stagiaire->nomaitrestage ?? '' }} {{ $stagiaire->prenomaitrestage ?? '' }}</td>
                            <td>{{ $stagiaire->orderaffimaitstage ?? '' }}</td>
                            <td>{{ $stagiaire->numeroaffimaitstage ?? '' }}</td>
                            <td>{{ $stagiaire->dateaffimaitstage ? $stagiaire->dateaffimaitstage->format('d/m/Y') : 'Non spécifié' }}</td>
                            <td>{{ $stagiaire->raisonsociastructure ?? '' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- Tableau 3 --}}
            <tr>
                <td>
                    <table width="100%" border="1" cellspacing="0" cellpadding="6" style="border-collapse:collapse; font-size:12px;">
                        <tr style="background:#f0f0f0;">
                            <td colspan="27" align="center"><strong>III- OBLIGATIONS DE STAGE</strong></td>
                        </tr>
                        <tr style="background:#e9ecef; font-weight:bold; text-align:center;">
                            <td colspan="3">Conditions d'entrée</td>
                            <td colspan="6">Rapports de stage</td>
                            <td colspan="18">Journées techniques</td>
                        </tr>
                        <tr style="font-size:10px; text-align:center;">
                            <td>Acceptation Ordre</td>
                            <td>Convention Stage</td>
                            <td>Convention CNSS</td>
                            <td>Sem 1 an 1</td>
                            <td>Sem 2 an 1</td>
                            <td>Sem 1 an 2</td>
                            <td>Sem 2 an 2</td>
                            <td>Sem 1 an 3</td>
                            <td>Sem 2 an 3</td>
                            <td colspan="2">Ses 1 an 1</td>
                            <td colspan="2">Ses 2 an 1</td>
                            <td colspan="2">Ses 3 an 1</td>
                            <td colspan="2">Ses 1 an 2</td>
                            <td colspan="2">Ses 2 an 2</td>
                            <td colspan="2">Ses 3 an 2</td>
                            <td colspan="2">Ses 1 an 3</td>
                            <td colspan="2">Ses 2 an 3</td>
                            <td colspan="2">Ses 3 an 3</td>
                        </tr>
                        <tr style="text-align:center;">

                            @php
                            $tabl = [
                                0 => ['a1_s1', 'a1_s2', 'a2_s1', 'a2_s2', 'a3_s1', 'a3_s2'],
                                1 => ['a1_s1', 'a1_s2', 'a1_s3', 'a2_s1', 'a2_s2', 'a2_s3', 'a3_s1', 'a3_s2', 'a3_s3']
                            ];
                            @endphp
                            @foreach(['file_decharge','file_convenstage','file_convencnss'] as $cond)
                                <td>
                                    @if (!empty($stagiaire->conditions[$cond]))
                                        <span style="color:green; font-weight:bold;">Fourni </span>
                                    @else
                                        <span style="color:red;">Non fourni</span>
                                    @endif
                                </td>
                            @endforeach
                            @for ($i = 0; $i < count($tabl[0]); $i++)
                                <td>
                                    @if (!empty($stagiaire->rapports[$tabl[0][$i]]))
                                        <span style="color:green; font-weight:bold;">
                                            @php
                                                $v = $tabl[0][$i]; // Utiliser l'index pour accéder à la bonne clé
                                            @endphp
                                            Fourni le : <em>{{ $stagiaire->rapports[$v]['date'] }}</em>
                                        </span>
                                    @else
                                        <span style="color:red;">Non fourni</span>
                                    @endif
                                </td>
                            @endfor

                            @for ($i = 0; $i < count($tabl[1]); $i++)
                                <td>
                                    @if (!empty($stagiaire->journees[$tabl[1][$i]]))
                                        <span style="color:green; font-weight:bold;">
                                            @php
                                                $v = $tabl[1][$i]; // Utiliser l'index pour accéder à la bonne clé
                                            @endphp
                                            Fourni le : <em>{{ $stagiaire->journees[$v]['date'] }}</em>
                                        </span>
                                    @else
                                        <span style="color:red;">Non fourni</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($stagiaire->journees[$tabl[1][$i]]))
                                        <span style="color:green; font-weight:bold;">
                                            @php
                                                $v = $tabl[1][$i]; // Utiliser l'index pour accéder à la bonne clé
                                            @endphp
                                            Lieu : <em>{{ $stagiaire->journees[$v]['lieu'] }}</em>
                                        </span>
                                    @else
                                        <span style="color:red;">Non fourni</span>
                                    @endif
                                </td>
                            @endfor

                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td align="center" style="padding:20px; font-size:13px; color:#555;">
                  Votre Demande a été prise en compte.  Merci pour votre confiance. <br><br>
                    <strong>Le Secrétariat du CNS Bénin</strong>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>