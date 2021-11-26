<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers necessários
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarberController;

// Teste Ping e Pong
Route::get('/ping', function () {
    return ['pong' => true];
});

// Rota para login não autorizado
Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

// Rota Randon - popular a tabela Barbeiros
// Route::get('/random', [BarberController::class, 'createRandom']);

// Auth
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/refresh', [AuthController::class, 'refresh']);

//Route::post('/user', [AuthController::class, 'create']);
Route::post('/user', [AuthController::class, 'create']);

// User
Route::get('/user', [UserController::class, 'read']);
Route::put('/user', [UserController::class, 'update']);

// Rota para atualizar fotos
Route::post('/user/avatar', [UserController::class, 'updateAvatar']);

Route::get('/user/favorites', [UserController::class, 'getFavorites']);
Route::post('/user/favorite', [UserController::class, 'toggleFavorite']);
Route::get('/user/appointments', [UserController::class, 'getAppointments']);

// Barber
Route::get('/barbers', [BarberController::class, 'list']);
Route::get('/barber/{id}', [BarberController::class, 'one']);
Route::post('/barber/{id}/appointment', [BarberController::class, 'setAppointment']);

// Search
Route::get('/search', [BarberController::class, 'search']);
