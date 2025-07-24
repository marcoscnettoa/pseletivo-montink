<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Variacoes;
use App\Services\Consultas\ConsultaCepService;
use App\Services\Consultas\ConsultaCnpjService;
use App\Services\Consultas\ConsultaMunicipiosService;
use Illuminate\Support\Facades\Log;

class VariacoesApiController extends Controller {

    public static function getVariacoesProduto($id) {
        try {

            $variacoes = Variacoes::where('loja_produtos_id',$id)->get(['id','nome']);

            return response()->json($variacoes);

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
            return response()->json([],500);
        }

    }

}
