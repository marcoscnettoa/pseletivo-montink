<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\LojaController;
use \App\Http\Controllers\ProdutosController;
use \App\Http\Controllers\VariacoesController;
use \App\Http\Controllers\EstoquesController;
use \App\Http\Controllers\CuponsController;
use \App\Http\Controllers\PedidosCarrinhoDeComprasController;

Route::get('/', [ LojaController::class, 'index' ])->name('loja.index');
Route::post('adicionar-carrinho',   [ LojaController::class, 'adicionarCarrinho' ])->name('loja.adicionar.carrinho');
Route::post('adicionar-cupom',       [ LojaController::class, 'adicionarCupom' ])->name('loja.adicionar.cupom');
Route::get('remover-carrinho',      [ LojaController::class, 'removerCarrinho' ])->name('loja.remover.carrinho');
Route::get('cancelar-carrinho',     [ LojaController::class, 'cancelarCarrinho' ])->name('loja.cancelar.carrinho');

// :: Produtos
Route::resource('produtos', ProdutosController::class)->names([
    'index'     => 'produtos.index',
    'create'    => 'produtos.create',
    'edit'      => 'produtos.edit',
    'store'     => 'produtos.store',
    'update'    => 'produtos.update',
    'destroy'   => 'produtos.destroy',
])->parameters(['produtos' => 'id']);

// :: Variações
Route::resource('variacoes', VariacoesController::class)->names([
    'index'     => 'variacoes.index',
    'create'    => 'variacoes.create',
    'edit'      => 'variacoes.edit',
    'store'     => 'variacoes.store',
    'update'    => 'variacoes.update',
    'destroy'   => 'variacoes.destroy',
])->parameters(['variacoes' => 'id']);

// :: Estoques
Route::resource('estoques', EstoquesController::class)->names([
    'index'     => 'estoques.index',
    'create'    => 'estoques.create',
    'edit'      => 'estoques.edit',
    'store'     => 'estoques.store',
    'update'    => 'estoques.update',
    'destroy'   => 'estoques.destroy',
])->parameters(['estoques' => 'id']);

// :: Cupons
Route::resource('cupons', CuponsController::class)->names([
    'index'     => 'cupons.index',
    'create'    => 'cupons.create',
    'edit'      => 'cupons.edit',
    'store'     => 'cupons.store',
    'update'    => 'cupons.update',
    'destroy'   => 'cupons.destroy',
])->parameters(['cupons' => 'id']);

// :: Pedidos -| Carrinho de Compra
Route::get('carrinho-compra', [PedidosCarrinhoDeComprasController::class,'index'])->name('carrinho.compra');
Route::resource('pedidos', PedidosCarrinhoDeComprasController::class)->names([
    //'index'     => 'pedidos.index',
    'create'    => 'pedidos.create',
    'edit'      => 'pedidos.edit',
    'store'     => 'pedidos.store',
    'update'    => 'pedidos.update',
    'destroy'   => 'pedidos.destroy',
])->except(['index'])->parameters(['pedidos' => 'id']);
