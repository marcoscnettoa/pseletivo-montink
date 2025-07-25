<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PedidosCarrinhoDeComprasController;
use App\Http\Controllers\Api\V1\ConsultasApiController;
use App\Http\Controllers\Api\V1\VariacoesApiController;

Route::any('pedido/webhook',                    [ PedidosCarrinhoDeComprasController::class, 'webhook' ]);

Route::prefix('v1')->group(function() {

    Route::get('/consultas/cep/{cep}',          [ ConsultasApiController::class, 'cep' ]);
    Route::get('/consultas/municipios/{uf}',    [ ConsultasApiController::class, 'municipios' ]);

    Route::get('/variacoes/produto/{id}',       [ VariacoesApiController::class, 'getVariacoesProduto' ])->name('variacoes.produto.id');

});
