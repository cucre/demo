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

//Instructores - Documentos
Route::get('/list/instructores/documentos/index/{instructor}', 'DocumentController@index')->name('documentos.index');
Route::get('/list/instructores/documentos/create/{instructor}', 'DocumentController@create')->name('documentos.create');
Route::get('/list/instructores/documentos/{documento}/edit/{instructor}', 'DocumentController@edit')->name('documentos.edit');
Route::get('/list/instructores/documentos/data/{id}', 'DocumentController@data')->name('documentos.data');
Route::post('/list/instructores/documentos/delete', 'DocumentController@delete')->name('documentos.delete');
Route::post('/list/instructores/documentos/restore', 'DocumentController@restore')->name('documentos.restore');
Route::resource('/list/instructores/documentos', 'DocumentController', ['only' => ['store', 'update']]);

//Materias
Route::get('/list/materias/data', 'SubjectController@data')->name('materias.data');
Route::post('/list/materias/restore', 'SubjectController@restore')->name('materias.restore');
Route::resource('/list/materias', 'SubjectController', ['except' => ['show']]);

///************* Control *************///////
//Cursos
Route::get('/control/cursos/data', 'CourseController@data')->name('cursos.data');
Route::post('/control/cursos/restore', 'CourseController@restore')->name('cursos.restore');
Route::resource('/control/cursos', 'CourseController', ['except' => ['show']]);

//Instructores - Cursos
Route::get('/control/cursos/instructores/index/{curso}', 'InstructorCourseController@index')->name('instructores_cursos.index');
Route::get('/control/cursos/instructores/create/{curso}', 'InstructorCourseController@create')->name('instructores_cursos.create');
Route::get('/control/cursos/instructores/{instructor_curso}/edit/{curso}', 'InstructorCourseController@edit')->name('instructores_cursos.edit');
Route::get('/control/cursos/instructores/data/{id}', 'InstructorCourseController@data')->name('instructores_cursos.data');
Route::post('/control/cursos/instructores/delete', 'InstructorCourseController@delete')->name('instructores_cursos.delete');
Route::post('/control/cursos/instructores/restore', 'InstructorCourseController@restore')->name('instructores_cursos.restore');
Route::resource('/control/cursos/instructores', 'InstructorCourseController', ['as' => 'instructores_cursos'], ['only' => ['store', 'update']]);