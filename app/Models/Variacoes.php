<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Trait\PublicHashRequired; // # MXTera -

class Variacoes extends Model
{

    use SoftDeletes;

    protected $table    = 'loja_variacoes';
    public $timestamps  = true;

    public function getProduto(){
        return $this->belongsTo(Produtos::class, 'loja_produtos_id');
    }

    public static function getLista($pluck = false, $array = false) {
        $query = self::query();
        $query = $query->orderBy('id','ASC')->get(['id','nome']);
        $query = ($pluck?$query->pluck('nome','id'):$query);
        return ($array?$query->toArray():$query);
    }

}
