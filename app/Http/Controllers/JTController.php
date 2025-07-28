<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JTController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'jt_name' => 'required|string|max:255',
            'jt_description' => 'required|string|max:1000',
            'jt_date' => 'required|date',
            'jt_location' => 'required|string|max:255',
            'jt_rapport'=>'nullable|mimes:pdf,docx',

        ]);

    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {


    }

    /**
     * Display the specified resource.
     */
    public function show($matricule)
    {

    }


}
