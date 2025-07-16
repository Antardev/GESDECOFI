<?php

namespace App\Http\Controllers;

use App\Models\ControleurAssistant;
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    public function edit()
    {
        return view('assistant.complete_information');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required|string|min:3|max:100',
            'first_name'=>'required|string|min:3|max:100',
            'phone'=>'required|string|min:6|max:100',
            'country'=>'required|string|min:3|max:100',
            'city'=>'required|string|min:3|max:100',
            'birth_date'=>'required|date',
            'hire_date'=>'required|date',
            'cnss_number'=>'required|string|min:4,max:100',
            'diploma'=>'required|mimes:pdf,png,jpg,jpeg',
            'photo'=>'required|mimes:png,jpg,jpeg',
            'password'=>'required|string|min:8|confirmed',
        ]);

        $assistant = ControleurAssistant::where('user_id', auth()->id())->first();

        $assistant->first_name = $request->first_name;
        $assistant->name = $request->name;
        $assistant->phone = $request->phone;
        $assistant->city = $request->city;
        $assistant->country = $request->country;
        $assistant->hire_date = $request->hire_date;
        $assistant->cnss_number = $request->cnss_number;
        $assistant->birth_date = $request->birth_date;
        $assistant->picture_path =  $request->file('photo') ? $request->file('photo')->store('pictures', 'public') : null;
        $assistant->diploma =  $request->file('diploma') ? $request->file('diploma')->store('diplomes', 'public') : null;

        $assistant->save();

        return redirect()->route('home');
    }
    public function create()
    {
        //
    }
}
