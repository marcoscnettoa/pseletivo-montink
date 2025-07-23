<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\DashboardController;
use \App\Http\Controllers\ContabilidadesController;
use \App\Http\Controllers\ClientesController;

Route::get('/', [ HomeController::class, 'index' ]);

// :: Produtos
Route::resource('produtos', ProdutosController::class)->names([
    'index'     => 'produtos.index',
    'create'    => 'produtos.create',
    'edit'      => 'produtos.edit',
    'store'     => 'produtos.store',
    'update'    => 'produtos.update',
    'destroy'   => 'produtos.destroy',
])->parameters(['produtos' => 'id']);

// :: Pedidos
Route::resource('pedidos', PedidosController::class)->names([
    'index'     => 'pedidos.index',
    'create'    => 'pedidos.create',
    'edit'      => 'pedidos.edit',
    'store'     => 'pedidos.store',
    'update'    => 'pedidos.update',
    'destroy'   => 'pedidos.destroy',
])->parameters(['pedidos' => 'id']);

// :: Cupons
Route::resource('cupons', CuponsController::class)->names([
    'index'     => 'cupons.index',
    'create'    => 'cupons.create',
    'edit'      => 'cupons.edit',
    'store'     => 'cupons.store',
    'update'    => 'cupons.update',
    'destroy'   => 'cupons.destroy',
])->parameters(['cupons' => 'id']);

