<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\InboxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\IsAdmin; 

// Página de inicio y búsqueda
Route::get('/', [ProfileController::class, 'index'])->name('home');
Route::get('/map', [ProfileController::class, 'showMap'])->name('map');
Route::get('/search', [ProfileController::class, 'search'])->name('search');

// Dashboard protegido
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo para usuarios autenticados
Route::middleware(['auth'])->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/perfil', [ProfileController::class, 'show'])->name('perfil');

    // Perfil de otros usuarios
    Route::get('/perfil/usuario/{user}', [ProfileController::class, 'view'])->name('profile.view');

    // Inbox
    Route::get('/inbox/{id}', [InboxController::class, 'show'])->name('inbox.show');

    // Mensajes
    Route::get('/chat', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/chat/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/chat/{user}', [MessageController::class, 'store'])->name('messages.store');
    Route::delete('/chat/{user}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/messages/create/{recipient}', [MessageController::class, 'create'])->name('messages.create');

    // Amigos
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friends/send/{id}', [FriendController::class, 'send'])->name('friends.send');
    Route::patch('/friends/accept/{request}', [FriendController::class, 'accept'])->name('friends.accept');
    Route::delete('/friends/reject/{request}', [FriendController::class, 'reject'])->name('friends.reject');
});

// Redirigir /admin a /admin/usuarios
Route::redirect('/admin', '/admin/usuarios');

// Grupo para administrador
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('store');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('edit');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('destroy');
});

// Autenticación
require __DIR__.'/auth.php';
