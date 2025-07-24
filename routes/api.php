<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\ConsultasApiController;
use App\Http\Controllers\Api\V1\VariacoesApiController;

Route::prefix('v1')->group(function() {

    Route::get('/variacoes/produto/{id}', [ VariacoesApiController::class, 'getVariacoesProduto' ])->name('variacoes.produto.id');

});
