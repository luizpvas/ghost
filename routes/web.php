<?php

use App\Http\Controllers\Auth\RegistrationsController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\SessionConfirmationsController;
use App\Http\Controllers\WorkspacesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::resource('registrations', RegistrationsController::class)->only(['create', 'store']);
    Route::resource('sessions', SessionsController::class)->only(['create', 'store', 'destroy']);
    Route::resource('session_confirmations', SessionConfirmationsController::class)->only(['create', 'store']);
});

Route::resource('workspaces', WorkspacesController::class);
