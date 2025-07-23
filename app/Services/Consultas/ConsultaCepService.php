<?php

namespace App\Services\Consultas;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConsultaCepService {

    public function consultar(string $cep): array {

        try {

            if(empty($cep)){ return []; }
            $cep      = str_replace([' ','.','-','/','_'],'',$cep);

            $response = Http::get('https://viacep.com.br/ws/'.$cep.'/json/');
            if($response->failed()){ return []; }
            return $response->json();

        }catch(Exception $e) {
            Log::error('Erro! ConsultaCepService -| consultar | '.$e->getMessage());
            return [];
        }

    }

}
