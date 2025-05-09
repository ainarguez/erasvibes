@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
@include('partials.navbar')

<div class="container py-4">

    <div class="mb-4">
        <h2 class="fw-bold">Amigos</h2>
        <p class="text-muted">Tienes {{ $friends->count() }} amigos</p>
    </div>

    <!-- Lista de amigos -->
    <div class="row g-4 mb-5">
        @forelse($friends as $friend)
            <div class="col-12 col-sm-6 col-md-4">
                <a href="{{ route('profile.view', $friend->id) }}" class="text-decoration-none text-dark">
                    <div class="card p-3 rounded shadow-sm border-0 h-100 hover-shadow">
                        <div class="d-flex align-items-center">
                            <img src="{{ $friend->profile_picture ? asset('storage/' . $friend->profile_picture) : asset('img/default-profile.png') }}" alt="Foto de perfil" class="rounded-circle me-3" width="60" height="60">

                            <div class="flex-grow-1">
                                <h5 class="mb-0">{{ $friend->name }} {{ $friend->last_name }}</h5>
                                <small class="d-block text-muted">
                                    <i class="fas fa-graduation-cap"></i> {{ $friend->field_of_study ?? 'Sin estudios' }}
                                </small>
                                <small class="d-block text-muted">
                                    <i class="fas fa-plane-departure"></i> {{ $friend->erasmus_destination ?? 'Sin destino' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-muted">No tienes amigos aún.</p>
        @endforelse
    </div>

    <!-- Solicitudes de amistad recibidas -->
    <div class="mb-4">
        <h4 class="fw-bold">Solicitudes de amistad</h4>
        @forelse($receivedRequests as $request)
            <div class="d-flex align-items-center justify-content-between p-3 border rounded mb-2">
                <div class="d-flex align-items-center">
                    <img src="{{ $request->sender->profile_picture ? asset('storage/' . $request->sender->profile_picture) : asset('img/default-profile.png') }}" alt="Foto de perfil" class="rounded-circle me-3" width="50" height="50">
                    <strong>{{ $request->sender->name }} {{ $request->sender->last_name }}</strong>
                </div>
                <div class="d-flex gap-2">
                    <form action="{{ route('friends.accept', $request) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success btn-sm">Aceptar</button>
                    </form>

                    <form action="{{ route('friends.reject', $request) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Rechazar</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-muted">No tienes solicitudes nuevas.</p>
        @endforelse
    </div>

</div>
@endsection
