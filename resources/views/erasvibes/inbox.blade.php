@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/estilos.css'])

<div class="container-fluid">
    <div class="row">
        <!--Lista de contactos -->
        <div class="col-md-4 border-end bg-white vh-100 overflow-auto">
            @isset($recipient)
            <div class="pt-3 ps-3">
                <a href="{{ route('messages.index') }}" 
                   class="btn btn-warning px-3 py-1 rounded-pill shadow-sm" title="Volver a mensajes">
                    &#x2190; Volver
                </a>
            </div>
            @endisset

            <h5 class="p-3">Mensajes</h5>

            <div id="friend-list">
                @foreach ($friends as $friend)
                    @if ($friend->last_message)
                        <div class="d-flex align-items-center justify-content-between border-bottom px-3 py-2 friend-item {{ $friend->unread_count > 0 ? 'bg-light' : '' }}">
                            <a href="{{ route('messages.show', $friend->id) }}" class="d-flex align-items-center text-decoration-none text-dark flex-grow-1">
                                <img src="{{ $friend->profile_picture ? asset('storage/' . $friend->profile_picture) : asset('img/default-profile.png') }}"
                                    onerror="this.onerror=null; this.src='{{ asset('img/default-profile.png') }}';"
                                    class="rounded-circle me-2" width="40" height="40" alt="Avatar del receptor">
                                <div class="d-flex flex-column">
                                    <strong class="friend-name {{ $friend->unread_count > 0 ? 'fw-bold' : '' }}">
                                        {{ $friend->name }} {{ $friend->last_name }}
                                        @if ($friend->unread_count > 0)
                                            <span class="text-primary ms-1">●</span>
                                        @endif
                                    </strong>
                                    <small class="text-muted">{{ $friend->last_message }}</small>
                                </div>
                            </a>
                            <div class="d-flex flex-column align-items-end ms-2">
                                @if ($friend->last_message_time)
                                    <small class="text-muted">{{ $friend->last_message_time }}</small>
                                @endif
                                <form action="{{ route('messages.destroy', $friend->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link p-0 mt-1"
                                        title="Eliminar conversación"
                                        onclick="return confirm('¿Estás seguro de eliminar esta conversación?')">
                                        <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/trash.svg" alt="Eliminar" width="20" height="20">
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Área de mensajes -->
        <div class="col-md-8 vh-100 d-flex flex-column">
            @isset($recipient)
            <div class="border-bottom p-3 bg-light d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="{{ $recipient->profile_picture ? asset('storage/' . $recipient->profile_picture) : asset('img/default-profile.png') }}"
                        class="rounded-circle me-2" width="40" height="40" alt="Avatar del receptor">
                    <strong class="mb-0">{{ $recipient->name }} {{ $recipient->last_name }}</strong>
                </div>
            </div>

            <div class="flex-grow-1 overflow-auto p-3" style="background: #f0f0f0;">
                @php $currentDate = null; @endphp
                @foreach ($messages as $message)
                    @php
                        $msgDate = $message->created_at->timezone('Atlantic/Canary')->format('d/m/Y');
                    @endphp

                    @if ($msgDate !== $currentDate)
                        <div class="text-center text-muted my-2" style="font-size: 12px;">
                            {{ ucfirst($message->created_at->locale('es')->translatedFormat('l, d \d\e F Y')) }}
                        </div>
                        @php $currentDate = $msgDate; @endphp
                    @endif

                    <div class="mb-2 d-flex {{ $message->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <div style="max-width: 70%;">
                            <div class="p-2 rounded position-relative"
                                style="{{ $message->sender_id === auth()->id() ? 'background-color: #dcf8c6;' : 'background-color: #fff;' }}; border: 1px solid #ddd;">
                                <div>{{ $message->body }}</div>
                                <div class="text-end mt-1">
                                    <small class="text-muted" style="font-size: 10px;">
                                        {{ $message->created_at->timezone('Atlantic/Canary')->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <form method="POST" action="{{ route('messages.store', $recipient->id) }}" class="border-top p-3 bg-white">
                @csrf
                <div class="d-flex">
                    <input type="text" name="message" class="form-control me-2" placeholder="Escribe tu mensaje..." required>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
            @else
            <div class="d-flex justify-content-center align-items-center h-100">
                <p>Selecciona un chat para comenzar</p>
            </div>
            @endisset
        </div>
    </div>
</div>

@endsection
