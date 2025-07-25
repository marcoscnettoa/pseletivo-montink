<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Trait\PublicHashRequired; // # MXTera -

class PedidosProdutos extends Model
{

    use SoftDeletes;

    protected $table    = 'loja_pedidos_produtos';
    public $timestamps  = true;

}
