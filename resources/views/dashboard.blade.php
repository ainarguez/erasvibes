@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Barra superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <x-application-logo class="block h-7 w-auto fill-current text-gray-800" />
            <a class="navbar-brand" href="#">Erasmus</a>
            <div class="d-flex align-items-center">
                <a href="#" class="text-white mx-3"><i class="bi bi-search"></i> Buscar</a>
                <a href="#" class="text-white mx-3"><i class="bi bi-map"></i> Mapa</a>
                <a href="#" class="text-white mx-3"><i class="bi bi-chat-dots"></i> Mensajes</a>
                <a href="#" class="text-white mx-3"><i class="bi bi-people"></i> Amigos</a>
            </div>
        </div>
    </nav>

    <!-- Contenido central -->
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <h2 class="mb-4">¿A dónde te llevará el Erasmus?</h2>
            <form class="d-flex gap-3">
                <!-- Campo de búsqueda -->
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Lugar...">
                </div>

                <!-- Fecha de llegada -->
                <input type="date" class="form-control" placeholder="Fecha de llegada">

                <!-- Fecha de finalización -->
                <input type="date" class="form-control" placeholder="Fecha de finalización">

                <!-- Botón explorar -->
                <button type="submit" class="btn btn-primary">Explorar</button>
            </form>
        </div>
    </div>
</div>
@endsection
