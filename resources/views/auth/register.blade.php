<x-guest-layout>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">

        @csrf

        <!-- Nombre -->
        <div>
            <x-input-label for="name" :value="'Nombre'" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" pattern="^[A-Z][a-záéíóúñü]+(?: [A-Z][a-záéíóúñü]+)*$"
                title="Debe comenzar con mayúscula, sin números ni caracteres especiales" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Apellidos -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="'Apellidos'" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                :value="old('last_name')" required pattern=".{2,}"
                title="Debe tener al menos 2 caracteres" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Fecha de nacimiento -->
        <div class="mt-4">
            <x-input-label for="birthdate" :value="'Fecha de nacimiento'" />
            <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate')" />
            <span id="birthdateError" class="text-danger text-sm mt-1 d-block"></span>
            <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
        </div>

        <!-- Campo de estudio -->
        <div class="mt-4">
            <x-input-label for="field_of_study" :value="'Campo de estudio'" />
            <x-text-input id="field_of_study" class="block mt-1 w-full" type="text" name="field_of_study" :value="old('field_of_study')" required />
            <x-input-error :messages="$errors->get('field_of_study')" class="mt-2" />
        </div>

        <!-- Destino Erasmus -->
        <div class="mt-4">
            <x-input-label for="erasmus_destination" :value="'Destino Erasmus'" />
            <x-text-input id="erasmus_destination" class="block mt-1 w-full" type="text" name="erasmus_destination" :value="old('erasmus_destination')" />
            <x-input-error :messages="$errors->get('erasmus_destination')" class="mt-2" />
        </div>

        <!-- Fecha de llegada -->
        <div class="mt-4">
            <x-input-label for="arrival_date" :value="'Fecha de llegada'" />
            <x-text-input id="arrival_date" class="block mt-1 w-full" type="date" name="arrival_date" :value="old('arrival_date')" />
            <x-input-error :messages="$errors->get('arrival_date')" class="mt-2" />
        </div>

        <!-- Fecha de finalización -->
        <div class="mt-4">
            <x-input-label for="end_date" :value="'Fecha de finalización'" />
            <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" />
            <span id="dateError" class="text-danger text-sm mt-1 d-block"></span>
            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
        </div>

        <!-- Descripción -->
        <div class="mt-4">
            <x-input-label for="description" :value="'Descripción'" />
            <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Foto de perfil -->
        <div class="mt-4">
            <x-input-label for="profile_picture" :value="'Foto de perfil'" />
            <x-text-input id="profile_picture" class="block mt-1 w-full" type="file" name="profile_picture" accept="image/*" />
            <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
        </div>

        <!-- Correo electrónico -->
        <div class="mt-4">
            <x-input-label for="email" :value="'Correo electrónico'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autocomplete="username"
                pattern="^[^@]+@[^@]+\.[a-zA-Z]{2,3}$"
                title="Debe ser un correo válido: texto@dominio.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="'Contraseña'" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                required autocomplete="new-password"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                title="Mínimo 8 caracteres, una mayúscula, una minúscula y un número." />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar contraseña -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="'Confirmar contraseña'" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                ¿Ya estás registrado?
            </a>

            <x-primary-button class="ms-4">
                Registrarse
            </x-primary-button>
        </div>
    </form>

    <script src="{{ asset('js/register.js') }}"></script>

</x-guest-layout>
