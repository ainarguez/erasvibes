@extends('layouts.app')

@section('content')

@include('partials.navbar')

<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

<div class="container py-4">
    <h2 class="mb-4 text-xl font-semibold">Mensajes</h2>

    <input type="text" id="searchInput" placeholder="Buscar por nombre..." class="form-control mb-3" onkeyup="filterChats()">

    <div class="row" id="activeChats">
        @forelse ($friendsWithMessages as $friend)
            <div class="col-md-6 mb-3 chat-item">
                <a href="{{ route('messages.show', $friend->id) }}" class="text-decoration-none">
                    <div class="card shadow-sm {{ $friend->unread_count > 0 ? 'bg-light' : '' }}">
                        <div class="card-body d-flex align-items-center">
                            <img src="{{ $friend->profile_picture ? asset('storage/' . $friend->profile_picture) : asset('img/default-profile.png') }}"  alt="Foto de perfil"  class="rounded-circle me-3"  width="50" height="50">
                            <div>
                                <strong class="text-dark {{ $friend->unread_count > 0 ? 'fw-bold' : '' }}">
                                    {{ $friend->name }} {{ $friend->last_name }}
                                    @if($friend->unread_count > 0)
                                        <span class="text-primary ms-2">●</span>
                                    @endif
                                </strong>
                                <div class="text-muted small">{{ $friend->last_message }}</div>
                            </div>
                            <div class="ms-auto text-muted small">
                                {{ \Carbon\Carbon::parse($friend->last_message_time)->locale('es')->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="card card-body">No tienes ningún chat todavía.</div>
            </div>
        @endforelse
    </div>

    <!-- Sugerencias -->
    <h5 class="mb-2">Sugerencias</h5>
    <div class="row" id="suggestedChats">
        @forelse ($suggestedFriends as $friend)
            <div class="col-md-6 mb-3 chat-item">
                <a href="{{ route('messages.show', $friend->id) }}" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <img src="{{ $friend->profile_picture ? asset('storage/' . $friend->profile_picture) : asset('img/default-profile.png') }}" alt="Foto de perfil"  class="rounded-circle me-3"  width="50" height="50">
                            <strong class="text-dark">{{ $friend->name }} {{ $friend->last_name }}</strong>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="card card-body">No hay sugerencias disponibles.</div>
            </div>
        @endforelse
    </div>

    <script src="{{ asset('js/messages.js') }}"></script>
    
@endsection
