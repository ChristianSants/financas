<?php

use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return phpinfo();

    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {

    //Categorias
    Route::prefix('categorias')->group(function () {
        
        Route::get('/', [CategoriaController::class, 'index'])->name('categorias.index');

        Route::post('/', [CategoriaController::class, 'store'])->name('categorias.store');

        Route::group(['prefix' => '{categoria}'], function () {

            Route::get('/', [CategoriaController::class, 'show'])->name('categorias.show');
            
            Route::put('/', [CategoriaController::class, 'update'])->name('categorias.update');

            Route::delete('/', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
        });        
    });
    
});
