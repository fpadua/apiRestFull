<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('auth/login', 'Api\AuthController@login');

Route::middleware(['apiJwt'])->group(function () {
    Route::post('auth/logout', 'Api\AuthController@logout');

    Route::get('empresas', 'Api\EmpresaController@index');
    Route::get('empresa/edit', 'Api\EmpresaController@edit');

    Route::post('empresa', 'Api\EmpresaController@store');
    Route::put('empresa/{empresa}', 'Api\Empresacontroller@update');
    Route::delete('empresa/delete', 'Api\EmpresaController@destroy');

    Route::get('verifyCnpj', 'Api\Empresacontroller@verifyCnpj');

    Route::get('users', 'Api\UserController@index');
});


