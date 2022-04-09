<?php

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
//


Route::get('/status', function () {
      return response()->json(['message' => 'Heroku', 'status' => 'Connected']);
  });

//Route::get('/user', 'UserController@index');
Route::post('/cadastraUser', 'Api\UserController@store');
Route::resource('/categorias', 'Api\CategoriaController');
Route::resource('/produtos', 'Api\ProdutoController');
Route::get('produtoAtributos/{busineId}', 'Api\ProdutoController@produtoAtributos');
Route::get('/produtosCategoria/{busineId}', 'Api\CategoriaController@produtosCategoria');
Route::resource('/promocoes', 'Api\PromocaoController');
Route::resource('/promocaoProduto', 'Api\PromocaoProdutoController');
Route::get('/promocaoProdutos', 'Api\PromocaoController@promocaoProdutos');
Route::resource('/atributos', 'Api\AtributoController');
Route::get('/atributoProduto/{id}', 'Api\AtributoController@atributoProduto');
Route::resource('/categoriaAtributo', 'Api\CategoriaAtributoController');


/*------------------routers carrinho-------------------------------------*/
Route::post('/cad_carrinho', 'Api\CarrinhoController@store');
Route::get('/listarCarrinho/{idUser}/{idBusine}', 'Api\CarrinhoController@listarCarrinho');
Route::get('/listarCarrinhoQtd/{idUser}/{idBusine}', 'Api\CarrinhoController@listarItensCarrinhoQtd');
Route::post('/carrinhos', 'Api\CarrinhoController@destroy');


/*-------------------Routers Busines-------------------------------------*/
Route::post('/busines', 'Api\BusineConfigController@index');
Route::post('/busine', 'Api\BusineConfigController@getEmpresasLatLong');
Route::get('/busine_config/{idbusine}', 'Api\BusineConfigController@getBusineConfig');
Route::get('/busine_data/{idbusine}', 'Api\BusineConfigController@getBusineData');


/*------------------routers user-------------------------------------*/
Route::get('/user', 'Api\UserController@index');
Route::resource('/user', 'Api\UserController');
Route::resource('/addressUser', 'Api\AddressController');
Route::get('/getUser/{email}/{senha}', 'Api\UserController@getUser');
Route::get('/getUserGoogle/{hash}/{email}', 'Api\UserController@getUserGoogle');
Route::post('/getEnduserLocal', 'Api\UserController@getEnderecoLocal');
Route::get('/refresh', 'Api\UserController@refreshTokenJwt');
Route::get('/logout', 'Api\UserController@logoutTokenJwt');
Route::post('/upImgUser', 'Api\UserController@updateImgUser');


/******************Pedido ***************************************************/
Route::post('/pedido', 'Api\PedidosController@salvarPedido');
Route::get('/pedidos/{iduser}', 'Api\PedidosController@listPedidos');
Route::get('/pedidos_detalhes/{iduser}', 'Api\PedidosController@listPedidosDetalhes');
Route::post('/cancelOrder/{id_pedido}/{reason_cancellation}', 'Api\PedidosController@cancelarPedido');

/******************* routers cartoes **************************/
Route::resource('/cartoes', 'Api\CartaoController');

/******************* routers e-mails **************************/
Route::post('/sendemail/{email}', 'Api\UserController@redefinirSenha');
Route::post('/newPassword', 'Api\UserController@newPassword');
Route::post('/sendCodeActivation/{email}', 'Api\UserController@sendCodeActivation');
Route::post('/activateAccount', 'Api\UserController@activateAccount');

Route::group(['middleware' => ['auth:api']], function () {

    //Route::get('/produtos', 'ProdutoController@index')->middleware('scope:administrador,usuario'); //ambas podem acessar
    //Route::post('/produtos', 'ProdutoController@store')->middleware('scope:administrador');//apenas o administrador terá acesso

});
