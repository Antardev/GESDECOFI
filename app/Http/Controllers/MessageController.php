<?php

namespace App\Http\Controllers;

use App\Models\Controleurs;
use App\Models\ExistingMessage;
use App\Models\Message;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        // dd($request);
        $request->validate([
            'message' => 'required|string|min:1',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $user = auth()->user();

        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();
        if($stagiaire)
        {
            $Controleurs = Controleurs::where('country_contr', $stagiaire->country)->first();
            $user_id = $Controleurs->id;
            $ident = 'S'.auth()->id().'C'.$Controleurs->user_id;
        }else {
            $Controleurs = Controleurs::where('user_id', $user->id)->first();
            if($Controleurs)
            {
                $user1 = User::where('id', $request->receiver_id)->first();
                $stagiaire = Stagiaire::where('user_id', $user1->id)->first();
                if($Controleurs->country_contr = $stagiaire->country)
                {
                    $user_id = $user1->id;
                    $ident = 'S'.$user1->id.'C'.auth()->id();
                }
                else{
                    return 'errior';
                }
            }else
            {
                    return 'errior';
            }
        }

        $message = new Message();
        $message->sender_id = $user->id;
        $message->receiver_id = $user_id;
        $message->content = $request->message;

        $message->save();

        $user_message = new UserMessage();
        $user_message->ident = $ident;
        $user_message->sender_id = $user->id;
        $user_message->receiver_id = $user_id;
        $user_message->content = $request->message;

        $user_message->save();

        $existing_message = new ExistingMessage();

        $existing_message->user_id = $user->id;

    }

    public function messages()
    {

        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();
        if($stagiaire)
        {
            $Controleur = Controleurs::where('country_contr', $stagiaire->country)->first();
            // dd($Controleur);
            $user_messages = UserMessage::where('ident', 'S'.auth()->id().'C'.$Controleur->user_id)->get();

            return $user_messages;
        }else {
            return 'error';
        }


    }

    public function messages_2(?int $id)
    {

        $user = auth()->user();
        $Controleur = Controleurs::where('user_id', $user->id)->first();
        $stagiaire = Stagiaire::where('user_id', $id)->first();
        if($stagiaire)
        {
            $user_messages = UserMessage::where('ident', 'S'.$stagiaire->user_id.'C'.$user->id)->get();
            
            return $user_messages;
        } else {
            return 'error';
        }

    }
}
