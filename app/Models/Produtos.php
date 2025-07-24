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

}
