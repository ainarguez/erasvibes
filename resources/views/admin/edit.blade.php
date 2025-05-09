@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Editar usuario</h2>

    <form method="POST" action="{{ route('admin.update', $user->id) }}" id="registerForm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input id="name" type="text" name="name" class="form-control" pattern="^[A-Z][a-záéíóúñü]+(?: [A-Z][a-záéíóúñü]+)*$" title="Debe comenzar con mayúscula y no contener números" required value="{{ old('name', $user->name) }}">
            <div id="nameError" class="text-danger small mt-1"></div>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Apellidos</label>
            <input id="last_name" type="text" name="last_name" class="form-control" pattern="^[A-Z][a-záéíóúñü]+(?: [A-Z][a-záéíóúñü]+)*$" title="Cada apellido debe comenzar con mayúscula y no contener números" required value="{{ old('last_name', $user->last_name) }}">
            <div id="last_nameError" class="text-danger small mt-1"></div>
        </div>

        <div class="mb-3">
            <label for="birthdate" class="form-label">Fecha de nacimiento</label>
            <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{ old('birthdate', $user->birthdate) }}">
            <div id="birthdateError" class="text-danger small mt-1"></div>
        </div>

        <div class="mb-3">
            <label for="field_of_study" class="form-label">Campo de estudio</label>
            <input type="text" name="field_of_study" id="field_of_study" class="form-control" value="{{ old('field_of_study', $user->field_of_study) }}" required>
        </div>

        <div class="mb-3">
            <label for="erasmus_destination" class="form-label">Destino Erasmus</label>
            <input type="text" name="erasmus_destination" id="erasmus_destination" class="form-control" pattern="^[A-Z][a-záéíóúñü]+(?: [A-Z][a-záéíóúñü]+)*$" title="Debe ser una ciudad, país o pueblo. Cada palabra debe comenzar con mayúscula." value="{{ old('erasmus_destination', $user->erasmus_destination) }}">
            <div id="erasmus_destinationError" class="text-danger small mt-1"></div>
        </div>

        <div class="mb-3">
            <label for="arrival_date" class="form-label">Fecha de llegada</label>
            <input type="date" name="arrival_date" id="arrival_date" class="form-control" value="{{ old('arrival_date', $user->arrival_date) }}">
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Fecha de finalización</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $user->end_date) }}">
            <div id="dateError" class="text-danger small mt-1"></div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $user->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control" pattern="^[^@]+@[^@]+\.[a-zA-Z]{2,3}$" title="Debe ser un correo válido: texto@dominio.com" value="{{ old('email', $user->email) }}" required>
            <div id="emailError" class="text-danger small mt-1"></div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="{{ asset('js/register.js') }}"></script>
@endsection
