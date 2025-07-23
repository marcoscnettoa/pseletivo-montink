<?php
// # MXTera -
namespace App\Support\Lists;

class Estados {

    protected static array $estados = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AM' => 'Amazonas',
        'AP' => 'Amapá',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MG' => 'Minas Gerais',
        'MS' => 'Mato Grosso do Sul',
        'MT' => 'Mato Grosso',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'PR' => 'Paraná',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'RS' => 'Rio Grande do Sul',
        'SC' => 'Santa Catarina',
        'SE' => 'Sergipe',
        'SP' => 'São Paulo',
        'TO' => 'Tocantins',
    ];

    public static function getLista(): array {
        return self::$estados;
    }

    public static function getListaKey($implode = false): string|array {
        $listaKey = array_keys(self::$estados);
        return ($implode?implode(',',$listaKey):$listaKey);
    }

    public static function getEstadoBySigla(string $sigla): ?string {
        $sigla = strtoupper($sigla);
        return (isset(self::$estados[$sigla])?self::$estados[$sigla]:null);
    }

    public static function getSiglaByEstado(string $estado): ?string {
        $estado = strtoupper($estado);
        $search = array_search($estado, array_map('strtoupper',self::$estados));
        return ($search?$search:null);
    }
}
