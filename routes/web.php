<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\Permiso\PermisosController;
use App\Http\Controllers\Rol\RolesController;
use App\Http\Controllers\User\UserController;
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

/*
|--------------------------------------------------------------------------
|ROUTES WITH AUTENTICATION
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
    Route::get('panel', [PanelController::class, 'index'])->name('panel');
    Route::get('dashboard', [AuthController::class, 'dashboard']);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::group(['middleware' => ['PermisosMiddleware']], function () {
        Route::resource('usuarios', UserController::class)->name('index','usuarios');
        Route::resource('roles', RolesController::class)->name('index','roles');
        Route::resource('permisos', PermisosController::class)->name('index','permisos');
    });

});

/*
|--------------------------------------------------------------------------
|PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::group([], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::get('registration', [AuthController::class, 'registration'])->name('register');
    Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
});

Route::fallback(function(){ return response()->view('errors.404', [], 404); });
