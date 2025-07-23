<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Consultas\ConsultaCepService;
use App\Services\Consultas\ConsultaCnpjService;
use App\Services\Consultas\ConsultaMunicipiosService;

class ConsultasController extends Controller {

    public static function cep($cep, ConsultaCepService $service) {

        $dados = $service->consultar($cep);
        return (empty($dados)?response()->json([]):response()->json($dados));

    }

    public static function municipios($uf, ConsultaMunicipiosService $service) {

        $dados = $service->consultar($uf);
        return (empty($dados)?response()->json([]):response()->json($dados));

    }

}
