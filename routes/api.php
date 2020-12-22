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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

 //Clientes
 Route::get('clientes', 'ClientController@index');
 Route::get('cliente/{id}', 'ClientController@show');
 Route::post('cliente', 'ClientController@store');
 Route::put('cliente/{id}', 'ClientController@update');
 Route::delete('cliente/{id}', 'ClientController@destroy');
