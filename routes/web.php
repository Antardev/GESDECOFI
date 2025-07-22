<?php

use App\Http\Controllers\StagiaireController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControleurController;
use App\Http\Controllers\SuperAdminController;
use App\Models\Controleurs;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\MessageController;
use App\Models\Stagiaire;
use App\Models\AffiliationOrder;
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

    // Route::get('shownavabar', function () {
    //     $notificationCount = auth()->user()->unreadNotifications->count();
    //     return view('navbar.nav', compact('notificationCount'));
    // })->name('shownavbar');

Route::get('/Liste_stagiaires', [StagiaireController::class, 'list_stagiaire_acceuil'])->name('Liste_stagiaire_acceuil');

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
        $affiliations= AffiliationOrder::all();

        return view('SignCN', ['type' => $type,
            'affiliations' => $affiliations]);
    })->name('controleur_national.page');
    
    Route::get('/Choix_Controleur_National', function (Request $request) {
        $type = $request->input('type');
        $affiliations= AffiliationOrder::all();
        return view('SignCN', [
            'type'=>$type,
            'affiliations' => $affiliations
        ]); // Redirige vers la page contrôleur national);
    })->name('controleur_national.page');
    
    Route::get('/Choix_Controleur_Regional', function (Request $request) {
        $type = $request->input('type');
        $affiliations= AffiliationOrder::all();
        return view('SignCN', [
            'type'=>$type,
            'affiliations' => $affiliations
        ]); // Redirige vers la page contrôleur national);
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
        $stagiaire = Stagiaire::where('user_id', $user->id)->first();
        if ($user && $stagiaire) {
            
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

// Il s'agit des routes du stagiaire non verifié
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
    
    // Il s'agit des routes du stagiaire verifié


    Route::middleware(['auth', 'verified', 'stagiaireverified'])->controller(StagiaireController::class)->group(function () {
        
        Route::get('/stagiaire/list_mission', 'list_mission')->name('stagiaire.list_mission');
        Route::get('/Informations_stagiaire', 'detailsStagiare')->name('stagiaire.details');
        Route::get('/stagiaire/mission_details/{id}', 'showMission')->name('missions.show');

        Route::get('/stagiaire/list_jt', 'list_jt')->name('stagiaire.list_jt');
        Route::get('/stagiaire/jt_details/{id}', 'showJT')->name('jt.show');

        //Route::get('/liste_missions', 'list_mission')->name('Listes_missions');

        Route::get('/stagiaire/ajout_jt','show_add_jt')->name('Ajout_fiche');

        Route::get('Tableau1', 'Tableau_1')->name('Tableau1');

        Route::get('Tableau2', 'Tableau_2')->name('Tableau2');
        
        Route::get('Tableau2r', 'Tableau_3')->name('Tableau3');

        Route::get('Tableau4', 'Tableau_4')->name('Tableau4');

        Route::get('Tableau5', 'Tableau_5')->name('Tableau5');


        Route::post('/stagiaire/ajout_jt','save_jt')->name('stagiaire.ajout_jt');

        Route::get('/stagiaire/ajout_mission', 'show_add_mission')->name('Ajout_mission');

        Route::post('/stagiaire/create_mission', 'create_mission')->name('stagiaire.create_mission');
        
        Route::post('/stagiaire/ajout_mission', 'save_mission')->name('stagiaire.ajout_mission');

        Route::get('/stagiaire/ajout_rapport', 'add_rapport')->name('stagiaire.ajout_rapport');

        Route::post('/stagiaire/save_rapport', 'save_rapport')->name('stagiaire.save_rapport');

        Route::get('/stagiaire/history_rapport', 'rapport_history')->name('stagiaire.rapport_history');

        Route::get('/stagiaire/recap_jt_annee', 'recap_jt_annee')->name('stagiaire.recap_jt_annee');


        Route::get('/Calendar', 'calendar')->name('calendarshow');

    });
    

    // CONTROLEUR ROUTES

    Route::middleware(['auth', 'verified'])->controller(ControleurController::class)->group(function () {

        Route::post('/controleur/store', 'store')->name('controleur.store');
        Route::get('/liste_controleur_national', 'list_controllerCN')->name('list_controleur_national');
        Route::get('/show_chat','show_message')->name('chat');
        
    });

    Route::middleware(['auth', 'verified'])->controller(StagiaireController::class)->group(function () {
        
        Route::get('/searchMissions', 'SearchMission')->name('SearchMission');
        
    });

    // VERIFIED CONTROLEUR ROUTES

    Route::middleware(['auth', 'verified', 'cnverified'])->controller(StagiaireController::class)->group(function () {

        Route::get('/valider_stagiaire/{matricule}', 'show_stagiaire')->name('show_stagiaire');
        Route::get('/searchStagiaire', 'SearchStagiare')->name('SearchStagiare');
    
       
    });

    Route::middleware(['auth', 'verified', 'cnverified', 'assistant_complete'])->controller(ControleurController::class)->group(function () {

        Route::get('/controller/liste_stagiaires', 'list_stagiaires')->name('controller.liste_stagiaires');

        Route::post('/controleur/valider', 'validate_stagiaire')->name('controller.validate_stagiaire');
     
        Route::get('/controleur/add_assistant', 'index')->name('controleur.Add_assistant');

        Route::post('/controleur/add_assistant', 'add_assistant')->name('controleur.add_assistant');

        Route::get('/controleur/assistant/{id}', 'show_assistant')->name('controleur.assistant_feature');

        Route::post('/controleur/assistant/add_role', 'attribute_role_assistant')->name('controller.assign_roles');

        Route::get('/controleur/assistant/attribute_role', 'attribute_role_assistant')->name('controller.attribute_role_assistant');

        Route::get('/student/exam/{id}', 'exam_rapport')->name('controleur.exam_rapport');

        Route::get('controleur/stagiaire/history_rapport/{id}', 'rapport_history')->name('controleur.rapport_history');

        Route::get('controleur/stagiaire/recap/{id}', 'stagiaire_recap')->name('controleur.stagiaire_recap');

        Route::get('controleur/stagiaires/recap', 'stagiaires_recap')->name('controleur.stagiaires_recap');

        Route::get('/SearchControleur', ' SearchControleur')->name(' SearchControleur');

    });

    Route::middleware(['auth', 'verified', 'crverified'])->controller(ControleurController::class)->group(function () {

        Route::get('/CR/liste_stagiaires', 'list_stagiairesCR')->name('Listes_stagiairesCR');
        Route::get('/show_input_domaine', 'show_input_domaine')->name('show_input_domaine');
        Route::get('/show_input_sous_domaine', 'show_input_sous_domaine')->name('show_input_sous_domaine');
        Route::post('/add_domaine', 'save_domain')->name('save_domaine');
        Route::post('/add_sous_domaine', 'save_subdomain')->name('save_sous_domaine');
        Route::get('/liste_domaines', 'list_domaines')->name('list_domaines');
        Route::get('/liste_sous domaines', 'list_sous_domaines')->name('Liste_sous domaines');
        Route::get('/CR/ajout_categorie', 'ajout_categorie')->name('ajout_categorie');
        Route::get('/CR/ajout_sous_categorie', 'ajout_sous_categorie')->name('ajout_sous_categorie');
        Route::post('/CR/save_categorie', 'save_categorie')->name('save_categorie');
        Route::get('/get-subcategories/{categoryId}', 'getSubCategories');
        Route::post('/add_sous_domaine', 'save_subcategorie')->name('save_sous_categorie');
        // Routes pour Supprimer les sous categories
        Route::get('/delete-sous-categorie/{id}', 'delete_sous_categories')->name('delete_sous_categorie');
        Route::get('/list_categories', 'list_categorie')->name('liste_categories');

    });
    // ASSISTANT ROUTES


        Route::post('chat/send', [MessageController::class, 'send'])->name('sendmessage');
        
        Route::post('/mark-notifications-as-read', [MessageController::class, 'markAsRead']);

        Route::get('chat/messages', [MessageController::class, 'messages'])->name('readmessages_withoutId')->middleware(['auth']);

        Route::get('chat/messages/{id}', [MessageController::class, 'readmessages'])->name('readmessages')->middleware(['auth']);

        
        Route::get('chat/messages/gg', [MessageController::class, 'messages_2'])->name('sendmessage');
        
        Route::get('chat/receivemessages', [MessageController::class, 'receivemessages'])->name('receivemessages')->middleware(['auth']);


    Route::middleware(['auth', 'verified'])->controller(  AssistantController::class)->group(function () {

        Route::get('/assistant/complete', 'edit')->name('assistant.complete');

        Route::post('/assistant/complete', 'update')->name('assistant.complete');

    });
    


    // ADMIN ROUTES

    Route::middleware(['auth', 'verified', 'admin'])->controller(ControleurController::class)->group(function () {

        Route::get('/admin/liste_controleurs', 'list_controller')->name('admin.list_controleur');

        Route::get('/admin/validate_controleur', 'validate_controller')->name('admin.validate_controleur');

        Route::get('/admin/details_controleurs/{id}', 'show')->name('Show_controleur');

    });


    // SUPERADMIN ROUTES

    Route::middleware(['auth', 'verified', 'superadmin'])->controller(SuperAdminController::class)->group(function () {

        Route::get('/superadmin/liste_controleurs', 'list_controller')->name('superadmin.list_controleur');

        Route::get('/superadmin/validate_controleur', 'validate_controller')->name('superadmin.validate_controleur');

        Route::get('/superadmin/details_controleurs/{id}', 'show')->name('superadminShow_controleur');

        Route::get('/superadmin//student/exam/{id}', 'exam_rapport')->name('superadmin.exam_rapport');

        Route::get('/superadmin/stagiaire/history_rapport/{id}', 'rapport_history')->name('superadmin.rapport_history');

        Route::get('/superadmin/stagiaire/recap/{id}', 'stagiaire_recap')->name('superadmin.stagiaire_recap');

        Route::get('/superadmin/stagiaires/recap', 'stagiaires_recap')->name('superadmin.stagiaires_recap');

        Route::get('/superadmin/liste_stagiaires', 'list_stagiaires')->name('superadmin.liste_stagiaires');

        Route::get('/superadmin/valider_stagiaire/{matricule}', 'show_stagiaire')->name('superadmin.show_stagiaire');

        Route::post('/superadmin/valider', 'validate_stagiaire')->name('superadmin.validate_stagiaire');
    });

Route::get('/Profile', function () {
    return view('auth.profile');
})->middleware(['auth', 'verified'])->name('Profile');
});
Route::get('/messages/{id?}', [MessageController::class, 'messages_2'])->name('messages.controleur');

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