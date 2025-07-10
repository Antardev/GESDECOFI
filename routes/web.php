<?php

use App\Http\Controllers\StagiaireController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControleurController;
use App\Models\Controleurs;
use App\Models\Stagiaire;
use App\Models\User;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//General Routes

Route::get('/', function () {
    return view('Acceuil');
})->name('home');

Route::get('/welcome', function () {
    return view('Acceuil');
})->name('welcome');


Route::post('/voirPDF', function(Request $request) {
    return view('Controleur.View_PDF', ['pdf'=>$request->pdf]);
})->name('View_PDF');


    Route::get('/NousContacter', function () {
        return view('NousContacter');
    })->name('NousContacter');
    

// GUEST USER Routes

Route::group(['middleware' => ['auth', 'verified', 'emailverified']] , function () {

    Route::get('/home', function () {
        $table = [];
        $table['cn_yet'] = 0;
        $table['cr_yet'] = 0;
    
        $user = User::where('id', auth()->user()->id)->first();
        $controleurs = $user->hasMany(Controleurs::class);
        foreach ($controleurs as $controleur) {
            
            if($controleurs->type=='CN'){
                $table['cn_yet']=1;
            }else
            if($controleurs->type=='CR'){
                $table['cr_yet']=1;
            }
        }
        return view('landing', [
            'cn_yet' => $table['cn_yet'],
            'cr_yet' => $table['cr_yet'],
        ]);
    })->middleware(['auth', 'verified'])->name('accueil');
    
    Route::get('/landing', function () {
    
        $table = [];
        $table['cn_yet'] = 0;
        $table['cr_yet'] = 0;
    
        $user = User::where('id', auth()->user()->id)->first();
        $controleurs = $user->hasMany(Controleurs::class);
        foreach ($controleurs as $controleur) {
            
            if($controleurs->type=='CN'){
                $table['cn_yet']=1;
            }else
            if($controleurs->type=='CR'){
                $table['cr_yet']=1;
            }
        }

        return view('landing', [
            'cn_yet' => $table['cn_yet'],
            'cr_yet' => $table['cr_yet'],
        ]);
    })->name('landing');
    
    Route::post('/Choix', function (Request $request) {
        $type = $request->input('type');
        if ($type === 'stagiaire') {
            return redirect('/Choix_stagiaire'); // Redirige vers la page stagiaire
        } elseif ($type === 'controleur_national') {
            return redirect('/enter_like/CN');// Redirige vers la page contrôleur national
        } elseif ($type === 'controleur_regional') {
            return redirect('enter_like/CR'); // Redirige vers la page contrôleur régional
        } elseif ($type === 'assistant') {
            return redirect()->route('assistant.page'); // Redirige vers la page assistant
        }
        return redirect()->route('home');
    })->name('enter_like');
    
    Route::get('/Choix_stagiaire', function () {
    
        return view('SignStage', ['stagiaire' => $stagiaire ?? null]);
    
    })->name('stagiaire.page');
    

    Route::get('/enter_like/{type}', function ($type) {
        if ($type === 'CN') {
        } elseif ($type === 'CR') {
        } else {
            return redirect()->route('home');
        }
        return view('SignCN', ['type' => $type]);
    })->name('controleur_national.page');
    
    Route::get('/Choix_Controleur_National', function (Request $request) {
        $type = $request->input('type');
        return view('SignCN', ['type'=>$type]); // Redirige vers la page contrôleur national);
    })->name('controleur_national.page');
    
    Route::get('/Choix_Controleur_Regional', function (Request $request) {
        $type = $request->input('type');
        return view('SignCN', ['type'=>$type]); // Redirige vers la page contrôleur national);
    })->name('controleur_Regionale.page');
    
    
    Route::get('/download_form', function () {
        
        $user= auth()->user();
        if ($user && Str::contains($user->role, 'stagiaire')) {
            
            $stagiaire = Stagiaire::where('user_id', $user->id)->first();
        
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
    
        return view('stagiaire.download_form');
    })->middleware(['auth', 'verified'])->name('download_form');
    


    // STAGIAIRE ROUTES

    Route::get('/stagiaire/form', function() {
        if(auth()->user() && Str::contains(auth()->user()->validated_type, 'stagiaire'))
        {
            return view('stagiaire.pdf_stagiaire');
        } else {
            return redirect()->route('download_form');
        }
    })->middleware(['auth', 'verified'])->name('pdf_stagiaire_view');

    Route::get('/download_form/return', function () {

        $user= auth()->user();
        if ($user && Str::contains($user->validated_type, 'stagiaire')) {
            
            $stagiaire = Stagiaire::where('user_id', $user->id)->first();
        
        return view('stagiaire.download_form')->with([
            'firstname' => $stagiaire->firstname,
            'name' => $stagiaire->name,
            'email' => $stagiaire->email,
            'phone_number' => $stagiaire->phone,
            'birth_date' => $stagiaire->birthdate,
            'country' => $stagiaire->country,
            'matricule' => $stagiaire->matricule
        ]);

        } else {
            return redirect()->route('download_form');
        }
    
    })->middleware(['auth', 'verified'])->name('download_form_return');


    Route::middleware(['auth', 'verified'])->controller(StagiaireController::class)->group(function () {
        
        Route::post('/stagiaire/create', 'store')->name('stagiaire.create');


        Route::get('/stagiaire/get/{matricule}', 'show')->name('show_stagiaire');
        
        Route::put('/stagiaire/edit', 'edit')->name('stagiaire.edit');
        
        Route::get('/stagiaire/inscription', function (){
            $stagiaire = Stagiaire::where('user_id', auth()->id())->first();
            if(!$stagiaire)
            {
                return redirect()->route('pdf_stagiaire_view');
            }
            return view('stagiaire.inscription', ['stage'=>$stagiaire->stage_begin?true:false]);})->name('stagiaire.inscription'
        );
        Route::post('/stagiaire/update', 'update')->name('stagiaire.update');
    });
    
    // VERIFIED STAGIAIRE ROUTES


    Route::middleware(['auth', 'verified', 'stagiaireverified'])->controller(StagiaireController::class)->group(function () {
        
        Route::get('/stagiaire/list_mission', 'list_mission')->name('stagiaire.list_mission');
        Route::get('/Informations_stagiaire', 'detailsStagiare')->name('stagiaire.details');
        Route::get('/stagiaire/mission_details/{id}', 'showMission')->name('missions.show');


        Route::get('/stagiaire/list_jt', 'list_jt')->name('stagiaire.list_jt');
        Route::get('/stagiaire/jt_details/{id}', 'showJT')->name('jt.show');

        //Route::get('/liste_missions', 'list_mission')->name('Listes_missions');

        Route::get('/stagiaire/ajout_jt','show_add_jt')->name('Ajout_fiche');

        Route::post('/stagiaire/ajout_jt','save_jt')->name('stagiaire.ajout_jt');

        Route::get('/stagiaire/ajout_mission', 'show_add_mission')->name('Ajout_mission');
        
        Route::post('/stagiaire/ajout_mission', 'save_mission')->name('stagiaire.ajout_mission');



    });
    

    // CONTROLEUR ROUTES

    Route::middleware(['auth', 'verified'])->controller(ControleurController::class)->group(function () {

        Route::post('/controleur/store', 'store')->name('controleur.store');
        // Route::get('/listes_controleurs', 'list_controleurs')->name('list_controleurs');
        
        
    });

    Route::middleware(['auth', 'verified'])->controller(StagiaireController::class)->group(function () {
        
        Route::get('/liste_stagiaires', 'listStagiaires')->name('Listes_stagiaires');
        
    });

    // VERIFIED CONTROLEUR ROUTES

    Route::middleware(['auth', 'verified', 'cnverified'])->controller(StagiaireController::class)->group(function () {


        Route::get('/valider_stagiaire/{matricule}', 'show_stagiaire')->name('show_stagiaire');
        Route::get('/searchStagiaire', 'SearchStagiare')->name('SearchStagiare');
        Route::get('/searchMissions', 'SearchMission')->name('SearchMission');
    });

    Route::middleware(['auth', 'verified', 'cnverified'])->controller(ControleurController::class)->group(function () {

        Route::get('/controller/liste_stagiaires', 'list_stagiaires')->name('controller.liste_stagiaires');

        Route::post('/controleur/valider', 'validate_stagiaire')->name('controller.validate_stagiaire');
     
        Route::get('/controleur/add_assistant', 'index')->name('controleur.Add_assistant');

        Route::post('/controleur/add_assistant', 'add_assistant')->name('controleur.add_assistant');

        Route::get('/controleur/assistant/{id}', 'show_assistant')->name('controleur.assistant_feature');

        Route::post('/controleur/assistant/add_role', 'attribute_role_assistant')->name('controller.assign_roles');

        Route::get('/controleur/assistant/attribute_role', 'attribute_role_assistant')->name('controller.attribute_role_assistant');

        Route::get('/SearchControleur', ' SearchControleur')->name(' SearchControleur');

       


    });

    // SUPERADMIN ROUTES

    Route::middleware(['auth', 'verified', 'superadmin'])->controller(ControleurController::class)->group(function () {

        Route::get('/admin/liste_controleurs', 'list_controller')->name('admin.list_controleur');

        Route::get('/admin/validate_controleur', 'validate_controller')->name('admin.validate_controleur');

        Route::get('/admin/details_controleurs/{id}', 'show')->name('Show_controleur');

    });

Route::get('/Profile', function () {
    return view('auth.profile');
})->middleware(['auth', 'verified'])->name('Profile');
});

// // STAGIAIRE Routes

// Route::group(['middleware' => ['auth', 'verified', 'stagiaireverified', '']] , function () {


// }

// // CR Routes

// Route::group(['middleware' => ['auth', 'verified', 'crverified']] , function () {


// }


// // CN Routes

// Route::group(['middleware' => ['auth', 'verified', 'cnverified']] , function () {


// }



// Route::get('/stagiaire/form/{matricule}', function($matricule) {
//     $stagiaire = Stagiaire::where('matricule', $matricule)->firstOrFail(); // Récupère le stagiaire par matricule
//     return view('Stagiaire.download_form', compact('stagiaire')); // Passe les données à la vue
// })->middleware(['auth', 'verified'])->name('update_form');