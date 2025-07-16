<?php

namespace App\Http\Controllers;

use App\Mail\ValidatedControllerEmail;
use App\Mail\ValidatedStagiaireEmail;
use App\Models\Controleurs;
use App\Models\Rapport;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class SuperAdminController extends Controller
{
  
    public function show_stagiaire($matricule)
    {

        $stagiaire = Stagiaire::where('matricule', $matricule)->firstOrFail();

        return view('superadmin.valider_stagiaire', compact('stagiaire'));

    }

    public function list_stagiaires()
    {

        $stagiaires = Stagiaire::all();

        return view('superadmin\Liste_stagiares', compact('stagiaires'));
    }

    public function validate_stagiaire(Request $request)
    {
        $stagiaire = Stagiaire::where('id', $request->stagiaire_id)->first();
        $user = User::where('id', $stagiaire->user_id)->first();
        
        if(Str::contains($user->validated_type, 'stagiaire') || $stagiaire->validated == true)
        {
            return redirect()->route('superadmin.liste_stagiaires')->with(['access_denied'=>'message.user_already_stagiaire']);
        }

        $user->validated_type = $user->validated_type.','.'stagiaire';
        $user->save();
        $stagiaire->validated = true;
        $stagiaire->save();

        Mail::to($user->email)->send(new ValidatedStagiaireEmail(['name' => $stagiaire->name])); 
        
        return redirect()->route('superadmin.liste_stagiaires')->with(['success'=>'message.success']);

    }


    public function list_controller()
    {
        $controleurs = Controleurs::all();
        
        // dd($controleurs);
        return view('superadmin.list_controleurs', compact('controleurs'));
    }

    public function list_controllerCN()
    {
        $controleurs = Controleurs::where('type', 'CN')->get();

        return view('superadmin.List_CN', compact('controleurs'));
    }

    public function show($id)
    {

        $controleur=Controleurs::where('id', $id)->firstOrFail();
        
        return view('superadmin.Details_controleurs', compact('controleur'));

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

        Mail::to($user->email)->send(new ValidatedControllerEmail(['name' => $controleur->name])); 

        return redirect()->route('superadmin.list_controleur')->with(['success'=>'SUCCESS']);

    }

    public function exam_rapport($id)
    {

        $rapport = Rapport::where('id', $id)->first();

        $stagiaire = Stagiaire::where('id', $rapport->stagiaire_id)->first();
        $rapport->stagiaire = $stagiaire;

        return view('superadmin.exam_student', compact('rapport'));

    }

    public function rapport_history($id)
    {
        $stagiaire = Stagiaire::where('id', $id)->first();

        $rapports = Rapport::where('stagiaire_id', $stagiaire->id)->get();            

        return view('superadmin.RapportHistory', compact('rapports'));
    }

    public function stagiaire_recap($id)
    {
        $stagiaire = Stagiaire::with('rapports')
                                ->with('jt_year_1')
                                ->with('jt_year_2')
                                ->with('jt_year_3')
                                ->where('id', $id)->first();

        return view('superadmin.Recap_Stagiaire', ['stagiaire' => $stagiaire]);

    }

    public function stagiaires_recap()
    {

        $stagiaires = Stagiaire::with('rapports')
                                ->with('jt_year_1')
                                ->with('jt_year_2')
                                ->with('jt_year_3')
                                ->whereNotNull('stage_begin')
                                ->get();

        return view('superadmin.Recap', ['stagiaires' => $stagiaires]);

    }

}
