<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Trait\PublicHashRequired; // # MXTera -

class Produtos extends Model
{

    use SoftDeletes;

    protected $table    = 'loja_produtos';
    public $timestamps  = true;

    public static function getLista($pluck = false, $array = false) {
        $query = self::query();
        $query = $query->orderBy('id','ASC')->get(['id','nome']);
        $query = ($pluck?$query->pluck('nome','id'):$query);
        return ($array?$query->toArray():$query);
    }

    public function getVariacoes() {
        return $this->hasMany(Variacoes::class, 'loja_produtos_id','id')->orderBy('loja_variacoes.id','ASC');
    }

    public function getEstoqueVariacoes() {
        return $this->hasMany(Estoques::class, 'loja_produtos_id', 'id')
                    ->select(['loja_estoques.id as loja_estoques_id','loja_variacoes.id as loja_variacoes_id','loja_variacoes.nome','loja_estoques.quantidade'])
                    ->leftJoin('loja_variacoes', 'loja_variacoes.id', '=', 'loja_estoques.loja_variacoes_id');
    }

}
