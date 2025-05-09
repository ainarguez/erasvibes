@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

<div class="container-fluid">
    
    @include('partials.navbar')

    <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 80px);">
    <div class="text-center">
            <h2 class="mb-4">¿A dónde te llevará el Erasmus?</h2>
                <form action="{{ route('map') }}" method="GET" class="d-flex gap-3">
            <!-- Campo de búsqueda -->
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" name="place" placeholder="Lugar..." value="{{ request('place') }}">
                </div>

                <!-- Fecha de llegada -->
                <input type="date" class="form-control" name="arrival_date" value="{{ request('arrival_date') }}">

                <!-- Fecha de finalización -->
                <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">

                <!-- Botón explorar -->
                <button type="submit" class="btn btn-amarillo">Explorar</button>
            </form>
        </div>
    </div>
</div>

@endsection