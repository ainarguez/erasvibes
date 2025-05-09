<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    // Lista de chats (con mensajes))
    public function index()
    {
        $user = auth()->user(); 

        $friendsWithMessages = $user->friendsWithMessages();

        // agrega datos como el ultimo mensaje y los mensajes no leidos a cada amigo
        $friendsWithMessages = $friendsWithMessages->map(function ($friend) use ($user) {
            // obtener el último mensaje 
            $lastMessage = Message::where(function ($query) use ($user, $friend) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $friend->id);
            })->orWhere(function ($query) use ($user, $friend) {
                $query->where('sender_id', $friend->id)
                      ->where('receiver_id', $user->id);
            })->orderByDesc('created_at')->first(); 

            $friend->last_message = $lastMessage?->body ?? ''; // si no hay mensaje, dejarlo vacio
            $friend->last_message_time = $lastMessage?->created_at ?? ''; // tiempo del ultimo mensaje
            // Contar los mensajes no leídos por el usuario del amigo
            $friend->unread_count = Message::where('sender_id', $friend->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false) // solo mensajes no leídos
                ->count();

            return $friend;
        });

        // obtener amigos que no tienen chat aun
        $messagedIds = $friendsWithMessages->pluck('id')->toArray(); 
        $suggestedFriends = $user->friends()->filter(function ($friend) use ($messagedIds) {
            return !in_array($friend->id, $messagedIds); 
        });

        return view('erasvibes.messages', compact('friendsWithMessages', 'suggestedFriends'));
    }

    // eliminar una conversación
    public function destroy(User $user)
    {
        $authId = auth()->id();

        Message::where(function ($query) use ($authId, $user) {
            $query->where('sender_id', $authId)->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($authId, $user) {
            $query->where('sender_id', $user->id)->where('receiver_id', $authId);
        })->delete(); 

        return redirect()->route('messages.index')->with('success', 'Conversación eliminada.');
    }

    // muestra mensajes entre dos usuarios
    public function show(User $user)
    {
        $authId = auth()->id(); 

        // marca los mensajes como leídos
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $authId)
            ->where('is_read', false)
            ->update(['is_read' => true])
        ; 
        // conseguir todos los mensajes 
        $messages = Message::where(function($query) use ($authId, $user) {
            $query->where('sender_id', $authId)
                  ->where('receiver_id', $user->id);
        })->orWhere(function($query) use ($authId, $user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $authId);
        })->orderBy('created_at')->get(); 

        //  amigos aceptados
        $friends = User::whereIn('id', function ($query) use ($authId) {
            $query->select(DB::raw('IF(sender_id = '.$authId.', receiver_id, sender_id)'))
                ->from('friend_requests')
                ->where(function ($q) use ($authId) {
                    $q->where('sender_id', $authId)->orWhere('receiver_id', $authId);
                })
                ->where('status', 'accepted'); 
        })->get();

        // agrega info sobre el ultimo mensaje y los mensajes no leidos a los amigos
        $friends = $friends->map(function ($friend) use ($authId) {
            // obtener el ulltimo mensaje entre el usuario y el amigo
            $lastMessage = Message::where(function ($query) use ($authId, $friend) {
                $query->where('sender_id', $authId)
                      ->where('receiver_id', $friend->id);
            })->orWhere(function ($query) use ($authId, $friend) {
                $query->where('sender_id', $friend->id)
                      ->where('receiver_id', $authId);
            })->orderByDesc('created_at')->first(); // ultimo mensaje

            $friend->last_message = $lastMessage?->body ?? ''; // ultimo mensaje
            $friend->last_message_time = $lastMessage?->created_at?->format('H:i') ?? ''; // hora del ultimo mensaje
            $friend->unread_count = Message::where('sender_id', $friend->id)
                ->where('receiver_id', $authId)
                ->where('is_read', false) // mensajes no leidos
                ->count();

            return $friend;
        });

        // si el destinatario no está en la lista de amigoslo agrega
        if (!$friends->pluck('id')->contains($user->id)) {
            // agregar el destinatario a la lista de amigos
            $lastMessage = Message::where(function ($query) use ($authId, $user) {
                $query->where('sender_id', $authId)
                      ->where('receiver_id', $user->id);
            })->orWhere(function ($query) use ($authId, $user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $authId);
            })->orderByDesc('created_at')->first();

            $user->last_message = $lastMessage?->body ?? ''; // Último mensaje del destinatario
            $user->last_message_time = $lastMessage?->created_at?->format('H:i') ?? ''; 
            $user->unread_count = 0; // no tiene mensajes no leidos
            $friends->push($user); // agregar al destinatario
        }

        // Obtener amigos sugeridos (aquellos con los que aún no se han enviado mensajes)
        $authUser = auth()->user();
        $friendsWithMessages = $authUser->friendsWithMessages();
        $messagedIds = $friendsWithMessages->pluck('id')->toArray(); // amigos con mensajes
        $suggestedFriends = $authUser->friends()->filter(function ($friend) use ($messagedIds) {
            return !in_array($friend->id, $messagedIds); // filtrar amigos sin mensajes 
        });

        return view('erasvibes.inbox', [
            'recipient' => $user, // destinatario de los mensajes
            'messages' => $messages, 
            'friends' => $friends, 
            'friendsWithMessages' => $friendsWithMessages, // amigos con mensajes
            'suggestedFriends' => $suggestedFriends, // amigos sugeridos
        ]);
    }

    // Crear un nuevo mensaje
    public function create(User $recipient)
    {
        $authId = auth()->id(); 

        // coge mensajes previos entre el usuario autenticado y el destinatario
        $messages = Message::where(function($query) use ($authId, $recipient) {
            $query->where('sender_id', $authId)
                  ->where('receiver_id', $recipient->id);
        })->orWhere(function($query) use ($authId, $recipient) {
            $query->where('sender_id', $recipient->id)
                  ->where('receiver_id', $authId);
        })->orderBy('created_at')->get();

        // coge amigo aceptado
        $friends = User::whereIn('id', function ($query) use ($authId) {
            $query->select(DB::raw('IF(sender_id = '.$authId.', receiver_id, sender_id)'))
                ->from('friend_requests')
                ->where(function ($q) use ($authId) {
                    $q->where('sender_id', $authId)->orWhere('receiver_id', $authId);
                })
                ->where('status', 'accepted'); // solo  aceptados
        })->get();

        // sgregar informacion sobre el iltimo mensaje y los mensajes no leídos a los amigos
        $friends = $friends->map(function ($friend) use ($authId) {
            // coger el ultimo mensaje entre el usuario y el amigo
            $lastMessage = Message::where(function ($query) use ($authId, $friend) {
                $query->where('sender_id', $authId)
                      ->where('receiver_id', $friend->id);
            })->orWhere(function ($query) use ($authId, $friend) {
                $query->where('sender_id', $friend->id)
                      ->where('receiver_id', $authId);
            })->orderByDesc('created_at')->first();

            $friend->last_message = $lastMessage?->body ?? ''; // ultimo mensaje
            $friend->last_message_time = $lastMessage?->created_at?->format('H:i') ?? ''; // ultima hora
            $friend->unread_count = Message::where('sender_id', $friend->id)
                ->where('receiver_id', $authId)
                ->where('is_read', false) 
                ->count();

            return $friend;
        });

        // si el destinatario no esta en la lista de amigo lo agregar
        if (!$friends->pluck('id')->contains($recipient->id)) {
            $lastMessage = Message::where(function ($query) use ($authId, $recipient) {
                $query->where('sender_id', $authId)
                      ->where('receiver_id', $recipient->id);
            })->orWhere(function ($query) use ($authId, $recipient) {
                $query->where('sender_id', $recipient->id)
                      ->where('receiver_id', $authId);
            })->orderByDesc('created_at')->first();

            $recipient->last_message = $lastMessage?->body ?? '';
            $recipient->last_message_time = $lastMessage?->created_at?->format('H:i') ?? '';
            $recipient->unread_count = 0;
            $friends->push($recipient); // Agregar al destinatario
        }

        return view('erasvibes.messages', [
            'recipient' => $recipient,
            'messages' => $messages,
            'friends' => $friends,
        ]);
    }

    // duarda un nuevo mensaje
    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string', 
        ]);

        // Crear un nuevo mensaje
        Message::create([
            'sender_id' => auth()->id(), 
            'receiver_id' => $user->id, 
            'body' => $request->message, 
            'is_read' => false, 
        ]);

        return redirect()->route('messages.show', $user->id); // redirigir a la conversación
    }
}
