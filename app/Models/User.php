<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'birthdate',
        'field_of_study',
        'erasmus_destination',
        'arrival_date',
        'end_date',
        'description',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAgeAttribute()
    {
        return $this->birthdate ? Carbon::parse($this->birthdate)->age : null; // calcula la edad
    }

    public function sentRequests()
    {
        return $this->hasMany(FriendRequest::class, 'sender_id'); // obtiene las solicitudes enviadas
    }

    public function receivedRequests()
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id'); // obtiene las solicitudes recibidas
    }

    // obtiene los amigos aceptados
    public function getFriends()
    {
        $friendIds = FriendRequest::where('status', 'accepted')
            ->where(function ($query) {
                $query->where('sender_id', $this->id)
                      ->orWhere('receiver_id', $this->id);
            })
            ->get()
            ->map(function ($friendship) {
                return $friendship->sender_id == $this->id
                    ? $friendship->receiver_id
                    : $friendship->sender_id;
            });

        return self::whereIn('id', $friendIds)->get(); 
    }

    // verifica si es amigo de otro usuario
    public function isFriendWith(User $user)
    {
        return FriendRequest::where(function ($query) use ($user) {
            $query->where('sender_id', $this->id)
                  ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $this->id);
        })->where('status', 'accepted')->exists(); 
    }

    public function friendsWithMessages()
    {
        $authId = $this->id; 

        $friends = User::whereHas('receivedMessages', function ($query) use ($authId) {
            $query->where('sender_id', $authId);
        })->orWhereHas('sentMessages', function ($query) use ($authId) {
            $query->where('receiver_id', $authId); // amigos con mensajes enviados o recibidos
        })->get();

        foreach ($friends as $friend) {
            $lastMessage = \App\Models\Message::where(function ($query) use ($authId, $friend) {
                $query->where('sender_id', $authId)->where('receiver_id', $friend->id); // mensaje enviado
            })->orWhere(function ($query) use ($authId, $friend) {
                $query->where('sender_id', $friend->id)->where('receiver_id', $authId); // mensaje recibido
            })->latest()->first(); // obtenemos el último mensaje

            $friend->last_message = $lastMessage ? $lastMessage->body : null; // último mensaje
            $friend->last_message_time = $lastMessage ? $lastMessage->created_at->diffForHumans() : null; // hora del último mensaje
        }

        return $friends;
    }

    public function sentMessages()
    {
        return $this->hasMany(\App\Models\Message::class, 'sender_id'); // mensajes enviados por el usuario
    }

    public function receivedMessages()
    {
        return $this->hasMany(\App\Models\Message::class, 'receiver_id'); // mensajes recibidos por el usuario
    }

    // verifica si ya envió una solicitud a otro usuario
    public function hasSentRequestTo(User $user)
    {
        return FriendRequest::where('sender_id', $this->id)
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->exists(); 
    }

    // verifica si recibió una solicitud pendiente
    public function hasSentRequestFrom(User $user)
    {
        return FriendRequest::where('sender_id', $user->id)
            ->where('receiver_id', $this->id)
            ->where('status', 'pending')
            ->exists(); 
    }

    // obtiene los amigos aceptados
    public function friends()
    {
        $sent = FriendRequest::where('sender_id', $this->id)
                    ->where('status', 'accepted')
                    ->pluck('receiver_id');

        $received = FriendRequest::where('receiver_id', $this->id)
                    ->where('status', 'accepted')
                    ->pluck('sender_id');

        $friendIds = $sent->merge($received); // combina los ids de ambos

        return User::whereIn('id', $friendIds)->get();
    }

}
