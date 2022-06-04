<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Rol\RolesController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
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
|PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::group([], function () {
    //RUTA PRA DEFINIR EL LENGUAJE DE LA APLICACION
    Route::get('locale/{locale}',function($locale){
        session()->put('locale',$locale);
        return Redirect::back();
    });
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
    Route::get('registration', [AuthController::class, 'registration'])->name('register');
    Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
});


/*
|--------------------------------------------------------------------------
|ROUTES WITH AUTENTICATION
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
    /**
     * RUTAS GENERICAS PARA TODOS LOS USUARIOS CON LOGIN
     */

    // CUANDO ES GET, POST, PUT, DELETE SE ESCRIBE DE ESTA MANERA LA RUTA
    Route::get('panel', [PanelController::class, 'index'])->name('panel');
    Route::get('dashboard', [AuthController::class, 'dashboard']);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * RUTAS ESPECIFICAS SEGÚN ROL, LAS MISMAS, EVALÚAN SI EL ROL DEL USUARIO POSEE PREMISOS CON EL MIDDLEWARE
     */
    Route::group(['middleware' => ['RoutesWithPermission']], function () {

        //CUANDO ES RESOURCE SE ESCRIBE DE ESTA MANERA LA RUTA
        Route::resource('users', UserController::class,['names' => ['as' => 'prefix']]);
        Route::resource('roles', RolesController::class,['names' => ['as' => 'prefix']]);
        Route::resource('permissions', PermissionController::class,['names' => ['as' => 'prefix']]);

    });

});


Route::fallback(function(){ return response()->view('errors.404', [], 404); });
