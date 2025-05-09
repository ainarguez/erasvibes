@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
@include('partials.navbar')

<div class="container mt-4">
    <h2>Editar perfil de {{ Auth::user()->name }}</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- Mostrar imagen actual -->
        <div class="mb-3 text-center">
            @if ($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" class="rounded-circle mb-2" style="width: 120px; height: 120px; object-fit: cover;" alt="Foto actual">
            @else
                <img src="{{ asset('img/default-profile.png') }}" class="rounded-circle mb-2" style="width: 120px; height: 120px; object-fit: cover;" alt="Foto por defecto">
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Cambiar foto de perfil</label>
            <input type="file" name="profile_picture" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Apellidos</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de nacimiento</label>
            <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $user->birthdate ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Campo de estudio</label>
            <input type="text" name="field_of_study" class="form-control" value="{{ old('field_of_study', $user->field_of_study) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Destino Erasmus</label>
            <input type="text" name="erasmus_destination" class="form-control" value="{{ old('erasmus_destination', $user->erasmus_destination) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de llegada</label>
            <input type="date" name="arrival_date" class="form-control" value="{{ old('arrival_date', $user->arrival_date) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de finalización</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $user->end_date) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control">{{ old('description', $user->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">Guardar cambios</button>
        <a href="{{ route('perfil') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
