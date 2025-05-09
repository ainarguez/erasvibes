<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user(); 
        return view('profile.edit', compact('user')); 
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'field_of_study' => 'nullable|string|max:255',
            'erasmus_destination' => 'nullable|string|max:255',
            'arrival_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:arrival_date',
            'description' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->birthdate = $request->birthdate;
        $user->field_of_study = $request->field_of_study;
        $user->erasmus_destination = $request->erasmus_destination;
        $user->arrival_date = $request->arrival_date;
        $user->end_date = $request->end_date;
        $user->description = $request->description;

        $user->save(); 

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete(); 

        $request->session()->invalidate(); // invalida la sesión
        $request->session()->regenerateToken(); // regenera el token de la sesión

        return Redirect::to('/'); 
    }

    public function index()
    {
        return view('erasvibes.index');
    }

    public function showMap(Request $request)
    {
        $place = $request->input('place');
        $arrivalDate = $request->input('arrival_date');
        $endDate = $request->input('end_date');

        // validamos que "place" solo tenga letras, espacios y guiones
        if (!preg_match('/^[\pL\s\-]+$/u', $place)) {
            return view('erasvibes.map', [
                'message' => 'Introduce solo el nombre de una ciudad o pueblo.',
                'users' => collect(), // devolvemos una colección vacía si no es válido
            ]);
        }

        // validamos las fechas
        if ($arrivalDate && $endDate && $endDate <= $arrivalDate) {
            return view('erasvibes.map', [
                'message' => 'La fecha de vuelta debe ser posterior a la de llegada.',
                'place' => $place,
                'users' => null
            ]);
        }

        // buscamos usuarios con el destino de Erasmus y las fechas correctas
        $users = User::where('erasmus_destination', 'LIKE', '%' . $place . '%')
            ->where('arrival_date', '<=', $endDate)
            ->where('end_date', '>=', $arrivalDate)
            ->where('id', '!=', auth()->id()) // no mostramos al usuario osea a ti mismo
            ->get();

        return view('erasvibes.map', compact('users', 'place')); 
    }

    // mostramos el perfil de un usuario
    public function show()
    {
        $user = auth()->user();

        if (!$user) {
            abort(404, 'Usuario no encontrado'); 
        }

        return view('profile.show', compact('user')); 
    }

    // el perfil de otro usuario
    public function view(User $user)
    {
        return view('profile.show', compact('user'));
    }

    // buscamos usuarios por destino de Erasmus y fechas
    public function search(Request $request)
    {
        $query = User::query(); // iniciamos la consulta

        if ($request->filled('erasmus_destination')) {
            $query->where('erasmus_destination', $request->input('erasmus_destination'));
        }

        if ($request->filled('arrival_date') && $request->filled('end_date')) {
            $query->where('arrival_date', '<=', $request->input('end_date'))
                ->where('end_date', '>=', $request->input('arrival_date'));
        }

        $users = $query->get(); // obtenemos los usuarios filtrados

        if ($users->isEmpty()) {
            return view('erasvibes.index', ['message' => 'No hay personas de Erasmus en esas fechas.']);
        }

        return view('erasvibes.index', compact('users')); // devolvemos los usuarios encontrados
    }
}
