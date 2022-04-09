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
//Route::get('/login', 'LoginController@login')->name('login');
Route::post('/login', 'Web\AdminController@login')->name('login');
Route::get('/logout', 'Web\AdminController@logout')->name('logout');


//Auth::routes();
Route::resource('admin', 'Web\AdminController');
Route::middleware(['pidaAuth'])->group(function () {
    Route::namespace('Web')->group(function(){//Nome da pasta que está armazenando os controllers.
        /******************Plano******************************/
        Route::get('/plano', 'PlanoController@index')->name('index');
        Route::put('plano/{id?}', 'PlanoController@update')->where('id', '[0-9]+')->name('update');
        Route::delete('plano/{id}', 'PlanoController@destroy')->where('id', '[0-9]+')->name('destroy');
        /******************produto ******************************/
        //Route::resource('admin', 'Web\AdminController');

        /******************categoria produto ******************************/
        Route::post('/categoria-produto', 'CategoriaController@categoriaProdutoIndex');
        Route::post('/categoria-produto/cadastro', 'CategoriaController@storeCategoria');
        Route::delete('/categoria-produto/{id}', 'CategoriaController@destroyCategoria');
        Route::get('/categoria-produto/categoria', 'CategoriaController@getCategoriaAll');


        /******************categoria atributo ******************************/
        Route::post('/categoria-atributo', 'CategoriaController@categoriaAttrIndex');
        Route::post('/categoria-atributo/cadastro', 'CategoriaController@store');
        Route::delete('/categoria-atributo/{id}', 'CategoriaController@destroy');
        Route::get('/categoria-atributo/atributo', 'CategoriaController@getCategoriaAtributoAll');
        
        /******************produto ******************************/
        Route::post('/produto', 'ProdutoController@index');
        Route::post('/produto/cadastro', 'ProdutoController@store');
        Route::delete('/produto/{id}', 'ProdutoController@destroy');
        Route::get('/produto/{id}', 'ProdutoController@getProduto');

        /******************unidade produto ******************************/
        // Route::post('/categoria-produto', 'CategoriaController@categoriaProdutoIndex');
        // Route::post('/categoria-produto/cadastro', 'CategoriaController@storeCategoria');
        // Route::delete('/categoria-produto/{id}', 'CategoriaController@destroyCategoria');
        Route::get('/unidade', 'UnidadeController@getUnidadeAll');   
    
    });
});

Route::get('/', 'Web\HomeController@index')->name('dash');
Route::get('/dash', 'Web\HomeController@index')->name('dash');
Route::get('/home', 'Web\HomeController@index')->name('dash');
Route::post('/site_mensagem', 'Web\HomeController@sendEmailSite');

/******************** ADMIN  ************************************/
Route::post('/reset', 'Web\AdminController@resetSenha')->name('reset_senha');
Route::post('/save_reset', 'Web\AdminController@saveNovaSenha')->name('save_senha');
Route::post('link-ativacao', 'Web\AdminController@envioLinkAtivacao');
Route::post('/activate', 'Web\AdminController@ativarConta')->name('ativar_conta');

/*************************** busine **************************************************/
Route::get('/register-busine', 'Web\BusineController@index')->name('busine-register');
Route::get('/data-busine', 'Web\BusineController@dataView')->name('busine-data');
Route::resource('/web_busine', 'Web\BusineController');
Route::post('/busine/file', 'Web\BusineController@file');
Route::get('/busine/configuracoes', 'Web\BusineController@configuracoes')->name('configuracoes');
Route::post('/busine/update-data', 'Web\BusineController@updateBusineData');
Route::post('/busine/update-configs', 'Web\BusineController@updateBusineConfigs');

/*********************************produto ****************************************************/
Route::get('/consulta-produto', 'Web\ProdutoController@consultaProduto')->name('produto-consultar');

/*********************************Promoções ****************************************************/
Route::get('/promocao', 'Web\PromocaoController@index')->name('promocao');
Route::get('/cadastro-promocao', 'Web\PromocaoController@promocaoCadastro')->name('promocao-cadastrar');
/*********************************Planos*********************************************************************/


