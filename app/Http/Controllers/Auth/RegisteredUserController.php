<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
            'field_of_study' => ['required', 'string', 'max:255'],
            'erasmus_destination' => ['nullable', 'string', 'max:255'],
            'arrival_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:arrival_date'],
            'description' => ['nullable', 'string'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Guardar imagen de perfil si se sube una
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'birthdate' => $request->birthdate,
            'field_of_study' => $request->field_of_study,
            'erasmus_destination' => $request->erasmus_destination,
            'arrival_date' => $request->arrival_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'profile_picture' => $profilePicturePath,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}
