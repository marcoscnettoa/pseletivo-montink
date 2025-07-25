<?php

namespace App\Services\Consultas;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConsultaMunicipiosService {

    public function consultar(string $uf): array {

        try {

            if(empty($uf)){ return []; }
            $uf       = str_replace([' '],'',$uf);
            $uf       = strtolower($uf);

            $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados/'.$uf.'/municipios');
            if($response->failed()){ return []; }
            return $response->json();

        }catch(Exception $e) {
            Log::error('Erro! ConsultaMunicipiosService -| consultar | '.$e->getMessage());
            return [];
        }

    }

}
