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

Route::resource('/produtos', 'Painel\ProdutoController');
Route::resource('/clientes', 'Painel\ClienteController');
Route::resource('/contatos-cliente', 'Painel\ContatoClienteController');
Route::resource('/pedidos', 'Painel\PedidoController');
Route::resource('/vendas', 'Painel\VendaController');

Route::get('/login', function(){
})->name('login');

Route::group(['middleware' => 'auth' ], function(){
 
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/api/contatos-cliente/contatos-por-cliente/{cliente_id}', 'Painel\ContatoClienteController@contatosPorCliente');
Route::get('/api/items-pedido/items-por-pedido/{pedido_id}', 'Painel\ItemPedidoController@getItemsPorVenda');