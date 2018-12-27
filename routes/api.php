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

Route::get('/pedidos/get-vendas', 'Painel\PedidoController@getVendas');


Route::resource('/produtos', 'Painel\ProdutoController');
Route::resource('/clientes', 'Painel\ClienteController');
Route::resource('/contatos-cliente', 'Painel\ContatoClienteController');
Route::resource('/pedidos', 'Painel\PedidoController');
Route::resource('/vendas', 'Painel\VendaController');