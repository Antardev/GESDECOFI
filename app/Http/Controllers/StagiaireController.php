<?php

namespace App\Http\Controllers;

use App\Models\AffiliationOrder;
use App\Models\JourneeTechnique;
use App\Models\Mission;
use App\Models\Rapport;
use App\Models\MissionSubcategorie;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Controleurs;
use App\Models\SubCategorie;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\RapportSubmittedNotification;
use Illuminate\Support\Str;

class StagiaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function rapport_history()
    {
        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();

        $rapports = Rapport::where('stagiaire_id', $stagiaire->id)->get();

        return view('Stagiaire.RapportHistory', compact('rapports'));

    }

    public function save_rapport(Request $request)
    {
        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();

        $validator = $request->validate([
            'rapport_name' => ['required','string','in:R1,R2,R3,R4,R5,R6',
            function ($attribute, $value, $fail) use ($request, $stagiaire) {
                $stagiaireId = $stagiaire->id; 

                if (Rapport::where('rapport_name', $value)
                            ->where('stagiaire_id', $stagiaireId)
                            ->exists()) {
                    $fail('Le rapport a déjà été soumis pour ce stagiaire.');
                }
            }
        ],
            'rapport_comment' => 'nullable|string|max:1000',
            'rapport' => 'required|mimes:pdf',

        ], ['' => '']);

        $se = [
            'R1' => 1,
            'R2' => 2,
            'R3' => 3,
            'R4' => 4,
            'R5' => 5,
            'R6' => 6,
        ];

        $today = Carbon::now();

        $rapport = new Rapport();

        $rapport->stagiaire_id = $stagiaire->id;
        $rapport->rapport_name = $request->rapport_name;
        $rapport->rapport_comment = $request->rapport_comment;
        $rapport->semester = $se[$request->rapport_name];
        $rapport->rapport_file = $request->file('rapport')->store('rapports', 'public');

        $dead = 'dead_'.($se[$request->rapport_name]-1).'_semester';
        if ($stagiaire->$dead < $today) {
            $rapport->is_delayed = true;
        }

        $rapport->save();

        // Envoi de la notification au contrôleur
        $this->sendNotificationToController($rapport, $stagiaire);

        return redirect()->route('stagiaire.rapport_history');
    }

    protected function sendNotificationToController($rapport, $stagiaire)
{
    // 1. Trouver le contrôleur national associé
    $controller = Controleurs::where('user_id', auth()->id())->first();
    if(Str::contains( auth()->user()->validated_type, 'controller'));
    $country_contr = "" ;
    $stagiaire = Stagiaire::where('country', $controller->country_contr)->get();
    $country = $controller->country_contr;    
    if ($controller) {
        // 2. Envoyer la notification
        $controller->notify(new RapportSubmittedNotification($rapport, $stagiaire));
    }
}

