<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

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
    return view('auth.login');
});

/*Route::get('/empleado', function () {
    return view('empleado.index');
});

Route::get('/empleado/create', [EmpleadoController::class,'create']);*/

//Route::middleware(['auth:sanctum','verified'])->get('empleado', [EmpleadoController::class, 'destroy'])->name('empleado.destroy');

Route::resource('empleado', EmpleadoController::class)->middleware('auth');
//Auth::routes(['register'=>false,'reset'=>false]);
Auth::routes(['register'=>false, 'reset'=>false, 'verify'=>false]);

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

/*Route::middleware(['auth', 'second'])->group(function () {
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});*/

/*  Route::prefix('auth')->group(function () {
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});*/

Route::group(['middleware' => 'auth'], function(){
    
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/*
Route::delete('empleados-seleccionados', [EmpleadoController::class, 'destroyChecked'])->name('empleado.deleteSelected');
*/
Route::delete('empleadosDeleteAll', 'EmpleadoController@deleteAll');

Route::delete('/deleteall', [App\Http\Controllers\EmpleadoController::class, 'index'])->name('/deleteall');
