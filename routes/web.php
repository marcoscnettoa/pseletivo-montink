<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\LojaController;
use \App\Http\Controllers\ProdutosController;
use \App\Http\Controllers\CuponsController;
use \App\Http\Controllers\PedidosController;

Route::get('/', [ LojaController::class, 'index' ])->name('loja.index');

// :: Produtos
Route::resource('produtos', ProdutosController::class)->names([
    'index'     => 'produtos.index',
    'create'    => 'produtos.create',
    'edit'      => 'produtos.edit',
    'store'     => 'produtos.store',
    'update'    => 'produtos.update',
    'destroy'   => 'produtos.destroy',
])->parameters(['produtos' => 'id']);

// :: Variações -| Produtos
Route::resource('variacoes', ProdutosController::class)->names([
    'index'     => 'variacoes.index',
    'create'    => 'variacoes.create',
    'edit'      => 'variacoes.edit',
    'store'     => 'variacoes.store',
    'update'    => 'variacoes.update',
    'destroy'   => 'variacoes.destroy',
])->parameters(['variacoes' => 'id']);

// :: Cupons
Route::resource('cupons', CuponsController::class)->names([
    'index'     => 'cupons.index',
    'create'    => 'cupons.create',
    'edit'      => 'cupons.edit',
    'store'     => 'cupons.store',
    'update'    => 'cupons.update',
    'destroy'   => 'cupons.destroy',
])->parameters(['cupons' => 'id']);

// :: Pedidos
Route::resource('pedidos', PedidosController::class)->names([
    'index'     => 'pedidos.index',
    'create'    => 'pedidos.create',
    'edit'      => 'pedidos.edit',
    'store'     => 'pedidos.store',
    'update'    => 'pedidos.update',
    'destroy'   => 'pedidos.destroy',
])->parameters(['pedidos' => 'id']);