// protected function getAssociatedController($stagiaire)
// {
//     return User::where('validated_type', 'like', '%CN%')
//               ->where('region_id', $stagiaire->country)
//               ->first();
// }

    public function add_rapport()
    {
        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();

        $year = [
            'first' => ['limite' => $stagiaire->dead_0_semester],
            'second' => ['limite' => $stagiaire->dead_1_semester],
            'third' => ['limite' => $stagiaire->dead_2_semester],
            'fourth' => ['limite' => $stagiaire->dead_3_semester],
            'fifth' => ['limite' => $stagiaire->dead_4_semester],
            'sixth' => ['limite' => $stagiaire->dead_5_semester],
        ];
        return view('Stagiaire.AjoutRapport', ['year' => $year]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (Stagiaire::where('user_id', auth()->id())->exists()) {
            return redirect()->back()->withErrors(['email' => __('message.user_already_registered_as_intern')]);
        }
        $validator = $request->validate([
            'firstname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:stagiaires,email',
            'phone_number' => 'required|string|max:15',
            'birth_date' => 'required|date',
            'country' => 'required|string|in:Benin,Togo,Burkina-Faso,Mali,Senegal,Guinea-Bissau,Ivory-Coast,Niger',
        ]);

        $affiliation_order = AffiliationOrder::where('country', $request->country)->first();

        $stagiaire = new Stagiaire();
        $stagiaire->user_id = auth()->id();
        $stagiaire->firstname = $validator['firstname'];
        $stagiaire->name = $validator['name'];
        $stagiaire->email = $validator['email'];
        $stagiaire->phone = $validator['phone_number'];
        $stagiaire->birthdate = $validator['birth_date'];
        $stagiaire->country = $validator['country'];
        $stagiaire->affiliation_order = $affiliation_order->name;
        $stagiaire->affiliation_order_id = $affiliation_order->id;



        $user1 = User::where('id', $stagiaire->user_id)->first();
        $user1->role = $user1->role.',stagiaire';
        $user1->save();

        $year = Carbon::now()->year;

        $year_r = strrev((string)$year);

        $lastStagiaire = Stagiaire::latest()->first();


        if ($lastStagiaire && $lastStagiaire->matricule) {
            $lastYear = substr($lastStagiaire->matricule, 0, 4);
            if ($lastYear == $year) {
                $lastMatricule = (int)substr($lastStagiaire->matricule, 8);
                $stagiaire->matricule = $year . $year_r . str_pad($lastMatricule + 1, 6, '0', STR_PAD_LEFT);
            } else {
                $stagiaire->matricule = $year . $year_r . '000001';
            }
        } else {
            $stagiaire->matricule = $year . $year_r . '000001';
        }

        
        $stagiaire->save();

        return view('stagiaire.pdf_stagiaire')->with([
            'firstname' => $stagiaire->firstname,
            'name' => $stagiaire->name,
            'email' => $stagiaire->email,
            'phone_number' => $stagiaire->phone,
            'birth_date' => $stagiaire->birthdate,
            'country' => $stagiaire->country,
            'matricule' => $stagiaire->matricule 
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($matricule)
    {
        $stagiaire = Stagiaire::where('matricule', $matricule)->first();

        if (!$stagiaire) {
            return response()->json(['message' => 'Matricule non trouvé.'], 404);
        } else
        if(auth()->id() != $stagiaire->user_id) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }


        return response()->json($stagiaire);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
      
        $validator = $request->validate( [
            'matricule' => 'required|string|min:14|max:14',
            'picture' => 'required|file|max:5048|mimes:png,jpeg,jpg',
            'contrat' => 'required|file|max:5048|mimes:pdf,png,jpeg,jpg',
            'numero_inscription_cabinet' => 'required|string|min:4|max:255',
            'fiche' => 'required|mimes:pdf,doc,docx|max:5120',
            'diplome' => 'required|mimes:pdf,doc,docx|max:5120',
            'date_obtention' => 'required|date',
            'tel_maitre' => 'required|string|min:4|max:15',
            'nom_maitre' => 'required|string|min:4|max:255',
            'prenom_maitre' => 'required|string|min:4|max:255',
            'email_maitre' => 'required|string|min:4|max:255',
            'numero_cnss' => 'required|string|min:4|max:255',
            'numero_inscription_maitre' => 'required|string|min:4|max:255',
            'email_cabinet' => 'required|email|max:255',
            'tel_cabinet' => 'required|string|max:15',
            'debut_stage' => 'required|date',
            'nom_representant' => 'required|string|min:4|max:255',
            'lieu_cabinet' => 'required|string|min:3|max:255',
            'nom_cabinet' => 'required|string|min:4|max:255',
        ]);

        $stagiaire = Stagiaire::where('matricule', $request->matricule)->first();

        if (!$stagiaire) {
            return redirect()->back()->withErrors(['message' => __('message.intern_not_found')]);
        } elseif ($stagiaire->user_id != auth()->id()) {
            return redirect()->back()->withErrors(['message' => __('message.access_denied')]);
        }

        $stagiaire->file_path = $request->file('fiche')->store('fiches', 'public');
        $stagiaire->diplome_path = $request->file('diplome')->store('diplomes', 'public');
        $stagiaire->contrat_path = $request->file('contrat')->store('contrats', 'public');
        $stagiaire->picture_path = $request->file('picture')->store('pictures', 'public');
        $stagiaire->date_obtention = $request->date_obtention;
        $stagiaire->tel_maitre = $request->tel_maitre;
        $stagiaire->nom_maitre = $request->nom_maitre;
        $stagiaire->prenom_maitre = $request->prenom_maitre;
        $stagiaire->email_maitre = $request->email_maitre;
        $stagiaire->numero_inscription_maitre = $request->numero_inscription_maitre;
        $stagiaire->numero_cnss = $request->numero_cnss;
        $stagiaire->email_cabinet = $request->email_cabinet;
        $stagiaire->tel_cabinet = $request->tel_cabinet;
        $stagiaire->nom_representant = $request->nom_representant;
        $stagiaire->lieu_cabinet = $request->lieu_cabinet;
        $stagiaire->stage_begin = $request->debut_stage;
        $stagiaire->nom_cabinet = $request->nom_cabinet;
        $stagiaire->numero_inscription_cabinet = $request->numero_inscription_maitre;
        // $stagiaire->date_entree = $request->date_entree;

        $debutStage = $request->debut_stage; // La date de début du stage

        $firstSemester = null;
        $secondSemester = null;
        $thirdSemester = null;
        
                
        if ($debutStage) {
            $dateDebut = \Carbon\Carbon::parse($debutStage);

            $semesters = [];
            for ($i = 0; $i < 6; $i++) {
                $debut = $i === 0 ? $dateDebut : $semesters[$i - 1]['fin']->copy()->addDay(0);
                $fin = $debut->copy()->addMonths(6);
                $limite = $fin->copy()->addDays(45);

                $semesters[] = compact('debut', 'fin', 'limite');
            }

            $stagiaire->first_year_begin = $dateDebut;
            $stagiaire->first_year_end = $dateDebut->copy()->addMonths(12)->subDay();

            $stagiaire->second_year_begin = $stagiaire->first_year_end->copy()->addDay();
            $stagiaire->second_year_end = $stagiaire->second_year_begin->copy()->addMonths(12)->subDay();

            $stagiaire->third_year_begin = $stagiaire->second_year_end->copy()->addDay();
            $stagiaire->third_year_end = $stagiaire->third_year_begin->copy()->addMonths(12)->subDay();

            foreach ($semesters as $index => $semester) {
                $stagiaire->{"semester_{$index}_begin"} = $semester['debut'];
                $stagiaire->{"semester_{$index}_end"} = $semester['fin'];
                $stagiaire->{"dead_{$index}_semester"} = $semester['limite'];
            }

            $stagiaire->save();
        }

        return redirect()->route('home')->with('success', __('message.intern_updated_successfully'));

    }

   
        

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $stagiaire = Stagiaire::where('matricule', $request->matricule)->first();

        if (!$stagiaire) {
            return redirect()->route('home')->withErrors(['not_found' => __('message.intern_not_found')]);
        } else if ($stagiaire->user_id != auth()->id()) {
            return redirect()->route('home')->withErrors(['access' => __('message.access_denied')]);
        }

        $validator = $request->validate([
            'firstname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:stagiaires,email,' . $stagiaire->id,
            'phone_number' => 'required|string|max:15',
            'birth_date' => 'required|date',
            'country' => 'required|string|in:Benin,Togo,Burkina-Faso,Mali,Senegal,Guinea-Bissau,Ivory-Coast,Niger',
        ]);

        $affiliation_order = AffiliationOrder::where('country', $request->country)->first();

        $stagiaire->firstname = $validator['firstname'];
        $stagiaire->name = $validator['name'];
        $stagiaire->email = $validator['email'];
        $stagiaire->phone = $validator['phone_number'];
        $stagiaire->birthdate = $validator['birth_date'];
        $stagiaire->country = $validator['country'];
        $stagiaire->affiliation_order = $affiliation_order->name;
        $stagiaire->affiliation_order_id = $affiliation_order->id;

        $stagiaire->save();

        return view('stagiaire.pdf_stagiaire')->with(
             [
            'firstname' => $stagiaire->firstname,
            'name' => $stagiaire->name,
            'email' => $stagiaire->email,
            'phone_number' => $stagiaire->phone,
            'birth_date' => $stagiaire->birthdate,
            'country' => $stagiaire->country,
            'matricule' => $stagiaire->matricule,
            'success', __('message.intern_updated_successfully')]);
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stagiaire $stagiaire)
    {
        //
    }


    public function show_add_mission()
    {

        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();
        return view('Stagiaire.Missions', [
            'delai' => Carbon::now()->addDays(30)->format('Y-m-d'),
            'type' => 'jt',
            'year' => ['first'=>['begin' => $stagiaire->semester_0_begin,
                                'end' => $stagiaire->semester_0_end,
                                'limite' => $stagiaire->dead_0_semester],
                        'second'=>['begin' => $stagiaire->semester_1_begin,
                                'end' => $stagiaire->semester_1_end,
                                'limite' => $stagiaire->dead_1_semester],]
                        // 'third'=>['begin' => $stagiaire->third_semester_begin,
                        //         'end' => $stagiaire->third_semester_end,
                        //         'limite' => $stagiaire->dead_third_semester]]
                    
        ]);
    }


    public function create_mission(Request $request)
    {
        $validatedData = $request->validate([
            'mission_name'=>'required|string|min:3|max:255',
            'mission_begin_date'=>'required',
            'enterprise_name'=>'string|min:3|max:255',
            'mission_end_date'=>'required',
            'categorie_mission'=>'required|exists:categories,id',
            'mission_description'=>'required|string|min:5|max:255',
            'year'=>'required|in:first,second',
            'mission_description'=>'required|string|min:5|max:255',
            'rapport'=>'nullable|mimes:pdf,docx',
            'sous_categories.ref' => 'exists:sub_categories,id,categorie_id,' . $request->categorie_mission,
            'sous_categories' => 'required|array',
            'sous_categories.*.heures' => 'nullable|numeric|min:0',
            'sous_categories.*.nom' => 'nullable|string|min:0',
            'sous_categories.*.ref' => 'nullable|numeric|min:0',

        ]);

        $rapport_path = $request->file('rapport') ? $request->file('rapport')->store('rapport_previews', 'public') : null;

        if($rapport_path)
        {
            $validatedData['rapport_path'] = $rapport_path;
        }

        return view('Stagiaire.Mission_Preview', $validatedData);
    }

    public function save_mission(Request $request)
    {
        // dd($request->all());
        // $validatedData = $request->validate([
        //     'mission_name'=>'required|string|min:3|max:255',
        //     'mission_begin_date'=>'required',
        //     'enterprise_name'=>'string|min:3|max:255',
        //     'mission_end_date'=>'required',
        //     'categorie_mission'=>'required|exists:categories,id',
        //     'mission_description'=>'required|string|min:5|max:255',
        //     'year'=>'required|in:first,second',
        //     'mission_description'=>'required|string|min:5|max:255',
        //     'rapport'=>'nullable|mimes:pdf,docx',
        //     'sous_categories.ref' => 'exists:sous_categories,id,categorie_id,' . $request->categorie_mission,
        //     'sous_categories' => 'required|array',
        //     'sous_categories.*.heures' => 'nullable|numeric|min:0'
        // ]);

        $validator = Validator::make($request->all(), [
            'mission_name' => 'required|string|min:3|max:255',
            'mission_begin_date' => 'required|date',
            'enterprise_name' => 'nullable|string|min:3|max:255',
            'mission_end_date' => 'required|date|after_or_equal:mission_begin_date',
            'categorie_mission' => 'required|exists:categories,id',
            'mission_description' => 'required|string|min:5|max:255',
            'year' => 'required|in:first,second',
            'rapport' => 'nullable|string',
            'sous_categories' => 'required|array',
            'sous_categories.*.ref' => 'exists:sub_categories,id,categorie_id,' . $request->categorie_mission,
            'sous_categories.*.heures' => 'nullable|numeric|min:0'
        ]);


        // Vérifier si la validation échoue
        if ($validator->fails()) {
            return redirect()->route('Ajout_mission')
                            ->withErrors($validator)
                            ->withInput();
        }
        // dd($request->rapport);
        if($request->rapport)
        {

            if (!Storage::disk('public')->exists($request->rapport)) {
                return redirect()->route('Ajout_mission')->withErrors(['rapport' => 'Le fichier doit exister.'])->withInput();
            }
            $r = true;
        }

        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();

        $today = Carbon::now();

        // $deadFirstSemester = $stagiaire->dead_first_semester;
        // $deadSecondSemester = $stagiaire->dead_second_semester;
        // $deadThirdSemester = $stagiaire->dead_third_semester;

        // $errors = [];

        // if ($deadFirstSemester && Carbon::parse($deadFirstSemester)->isPast()) {
        //     $errors['year'] = 'La date limite du premier semestre est dépassée.';
        // }

        // if ($deadSecondSemester && Carbon::parse($deadSecondSemester)->isPast()) {
        //     $errors['year'] = 'La date limite du second semestre est dépassée.';
        // }

        // if ($deadThirdSemester && Carbon::parse($deadThirdSemester)->isPast()) {
        //     $errors['year'] = 'La date limite du troisième semestre est dépassée.';
        // }

        // if (!empty($errors)) {
        //     return redirect()->back()->withErrors($errors);
        // }

        $stagiaire_id = $stagiaire->id;

        $mission = new Mission();
        $mission->categorie_id = $request->categorie_mission;
        $mission->stagiaire_id = $stagiaire_id;
        $mission->mission_name = $request->mission_name;
        $mission->mission_begin_date = $request->mission_begin_date;
        $mission->mission_end_date = $request->mission_end_date;
        $mission->mission_description = $request->mission_description;
        $mission->mission_year = Carbon::now()->year;
        if($r)
        {
            $path = !Storage::disk('public')->move($request->rapport, str_replace('rapport_previews','rapports', $request->rapport));
        }
        $mission->rapport_path = str_replace('rapport_previews','rapports', $request->rapport);
        $mission->save();

        $nb_hours = 0;

        foreach ($request->sous_categories as $index => $subcategory) {
            $sub_categorie = SubCategorie::where('id', $subcategory['ref'])->first();

            $mission_subcategorie = new MissionSubcategorie();
            $mission_subcategorie->mission_id = $mission->id;
            $mission_subcategorie->sub_categorie_id = $subcategory['ref'];
            $mission_subcategorie->hour = $subcategory['heures'];
            $mission_subcategorie->stagiaire_id = $stagiaire_id;
            $mission_subcategorie->sub_categorie_name = $sub_categorie->subcategorie_name;

            $nb_hours+=$subcategory['heures'];

            $mission_subcategorie->save();
        }

        $mission->nb_hour = $nb_hours;
        $mission->save();
        
        return redirect()->route('stagiaire.list_mission')->with(['success'=> __('message.mission_registred_with_success')]);

    }

    public function list_mission()
    {
        $stagiaire_id = Stagiaire::where('user_id', auth()->id())->first()->id;
        $missions = Mission::where('stagiaire_id', $stagiaire_id)->get();

        foreach ($missions as $mission) {
            $catego = Categorie::where('id', $mission->categorie_id)->first()->categorie_name;

            $mission->categorie_name = $catego; 

        }
        $missions = Mission::with('categorie') 
        ->where('stagiaire_id', $stagiaire_id)
        ->paginate(2);
        return view('Stagiaire.List_Missions', ['missions' => $missions]);
    }

    public function SearchMission(Request $request)
    {
         
        // $SearchM= $request->search;
        // $stagiaire_id = Stagiaire::where('user_id', auth()->id())->first()->id;
        // $missions = Mission::where('stagiaire_id', $stagiaire_id)->get();

        // foreach ($missions as $mission) {
        //     $catego = Categorie::where('id', $mission->categorie_id)->first()->categorie_name;

        //     $mission->categorie_name = $catego; 

        // }
        // $missions = Mission::with('categorie') 
        // ->where('mission_name', 'like', "%{$SearchM}%")
        // ->orWhere('mission_begin_date', 'like', "%{$SearchM}%")
        // ->orWhere('mission_end_date', 'like', "%{$SearchM}%")
        // ->get();

        // return view('Stagiaire.List_Missions', compact('missions', 'SearchM'));
        $SearchM = $request->search;
        $stagiaire_id = Stagiaire::where('user_id', auth()->id())->first()->id;
        
        // Requête de base avec pagination
        $missions = Mission::with('categorie')
            ->where('stagiaire_id', $stagiaire_id)
            ->where(function($query) use ($SearchM) {
                $query->where('mission_name', 'like', "%{$SearchM}%")
                      ->orWhere('mission_begin_date', 'like', "%{$SearchM}%")
                      ->orWhere('mission_end_date', 'like', "%{$SearchM}%");
            })
            ->paginate(10); // 10 éléments par page
        
        // Ajout des noms de catégorie
        foreach ($missions as $mission) {
            $mission->categorie_name = $mission->categorie->categorie_name;
        }
        
        return view('Stagiaire.List_Missions', [
            'missions' => $missions,
            'SearchM' => $SearchM
        ]);
        
    }

    public function show_add_jt()
    {
        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();
        $affiliation_orders = AffiliationOrder::all();

        return view('Stagiaire.Ajout', [
            'type' => 'jt',
            'year' => ['first'=>['begin' => $stagiaire->semester_0_begin,
                                'end' => $stagiaire->semester_0_end,
                                'limite' => $stagiaire->dead_0_semester],
                        'second'=>['begin' => $stagiaire->semester_1_begin,
                                'end' => $stagiaire->semester_0_end,
                                'limite' => $stagiaire->dead_1_semester],
        ],
            'affiliation_orders' => $affiliation_orders
        ]);
    }
   
    public function list_jt()
    {
        $stagiaire_id = Stagiaire::where('user_id', auth()->id())->first()->id;
        $jts = JourneeTechnique::where('stagiaire_id', $stagiaire_id)->get();

        return view('Stagiaire.List_JT', ['jts' => $jts]);
    }

    public function save_jt(Request $request)
    {

        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();

        $year = 1;

        $request->validate([
            'jt_name' => [
                'required',
                'string',
                'in:JT1,JT2,JT3',
                function ($attribute, $value, $fail) use ($stagiaire, $year) {
                    $stagiaireId = $stagiaire->id;

                    // Vérification de l'unicité de la journée technique
                    if (JourneeTechnique::where('jt_name', $value)
                                ->where('stagiaire_id', $stagiaireId)
                                ->where('jt_year', $year)
                                ->exists()) {
                        $fail('Il y a déjà une journée technique avec ce nom dans l\'année : ' . $year . '.');
                    }
                },
            ],
            'jt_date' => 'required|date',
            'jt_description' => 'required|string|min:5|max:255',
            'rapport' => 'nullable|mimes:pdf,docx',
            'jt_location' => 'required|string|max:255',
            'affiliation_order' => 'required|string|exists:affiliation_orders,id',
        ], [
            'jt_name.unique' => 'Il y a déjà une journée technique avec ce nom.',
        ]);


        $today = Carbon::now();

        $deadFirstSemester = $stagiaire->dead_0_semester;
        $deadSecondSemester = $stagiaire->dead_1_semester;

        $errors = [];

        if ($deadFirstSemester && Carbon::parse($deadFirstSemester)->isPast()) {
            $errors['year'] = 'La date limite du premier semestre est dépassée.';
        }

        if ($deadSecondSemester && Carbon::parse($deadSecondSemester)->isPast()) {
            $errors['year'] = 'La date limite du second semestre est dépassée.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        $affiliation_order = AffiliationOrder::where('id', $request->affiliation_order)->first();

        $jt = new JourneeTechnique();
        $jt->stagiaire_id = Stagiaire::where('user_id', auth()->id())->first()->id;
        $jt->jt_name = $request->jt_name;
        $jt->affiliation_order_id = $request->affiliation_order;
        $jt->affiliation_order = $affiliation_order->name;
        $jt->jt_date = $request->jt_date;
        $jt->jt_location = $request->jt_location;
        $jt->jt_description = $request->jt_description;
        $jt->rapport_path = $request->file('rapport') ? $request->file('rapport')->store('rapports', 'public') : null;
        $jt->jt_year = $year;

        $jt->save();

        return redirect()->route('stagiaire.list_jt')->with(['success'=> __('message.mission_registred_with_success')]);


    }

    public function showJT($id)
    {

        $jt = JourneeTechnique::where('id', $id)->first();

        return view('Stagiaire.Details_jt', compact('jt'));

    }

    public function listStagiaires(Request $request)
    {

        $stagiaires = Stagiaire::paginate(2);

        
        return view('Controleur.List_stagiaire', compact('stagiaires'));
       
    
    }
     
    public function SearchStagiare(Request $request)
    {
       
        $searchtem = $request->search;

        $stagiaires = Stagiaire::where('matricule', 'like', "%{$searchtem}%")
        ->orWhere('firstname', 'like', "%{$searchtem}%")
        ->orWhere('name', 'like', "%{$searchtem}%")
        ->orWhere('email', 'like', "%{$searchtem}%")
        ->orWhere('phone', 'like', "%{$searchtem}%")
        ->orWhere('country', 'like', "%{$searchtem}%")
        ->get();

        $country = Controleurs::where('user_id', auth()->id())->first()->country_contr;
        
        return view('Controleur.List_stagiaire', compact('stagiaires', 'searchtem', 'country'));

    }

    public function show_stagiaire($matricule)
    {
        $stagiaire = Stagiaire::where('matricule', $matricule)->firstOrFail();

        return view('Controleur.valider_stagiaire', compact('stagiaire'));
    }

    public function detailsStagiare()
    {
        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();
        return view('Stagiaire.informations_stagiaire', compact('stagiaire'));
    
    }

    public function showMission($id)
    {

        $mission = Mission::with('categorie')->with('sub_categories')->where('id', $id)->first();

        return view('Stagiaire.Details_Missions', compact('mission'));

    }

    public function calendar(Request $request)
    {
        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();
        
        // Calcul des périodes pour chaque stagiaire
        
            if ($stagiaire->stage_begin) {
                $dateDebut = \Carbon\Carbon::parse($stagiaire->stage_begin);
                
                // Calcul des années
                $stagiaire->first_year_begin = $dateDebut;
                $stagiaire->first_year_end = $dateDebut->copy()->addMonths(12)->subDay();
                
                // Calcul des semestres (6 semestres sur 3 ans)
                $semesters = [];
                for ($i = 0; $i < 6; $i++) {
                    $start = $i === 0 ? $dateDebut : $dateDebut->copy()->addMonths(6 * $i);
                    $end = $start->copy()->addMonths(6)->subDay();
                    $semesters[] = [
                        'number' => $i + 1,
                        'start' => $start,
                        'end' => $end
                    ];
                }
                $stagiaire->semesters = $semesters;
            }
       
        
        return view('Stagiaire.calendar', compact('stagiaire'));
    }
    
    public function list_stagiaire_acceuil(){

        $stagiaires= Stagiaire::all();

        return view('Liste_stagiares', compact('stagiaires'));
    }

}
