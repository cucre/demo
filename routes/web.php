<?php

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
    return redirect()->route('login');
});

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

//Configuración
Route::get('/config/usuarios/data', 'UserController@data')->name('usuarios.data');
Route::post('/config/usuarios/restore', 'UserController@restore')->name('usuarios.restore');
Route::resource('/config/usuarios', 'UserController', ['except' => ['show']]);
Route::resource('/config/permisos', 'PermissionController');

///************* Catalogos *************///////
//Corporaciones
Route::get('/list/corporaciones/data', 'CorporationController@data')->name('corporaciones.data');
Route::post('/list/corporaciones/restore', 'CorporationController@restore')->name('corporaciones.restore');
Route::resource('/list/corporaciones', 'CorporationController', ['except' => ['show']]);

//Instructores
Route::get('/list/instructores/data', 'InstructorController@data')->name('instructores.data');
Route::post('/list/instructores/restore', 'InstructorController@restore')->name('instructores.restore');
Route::resource('/list/instructores', 'InstructorController');