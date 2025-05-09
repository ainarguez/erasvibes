<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class InboxController extends Controller
{
    // se muestra en la bandeja de entrada
    public function show($id)
    {
        $recipient = User::findOrFail($id); // si no se encuentra al destinatario, genera un error
        
        // obtenemos los amigos junto con los mensajes
        $friends = auth()->user()->friendsWithMessages(); 

        $messages = Message::where(function ($query) use ($id) {
            // enviados por el usuario al destinatario
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $id); 
        })->orWhere(function ($query) use ($id) {
            // enviados por el destinatario al usuario 
            $query->where('sender_id', $id)
                  ->where('receiver_id', auth()->id()); 
        })
        // ordenados por fecha
        ->orderBy('created_at')
        ->get();

        return view('erasvibes.inbox', compact('recipient', 'friends', 'messages'));
    }
}
