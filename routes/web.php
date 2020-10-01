<?php

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

Route::get('/', 'ClienteControlador@index'); // Chama o controlador index

Route::get('/paginacaoJS', 'ClienteControlador@indexjs');

Route::get('/json', 'ClienteControlador@indexjson');
