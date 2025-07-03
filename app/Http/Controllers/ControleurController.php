<?php

namespace App\Http\Controllers;
use App\Models\Controleurs;
use App\Models\User;
use Illuminate\Http\Request;

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
            'country' => 'required|string|max:255',
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
    public function show(Controleurs $controleur)
    {
        //
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
