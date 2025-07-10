<?php

namespace App\Http\Controllers;

use App\Mail\ValidatedControllerEmail;
use App\Mail\ValidatedStagiaireEmail;
use App\Models\Assistant;
use App\Models\ControleurAssistant;
use App\Models\Controleurs;
use App\Models\Role;
use App\Models\RoleAssistant;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ControleurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Controleur.Add_assistant');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    
    public function list_stagiaires()
    {
        $controller = Controleurs::where('user_id', auth()->id())->first();
        if(Str::contains( auth()->user()->validated_type, 'controller'));
        $country_contr = "" ;
        $stagiaires = Stagiaire::where('country', $controller->country_contr)->get();
        $country = $controller->country_contr;

        return view('Controleur.List_stagiaire', compact('stagiaires', 'country'));
    }

    public function validate_stagiaire(Request $request)
    {
        $stagiaire = Stagiaire::where('id', $request->stagiaire_id)->first();
        $user = User::where('id', $stagiaire->user_id)->first();
        $controleur = Controleurs::where('user_id', auth()->user()->id)->first();
        
        if(Str::contains($user->validated_type, 'stagiaire') || $stagiaire->validated == true)
        {
            return redirect()->route('controller.liste_stagiaires')->with(['access_denied'=>'message.user_already_stagiaire']);
        }
        if($stagiaire->country != $controleur->country_contr )
        {
            return redirect()->route('controller.liste_stagiaires')->with(['access_denied'=>'message.not_in_your_attribution']);
        }

        $user->validated_type = $user->validated_type.','.'stagiaire';
        $user->save();
        $stagiaire->validated = true;
        $stagiaire->save();

        Mail::to($user->email)->send(new ValidatedStagiaireEmail(['name' => $stagiaire->name])); 
        
        return redirect()->route('controller.liste_stagiaires')->with(['success'=>'message.success']);

    }

    public function list_controller()
    {
        $controleurs = Controleurs::all();

        return view('admin.list_controleurs', compact('controleurs'));
    }

    // public function SearchControleur(Request $request){

    //     $SearchC= $request->search;

    //     $Controleurs= Controleurs::where(
    //         'name', 'like', "%{$SearchC}%")
    //     ->orWhere(
    //         'firstname', 'like', "%{$SearchC}%")
    //     -orwhere(
    //         'email', 'like', "%{$SearchC}%")
    //     -orwhere(
    //         'phone', 'like', "%{$SearchC}%"
    //     )
    //     -orwhere(
    //         'country', 'like', "%{$SearchC}%"
    //     )
    //     -get();
    //     return view('admin.list_controleurs', compact('controleurs', 'SearchC'));
    // }

    public function validate_controller(Request $request)
    {
        $request->validate(['id' => 'numeric',
                            'type' => 'in:CN,CR'
        ]);

        $controleur = Controleurs::where('id', $request->id)->first();
        $user = User::where('id', $controleur->user_id)->first();

        $controleur->validated = true;
        $controleur->save();
        if($request->type == 'CN')
        {
            $user->validated_type = $user->validated_type.',CN';
            $user->save();
        } else if($request->type == 'CR')
        {
            $user->validated_type = $user->validated_type.',CR';
            $user->save();
        }

        Mail::to($user->email)->send(new ValidatedControllerEmail(['name' => $controleur->name])); 

        return redirect()->route('admin.list_controleur')->with(['success'=>'SUCCESS']);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->type == 'CN') {

            if (Controleurs::where('user_id', auth()->user()->id)->where('type', 'CN')->exists()) {
                return redirect()->back()->withErrors(['general' => __('message.user_already_registered_as_national_controller')]);
            } 
        } elseif ($request->type == 'CR') {
            if (Controleurs::where('user_id', auth()->user()->id)->where('type', 'CR')->exists()) {
                return redirect()->back()->withErrors(['general' => __('message.user_already_registered_as_regional_controller')]);
            }
        } else {
            return redirect()->back()->withErrors(['type' => 'Type de contrôleur invalide.']);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'date' => 'required|date',
            'country' => 'required|string|max:255|in:Benin,Togo,Burkina-Faso,Mali,Senegal,Guinea-Bissau,Niger,Ivory-Coast',
            'country_contr' => 'required|string|max:255|in:Benin,Togo,Burkina-Faso,Mali,Senegal,Guinea-Bissau,Niger,Ivory-Coast',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'phone_code' => 'required|string|max:10',
            'type' => 'required|string|in:CN,CR', 
            'affiliation' => 'nullable|string|max:255',
            'numero_inscription'=>'required|string|max:255',
        ]);

        //dd($validatedData);

        // Enregistrement des données dans la base
        Controleurs::create([
            'user_id' => auth()->user()->id,
            'name' => $validatedData['name'],
            'firstname' => $validatedData['firstname'],
            'date' => $validatedData['date'],
            'country' => $validatedData['country'],
            'country_contr' => $validatedData['country_contr'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'phone_code' => $validatedData['phone_code'],
            'type' => $validatedData['type'],
            'affiliation' => $validatedData['affiliation'] ?? null,
            'numero_inscription' => $validatedData['numero_inscription'],
        ]);

       
        return redirect()->route('home')->with('success', 'Inscription réussie.');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $controleur=Controleurs::where('id', $id)->firstOrFail();
        
        return view('admin.Details_controleurs', compact('controleur'));

    }

    public function show_assistant($id)
    {
        $controleur = Controleurs::where('user_id', auth()->id())->first();
        $assistant = ControleurAssistant::with('roles')->where('id', $id)->first();

        if($assistant->controleur_id != $controleur->id){
            return redirect()->route('')->with('access_denied', __('message.this_is_not_your_assistant'));
        }

        $roles = Role::where('type', 'like', 'assistant')->get();

        foreach ($assistant->roles as $role) {
            $rol = $roles->firstWhere('id', $role->role_id);
            
            if ($rol) {
                $rol->checked = true;
            }
        }
        return view('Controleur.Assistant_features', ['assistant'=>$assistant,'roles'=> $roles]);
    }

    public function attribute_role_assistant(Request $request)
    {
        $request->validate([
            'assistant_id' => 'required|exists:controleur_assistants,id',
            'roles.*' => 'numeric|exists:roles,id',
        ]);
        
        $controleur = Controleurs::where('user_id', auth()->id())->first();
        $assistant = ControleurAssistant::where('id', $request->assistant_id)->first();

        if ($assistant->controleur_id != $controleur->id) {
            return redirect()->route('')->with('access_denied', __('message.this_is_not_your_assistant'));
        }

        $role_assistants = RoleAssistant::where('controleur_assistant_id', $assistant->id)->get();
        foreach($role_assistants as $role_assistant)
        {
            $role_assistant->delete();
        }
        foreach ($request->roles as $role_id) {
            $role = Role::where('id', $role_id)->first();
            $role_assistant = new RoleAssistant();
            $role_assistant->controleur_assistant_id = $assistant->id;
            $role_assistant->role_id = $role->id;
            $role_assistant->name = $role->name;
            
            $role_assistant->save();
        }

        return redirect()->route('controleur.assistant_feature', ['id' => $assistant->id])->with('success', 'SUCCESS');
    }

    public function add_assistant(Request $request)
    {
        $request->validate([
            'full_name'=>'required|string|min:3|max:200',
            'titre'=>'nullable|string|min:3|max:200',
            'fonction'=>'nullable|string|min:3|max:200',

            // 'first_name'=>'required|string|min:3|max:100',
            // 'name'=>'required|string|min:3|max:100',
            // 'email'=>'required|string|min:3|max:100|unique:users|unique:controleur_assistants',
            // 'phone'=>'required|string|min:6|max:100',
            // 'address'=>'required|string|min:3|max:100',
            // 'city'=>'required|string|min:3|max:100',
            // 'specialty'=>'nullable|string|min:3|max:100',
            // 'birth_date'=>'required|date',
            // 'hire_date'=>'nullable|date',
            // 'cnss_number'=>'nullable|string|min:4,max:100',
            // 'diploma'=>'nullable|file|mimes:pdf,png,jpg,jpeg',
            // 'photo'=>'required|file|mimes:png,jpg,jpeg',

            'password'=>'required|string|min:8|confirmed',
        ]);

        $controleur = Controleurs::where('user_id', auth()->id())->first();

        if(!$controleur->country_contr)
        {
            redirect()->route('accueil')->with('access_denied', __('message.access_denied'));
        }

        $assistant = new ControleurAssistant();
        $assistant->full_name = $request->full_name;
        $assistant->email = $request->email;
        $assistant->fonction = $request->fonction;
        $assistant->titre = $request->titre;
        $assistant->controleur_id = $controleur->id;

        // $assistant->first_name = $request->first_name;
        // $assistant->name = $request->name;
        // $assistant->phone = $request->phone;
        // $assistant->address = $request->address;
        // $assistant->city = $request->city;
        // $assistant->specialty = $request->specialty;
        // $assistant->hire_date = $request->hire_date;
        // $assistant->cnss_number = $request->cnss_number;
        // $assistant->birth_date = $request->birth_date;
        // $assistant->picture_path =  $request->file('photo') ? $request->file('photo')->store('pictures', 'public') : null;
        // $assistant->diploma =  $request->file('diploma') ? $request->file('diploma')->store('diplomes', 'public') : null;

        $assistant->country_contr = $controleur->country_contr;


        $user = new User();

        $user->email = $assistant->email;
        $user->fullname = $assistant->full_name;
        $user->password = Hash::make($request->password);
        $user->validated_type = 'assistant_controller';
        $user->role = 'assistant_controller';
        $user->save();

        $assistant->user_id = $user->id;
        $assistant->save();

        return redirect()->route('controleur.assistant_feature', ['id' => $assistant->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Controleurs $controleur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Controleurs $controleur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Controleurs $controleur)
    {
        //
    }

    
}
