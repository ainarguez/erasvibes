@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

<div class="container-fluid">
    
    @include('partials.navbar')

    @if (isset($message))
        <div class="d-flex justify-content-center align-items-center" style="height: 60vh;">
            <div class="alert alert-warning text-center">{{ $message }}</div>
        </div>
    @elseif(isset($users))
        <!-- Mapa -->
        <div id="map" class="mt-5" style="height: 500px;"></div>

        <!-- Contador -->
        <div class="text-muted mt-3">
            Se encontraron {{ $users->count() }} resultado(s).
        </div>

        <!-- Usuarios -->
        <div class="row mt-4">
            @foreach ($users as $user)
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-3 d-flex justify-content-center p-3">
                                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('img/default-profile.png') }}"
                                     class="img-fluid rounded-circle"
                                     style="width: 100px; height: 100px; object-fit: cover;" 
                                     alt="Foto de {{ $user->name }}">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $user->name }} {{ $user->last_name }}</h5>
                                    <p class="card-text"><strong>Estudia:</strong> {{ $user->field_of_study ?? 'No especificado' }}</p>
                                    <p class="card-text"><strong>Destino:</strong> {{ $user->erasmus_destination }}</p>
                                    <p class="card-text"><strong>Edad:</strong> {{ $user->age }}</p>
                                    <p class="card-text"><strong>Fechas:</strong> {{ $user->arrival_date }} - {{ $user->end_date }}</p>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex flex-column align-items-center p-3">
                                @auth
                                    @if($user->id !== auth()->id())
                                        @if($user->hasSentRequestFrom(auth()->user()))
                                            <button class="btn btn-secondary mb-2" disabled>Solicitud enviada</button>
                                        @elseif($user->isFriendWith(auth()->user()))
                                            <a href="{{ route('messages.show', $user->id) }}" class="btn btn-primary">Enviar mensaje</a>
                                        @else
                                            <form method="POST" action="{{ route('friends.send', $user->id) }}">
                                                @csrf
                                                <button type="submit" class="btn bg-warning mb-2">Enviar solicitud</button>
                                            </form>
                                        @endif
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn bg-warning mb-2">Enviar solicitud</a>
                                    <a href="{{ route('login') }}" class="btn btn-primary">Enviar mensaje</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <script id="map-data" type="application/json">@json(request('place'))</script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="{{ asset('js/map.js') }}"></script>
    @endif
</div>
@endsection
