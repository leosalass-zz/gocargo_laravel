<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'propietarios'], function(){
    Route::post('/', [
        'uses' => 'PropietariosController@create'
    ]);
    Route::get('/', [
        'uses' => 'PropietariosController@get_all'
    ]);
    Route::put('/', [
        'uses' => 'PropietariosController@update'
    ]);
    Route::delete('/', [
        'uses' => 'PropietariosController@delete'
    ]);


    Route::post('/vehiculos', [
        'uses' => 'PropietariosController@get_vehicles'
    ]);
});

Route::group(['prefix' => 'vehiculos'], function(){
    Route::post('/', [
        'uses' => 'VehiculosController@create'
    ]);
    Route::get('/', [
        'uses' => 'VehiculosController@get_all'
    ]);
    Route::put('/', [
        'uses' => 'VehiculosController@update'
    ]);
    Route::delete('/', [
        'uses' => 'VehiculosController@delete'
    ]);
});

