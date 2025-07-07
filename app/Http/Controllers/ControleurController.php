<?php

namespace App\Http\Controllers;

use App\Mail\ValidatedStagiaireEmail;
use App\Models\Controleurs;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Http\Request;
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
        $stagiaires = Stagiaire::all();
        return view('Controleur.List_stagiaire', compact('stagiaires'));
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
            'country' => 'required|string|max:255|in:Benin,Togo,Burkina-Faso,Mali,Senegal,Guinea-Bissau,Niger',
            'country_contr' => 'required|string|max:255|in:Benin,Togo,Burkina-Faso,Mali,Senegal,Guinea-Bissau,Niger',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'phone_code' => 'required|string|max:10',
            'type' => 'required|string|in:CN,CR', 
            'affiliation' => 'nullable|string|max:255',
        ]);
    
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
