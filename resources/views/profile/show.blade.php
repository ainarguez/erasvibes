@extends('layouts.app')

@section('content')

@include('partials.navbar')

@if(session('success'))
    <div class="position-fixed top-50 start-50 translate-middle alert alert-warning text-center shadow rounded p-4"  style="z-index: 9999; min-width: 300px;">
        {{ session('success') }}
    </div>

<script>
    setTimeout(() => {
        document.querySelector('.alert').remove();
    }, 3000); 
</script>
@endif


<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <!-- Contenido central -->
    <div class="container mt-5">
        <h2 class="mb-4">Perfil de {{ $user->name }}</h2>

        <!-- Foto de perfil -->
        <div class="text-center mb-4">
            @if ($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto de perfil" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            @else
                <img src="{{ asset('img/default-profile.png') }}" alt="Foto de perfil predeterminada" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            @endif
        </div>

        <ul class="list-group">
            <li class="list-group-item"><strong>Nombre:</strong> {{ $user->name }}</li>
            <li class="list-group-item"><strong>Apellidos:</strong> {{ $user->last_name }}</li>
            <li class="list-group-item"><strong>Edad:</strong> {{ $user->age ?? 'No especificada' }}</li>
            <li class="list-group-item"><strong>Estudio:</strong> {{ $user->field_of_study }}</li>
            <li class="list-group-item"><strong>Destino Erasmus:</strong> {{ $user->erasmus_destination ?? 'No especificado' }}</li>
            <li class="list-group-item"><strong>Fecha de llegada:</strong> {{ $user->arrival_date ?? 'No especificada' }}</li>
            <li class="list-group-item"><strong>Fecha de finalización:</strong> {{ $user->end_date ?? 'No especificada' }}</li>
            <li class="list-group-item"><strong>Descripción:</strong> {{ $user->description ?? 'No proporcionada' }}</li>
        </ul>

        @auth
            @if (auth()->id() === $user->id)
                <a href="{{ route('profile.edit') }}" class="btn btn-warning mt-3">Editar perfil</a>
            @endif
        @endauth
        @auth
        @if(auth()->user()->isFriendWith($user))
            <form action="{{ route('friends.reject', $user->friendRequestBetween(auth()->user())) }}" method="POST" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar a este amigo?')">
                    Eliminar amigo
                </button>
            </form>
        @endif
    @endauth

    </div>
</div>
@endsection
