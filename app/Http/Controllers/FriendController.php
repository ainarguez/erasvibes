<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // el usuario autenticado

        $friends = $user->getFriends(); // los amigos del usuario

        // Solicitudes recibidas pendientes
        $receivedRequests = FriendRequest::where('receiver_id', $user->id)
                                        ->where('status', 'pending')
                                        ->with('sender')
                                        ->get();

        return view('erasvibes.friends', compact('friends', 'receivedRequests')); // mostrarlo a la vista
    }


    public function send($id)
    {
        $user = auth()->user();

        if ($user->id == $id) {
            return back()->with('error', 'No puedes enviarte una solicitud a ti mismo.'); 
        }

        // ver si ya existe una solicitud pendiente en ambos usuarios
        $exists = FriendRequest::where(function ($query) use ($user, $id) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($user, $id) {
            $query->where('sender_id', $id)
                  ->where('receiver_id', $user->id);
        })->where('status', 'pending')->exists();

        // ver si ya son amigos
        $alreadyFriends = FriendRequest::where(function ($query) use ($user, $id) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($user, $id) {
            $query->where('sender_id', $id)
                  ->where('receiver_id', $user->id);
        })->where('status', 'accepted')->exists();

        // ver si ya existe una solicitud o si ya son amigos
        if ($exists || $alreadyFriends) {
            return back()->with('error', 'Ya existe una solicitud o ya son amigos.');
        }

        // crea una nueva solicitud
        FriendRequest::create([
            'sender_id' => $user->id,
            'receiver_id' => $id,
            'status' => 'pending',
        ]);

        return back()->with('message', 'Solicitud enviada.');
    }

    public function accept(FriendRequest $request)
    {
        // ls solicitud sea de un usuario logueado
        if ($request->receiver_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        $request->update(['status' => 'accepted']);
        return back()->with('message', '¡Amigo añadido!');
    }
    public function friendRequestBetween(User $user)
    {
        return $this->receivedFriendRequests()
            ->where('sender_id', $user->id)
            ->orWhere(function($query) use ($user) {
                $query->where('receiver_id', $user->id)
                    ->where('sender_id', $this->id);
            })
            ->first();
    }


    public function reject(FriendRequest $request)
    {
        $userId = auth()->id();

        if ($request->receiver_id !== $userId && $request->sender_id !== $userId) {
            abort(403, 'No autorizado');
        }

        if ($request->status === 'accepted') {
            $request->delete(); // Elimina amistad existente
            return redirect()->back()->with('success', 'Amigo eliminado.');
        }

        $request->delete(); // Elimina solicitud pendiente
        return back()->with('message', 'Solicitud rechazada.');
    }

}
