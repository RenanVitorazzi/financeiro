<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\ClienteController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

Route::resource('clientes', ClienteController::class);
Route::resource('representantes', RepresentanteController::class);

// Route::group(['prefix' => 'representantes'], function() {
//     Route::get('/', [RepresentanteController::class, 'index']);
//     Route::get('/adicionar', [RepresentanteController::class, 'create']);
//     Route::post('/adicionar', [RepresentanteController::class, 'store']);
//     Route::get('/editar/{id}', [RepresentanteController::class, 'edit'])->name('editarRepresentante');
//     Route::put('/editar/{id}', [RepresentanteController::class, 'update']);
//     Route::delete('/deletar/{id}',[RepresentanteController::class, 'delete'])->name("deletarRepresentante");
// });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
