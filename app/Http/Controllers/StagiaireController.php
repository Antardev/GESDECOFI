<?php

namespace App\Http\Controllers;

use App\Models\JourneeTechnique;
use App\Models\Stagiaire;
use App\Models\User;
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
            'country' => 'required|string|in:benin,civ,senegal,togo,mali,ghana,cameroon',
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
            'enterprise_name' => 'required|string|min:4|max:255',
            'nom_representant' => 'required|string|min:4|max:255',
            'lieu_cabinet' => 'required|string|min:3|max:255',
            'nom_cabinet' => 'required|string|min:4|max:255',
            'date_entree' => 'required|date',
        ]);

        $stagiaire = Stagiaire::where('matricule', $request->matricule)->first();

        if (!$stagiaire) {
            return redirect()->back()->withErrors(['message' => __('message.intern_not_found')]);
        } elseif ($stagiaire->user_id != auth()->id()) {
            return redirect()->back()->withErrors(['message' => __('message.access_denied')]);
        }

        $stagiaire->file_path = $request->file('fiche')->store('fiches');
        $stagiaire->diplome_path = $request->file('diplome')->store('diplomes');
        $stagiaire->contrat_path = $request->file('contrat')->store('contrats');
        $stagiaire->picture_path = $request->file('picture')->store('pictures');
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
        $stagiaire->nom_cabinet = $request->nom_cabinet;
        $stagiaire->numero_inscription_cabinet = $request->numero_inscription_maitre;
        $stagiaire->date_entree = $request->date_entree;

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

        return view('Stagiaire.Missions', [
            'delai' => Carbon::now()->addDays(30)->format('Y-m-d'),
            'type' => 'jt',
            'year' => Carbon::now()->year,
        ]);
    }

    public function save_mission(Request $request)
    {    
        $request->validate([
            'mission_name'=>'required|string|min:3|max:255',
            'mission_begin_date'=>'required',
            'enterprise_name'=>'string|min:3|max:255',
            'mission_end_date'=>'required',
            'mission_description'=>'required|string|min:5|max:255',
            'mission_rapport'=>'nullable|mimes:pdf,docx',
            

        ]);


    }

    public function show_add_jt()
    {
        
        return view('Stagiaire.Ajout', [
            'delai' => Carbon::now()->addDays(30)->format('Y-m-d'),
            'type' => 'jt',
            'year' => Carbon::now()->year,
        ]);
    }
   
    public function save_jt(Request $request)
    {
        $request->validate([
            'jt_name'=>'required|string|min:3|max:255',
            'jt_date'=>'required|date',
            'categorie_id'=>'categorie_id|exists:categories,id',
            'jt_description'=>'required|string|min:5|max:255',
            'jt_rapport'=>'nullable|mimes:pdf,docx',
            'jt_location' => 'required|string|max:255',

        ]);

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

}
