<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
 Route::get('prueba', 'AreaController@prueba');
/**
 * Rutas API V1
 */
Route::group([
    'prefix' => 'v1'
], function () {
    /**
     * Rutas Publicas sin token
     */

    Route::post('login', 'AuthController@login');

    Route::get('noticias', 'NoticiaController@noticias');
    Route::get('noticias/{id}', 'NoticiaController@noticia');

    Route::get('areas', 'AreaController@areas');

    Route::get('tags', 'TagController@tags');

    Route::get('eventos', 'EventoController@eventos');
    Route::get('eventos/{id}', "eventoController@evento");


    /**
     * Rutas privadas con token
     */
    Route::group([
      'middleware' => 'auth:api'
    ], function() {

        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');


        Route::post('noticias', 'NoticiaController@create');
        Route::post('noticias/{id}', 'NoticiaController@edit');
        Route::delete('noticias/{id}', 'NoticiaController@delete');


        Route::post('eventos', 'EventoController@create');
        Route::post('eventos/{id}', 'EventoController@edit');
        Route::delete('eventos/{id}', 'EventoController@delete');

    });
});
