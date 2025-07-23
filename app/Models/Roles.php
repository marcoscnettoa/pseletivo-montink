<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Trait\PublicHashRequired; // # MXTera -

class Roles extends Model
{

    use SoftDeletes;

    protected $table    = 'roles';
    public $timestamps  = true;

    public static function getRoles($idWhereIn = null, $nameWhereIn = null) {
        $query = self::query();
        if(!is_null($idWhereIn))  { $query = $query->whereIn('id', $idWhereIn); }
        if(!is_null($nameWhereIn)){ $query = $query->whereIn('name', $nameWhereIn); }
        return $query->orderBy('id','ASC')->get(['id','hash','name','description']);
    }

}
