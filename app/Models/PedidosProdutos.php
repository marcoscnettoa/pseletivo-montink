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

    public function getProduto() {
        return $this->belongsTo(Produtos::class, 'loja_produtos_id');
    }

    public function getVariacao() {
        return $this->belongsTo(Variacoes::class, 'loja_variacoes_id');
    }

}
