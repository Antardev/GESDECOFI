<?php

namespace App\Http\Controllers;

use App\Models\JourneeTechnique;
use App\Models\Mission;
use App\Models\MissionSubcategorie;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\Categorie;
use App\Models\SubCategorie;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'country' => 'required|string|in:Benin,Togo,Burkina Faso,Mali,Senegal,Guinea-Bissau,Niger',
        ]);

        $stagiaire = new Stagiaire();
        $stagiaire->user_id = auth()->id();
        $stagiaire->firstname = $validator['firstname'];
        $stagiaire->name = $validator['name'];
        $stagiaire->email = $validator['email'];
        $stagiaire->phone = $validator['phone_number'];
        $stagiaire->birthdate = $validator['birth_date'];
        $stagiaire->country = $validator['country'];


        $user1 = User::where('id', $stagiaire->user_id)->first();
        $user1->type = $user1->role.',stagiaire';
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
            
            $firstSemester = [
                'debut' => $dateDebut->copy()->startOfMonth(),
                'fin' => $dateDebut->copy()->addMonths(5)->endOfMonth(),
                'limite' => $dateDebut->copy()->addMonths(5)->endOfMonth()->addMonth()
            ];

            $secondSemester = [
                'debut' => $firstSemester['fin']->copy()->addDay(),
                'fin' => $firstSemester['fin']->copy()->addDay()->copy()->addMonths(5)->endOfMonth(),
                'limite' => $firstSemester['fin']->copy()->addDay()->copy()->addMonths(5)->endOfMonth()->copy()->addMonth()
            ];

            $thirdSemester = [
                'debut' => $secondSemester['fin']->copy()->addDay(),
                'fin' => $secondSemester['fin']->copy()->addDay()->copy()->addMonths(5)->endOfMonth(),
                'limite' => $secondSemester['fin']->copy()->addDay()->copy()->addMonths(5)->endOfMonth()->copy()->addMonth()
            ];
        }

        $stagiaire->first_semester_begin = $firstSemester["debut"];
        $stagiaire->first_semester_end = $firstSemester["fin"];
        $stagiaire->dead_first_semester = $firstSemester["limite"];

        $stagiaire->second_semester_begin = $secondSemester["debut"];
        $stagiaire->second_semester_end = $secondSemester["fin"];
        $stagiaire->dead_second_semester = $secondSemester["limite"];

        $stagiaire->third_semester_begin = $thirdSemester["debut"];
        $stagiaire->third_semester_end = $thirdSemester["fin"];
        $stagiaire->dead_third_semester = $thirdSemester["limite"];

        $stagiaire->save();

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
            'country' => 'required|string|in:benin,civ,senegal,togo,mali,ghana,cameroon',
        ]);


        $stagiaire->firstname = $validator['firstname'];
        $stagiaire->name = $validator['name'];
        $stagiaire->email = $validator['email'];
        $stagiaire->phone = $validator['phone_number'];
        $stagiaire->birthdate = $validator['birth_date'];
        $stagiaire->country = $validator['country'];

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
            'year' => ['first'=>['begin' => $stagiaire->first_semester_begin,
                                'end' => $stagiaire->first_semester_end,
                                'limite' => $stagiaire->dead_first_semester],
                        'second'=>['begin' => $stagiaire->second_semester_begin,
                                'end' => $stagiaire->second_semester_end,
                                'limite' => $stagiaire->dead_second_semester],
                        'third'=>['begin' => $stagiaire->third_semester_begin,
                                'end' => $stagiaire->third_semester_end,
                                'limite' => $stagiaire->dead_third_semester]]
                    
        ]);
    }

    public function save_mission(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'mission_name'=>'required|string|min:3|max:255',
            'mission_begin_date'=>'required',
            'enterprise_name'=>'string|min:3|max:255',
            'mission_end_date'=>'required',
            'categorie_mission'=>'required|exists:categories,id',
            'mission_description'=>'required|string|min:5|max:255',
            'year'=>'required|in:first,second,third',
            'mission_description'=>'required|string|min:5|max:255',
            'mission_rapport'=>'nullable|mimes:pdf,docx',
            'sous_categories.ref' => 'exists:sous_categories,id,categorie_id,' . $request->categorie_mission,
            'sous_categories' => 'required|array',
            'sous_categories.*.heures' => 'numeric|min:0',

        ]);
        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();

        $today = Carbon::now();

        $deadFirstSemester = $stagiaire->dead_first_semester;
        $deadSecondSemester = $stagiaire->dead_second_semester;
        $deadThirdSemester = $stagiaire->dead_third_semester;

        $errors = [];

        if ($deadFirstSemester && Carbon::parse($deadFirstSemester)->isPast()) {
            $errors['year'] = 'La date limite du premier semestre est dépassée.';
        }

        if ($deadSecondSemester && Carbon::parse($deadSecondSemester)->isPast()) {
            $errors['year'] = 'La date limite du second semestre est dépassée.';
        }

        if ($deadThirdSemester && Carbon::parse($deadThirdSemester)->isPast()) {
            $errors['year'] = 'La date limite du troisième semestre est dépassée.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        $stagiaire_id = $stagiaire->id;

        $mission = new Mission();
        $mission->categorie_id = $request->categorie_mission;
        $mission->stagiaire_id = $stagiaire_id;
        $mission->mission_name = $request->mission_name;
        $mission->mission_begin_date = $request->mission_begin_date;
        $mission->mission_end_date = $request->mission_end_date;
        $mission->mission_description = $request->mission_description;
        $mission->mission_year = Carbon::now()->year;
        $mission->rapport_path = $request->file('mission_rapport') ? $request->file('mission_rapport')->store('rapports') : null;

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
        return view('Stagiaire.List_Missions', ['missions' => $missions]);
    }

    public function show_add_jt()
    {
        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();


        return view('Stagiaire.Ajout', [
            'type' => 'jt',
            'year' => ['first'=>['begin' => $stagiaire->first_semester_begin,
                                'end' => $stagiaire->first_semester_end,
                                'limite' => $stagiaire->dead_first_semester],
                        'second'=>['begin' => $stagiaire->second_semester_begin,
                                'end' => $stagiaire->second_semester_end,
                                'limite' => $stagiaire->dead_second_semester],
                        'third'=>['begin' => $stagiaire->third_semester_begin,
                                'end' => $stagiaire->third_semester_end,
                                'limite' => $stagiaire->dead_third_semester]]
        ]);
    }
   
    public function save_jt(Request $request)
    {
        $request->validate([
            'jt_name'=>'required|string|min:3|max:255',
            'jt_date'=>'required|date',
            'year'=>'required|in:first,second,third',
            'categorie_id'=>'categorie_id|exists:categories,id',
            'jt_description'=>'required|string|min:5|max:255',
            'jt_rapport'=>'nullable|mimes:pdf,docx',
            'jt_location' => 'required|string|max:255',

        ]);

        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();

        $today = Carbon::now();

        $deadFirstSemester = $stagiaire->dead_first_semester;
        $deadSecondSemester = $stagiaire->dead_second_semester;
        $deadThirdSemester = $stagiaire->dead_third_semester;

        $errors = [];

        if ($deadFirstSemester && Carbon::parse($deadFirstSemester)->isPast()) {
            $errors['year'] = 'La date limite du premier semestre est dépassée.';
        }

        if ($deadSecondSemester && Carbon::parse($deadSecondSemester)->isPast()) {
            $errors['year'] = 'La date limite du second semestre est dépassée.';
        }

        if ($deadThirdSemester && Carbon::parse($deadThirdSemester)->isPast()) {
            $errors['year'] = 'La date limite du troisième semestre est dépassée.';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }



        $jt = new JourneeTechnique();
        $jt->categorie_id = $request->categorie_id;
        $jt->stagiaire_id = Stagiaire::where('user_id', auth()->id())->first()->id;
        $jt->jt_name = $request->jt_name;
        $jt->jt_date = $request->jt_date;
        $jt->jt_description = $request->jt_description;

    }

    public function listStagiaires(){

        $stagiaires = Stagiaire::all();
        return view('Controleur.List_stagiaire', compact('stagiaires'));
    }

    public function show_stagiaire($matricule){
        $stagiaire = Stagiaire::where('matricule', $matricule)->firstOrFail();
        return view('Controleur.valider_stagiaire', compact('stagiaire'));
    }

    public function showMission($id)
    {

        $mission = Mission::with('categorie')->with('sub_categories')->where('id', $id)->first();

        return view('Stagiaire.Details_Missions', compact('mission'));

    }
 
}
