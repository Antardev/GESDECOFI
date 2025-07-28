<?php

namespace App\Http\Controllers;

use App\Models\Controleurs;
use App\Models\ExistingMessage;
use App\Models\Message;
use App\Models\Stagiaire;
use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use App\Notifications\MessageReceived;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        // Validation des données d'entrée
        $request->validate([
            'message' => 'required|string|min:1',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $user = auth()->user();
        $stagiaire = Stagiaire::where('user_id', $user->id)->first();
        
        if ($stagiaire) {
            $controleur = Controleurs::where('country_contr', $stagiaire->country)->first();
            if (!$controleur) {
                return response()->json(['error' => 'Contrôleur non trouvé'], 404);
            }
            
            $user_id = $controleur->user_id; // receiver id
            $user_name = $controleur->name;  // receiver name
            $user0_id = $stagiaire->user_id;  // sender id
            $user0_name = $stagiaire->name;   // sender name
            $ident = 'S' . auth()->id() . 'C' . $user_id;
        } else {
            $controleur = Controleurs::where('user_id', $user->id)->first();
            if (!$controleur) {
                return response()->json(['error' => 'Contrôleur non trouvé'], 404);
            }

            $receiver = User::find($request->receiver_id);
            $stagiaire = Stagiaire::where('user_id', $receiver->id)->first();
            
            if ($stagiaire) {
                if ($controleur->country_contr === $stagiaire->country) {
                    $user_id = $receiver->id; // receiver id
                    $user_name = $stagiaire->name; // receiver name
                    $user0_id = $controleur->user_id; // sender id
                    $user0_name = $controleur->name; // sender name
                    // $user0_id = $stagiaire->user_id; // sender id
                    // $user0_name = $controleur->name; // sender name

                    $ident = 'S' . $receiver->id . 'C' . auth()->id();
                } else {
                    return response()->json(['error' => 'Les pays ne correspondent pas'], 400);
                }
            } else {
                return response()->json(['error' => 'Stagiaire introuvable'], 404);
            }
        }

        // Enregistrement message
        $message = new Message();
        $message->sender_id = $user->id;
        $message->receiver_id = $user_id;
        $message->content = $request->message;
        $message->save();

        // Enregistrement message utilisateur
        $user_message = new UserMessage();
        $user_message->ident = $ident;
        $user_message->sender_id = $user->id;
        $user_message->receiver_id = $user_id;
        $user_message->content = $request->message;
        $user_message->save();
        // Notification
        // $user->notify(new \App\Notifications\MessageReceived($message));
        $user_to_notify = User::where('id', $user_id)->first();
        $user_to_notify->notify(new MessageReceived($message));

        // Mise à jour des messages existants
        $this->updateExistingMessage($user0_id, $user0_name, $user_id, $user_name, $request->message);
        // dd($user_to_notify);
        return response()->json(['success' => 'Message envoyé avec succès'], 200);
    }

    private function updateExistingMessage($sender_id, $sender_name, $receiver_id, $receiver_name, $message_content)
    {
        // Supprimer message existant pour l'expéditeur
        ExistingMessage::where('user_id', $sender_id)->where('other_id', $receiver_id)->delete();

        // Enregistrer nouveau message expéditeur
        $existing_message = new ExistingMessage();
        $existing_message->user_id = $sender_id;
        $existing_message->user_name = $receiver_name;
        $existing_message->other_id = $receiver_id;
        $existing_message->content = truncateParagraph($message_content, 32);
        $existing_message->save();

        // Supprimer  message existant 
        ExistingMessage::where('user_id', $receiver_id)->where('other_id', $sender_id)->delete();

        // Enregistrer nouveau message pour destinataire
        $existing_message = new ExistingMessage();
        $existing_message->user_id = $receiver_id;
        $existing_message->user_name = $sender_name;
        $existing_message->other_id = $sender_id;
        $existing_message->content = truncateParagraph($message_content, 32);
        $existing_message->save();
    }

    public function readmessages($id)
    {

        $user = auth()->user();
        $Controleur = Controleurs::where('user_id', $user->id)->first();
        $stagiaire = Stagiaire::where('user_id', $id)->first();
        if($stagiaire)
        {
            $user_messages = UserMessage::where('ident', 'S'.$stagiaire->user_id.'C'.$user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
            
            return $user_messages;
        } else {
            return 'error';
        }

    }

    public function messages()
    {

        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();
        if($stagiaire)
        {
            $Controleur = Controleurs::where('country_contr', $stagiaire->country)->first();
            // dd($Controleur);
            $user_messages = UserMessage::where('ident', 'S'.auth()->id().'C'.$Controleur->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

            return $user_messages;
        }else {
            return 'error';
        }

    }

    public function receivemessages(){
           // Vérifie que l'utilisateur est bien un contrôleur
        $controleur = Controleurs::where('user_id', auth()->id())->firstOrFail();

        // Récupère les messages paginés
        $messages = ExistingMessage::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        
        $my_id = auth()->id();
            
        return view('controleur.chat', compact('messages','my_id'));
    
    }

    public function markAsRead(Request $request)
{
    $request->user()->unreadNotifications()->update(['read_at' => now()]);
    
    return response()->json(['success' => true]);
}


}
