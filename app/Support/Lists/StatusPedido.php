<?php
// # MXTera -
namespace App\Support\Lists;

class StatusPedido {

    protected static array $status = [
        'EM_ANDAMENTO'          => 'Em Andamento',
        'AGUARDANDO_PAGAMENTO'  => 'Aguardando Pagamento',
        'ENTREGUE'              => 'Entregue',
        'CANCELADO'             => 'Cancelado',
    ];

    public static function getLista(): array {
        return self::$status;
    }

    public static function getListaKey($implode = false): string|array {
        $listaKey = array_keys(self::$status);
        return ($implode?implode(',',$listaKey):$listaKey);
    }

    public static function getStatusByKey(string $key): ?string {
        return (isset(self::$status[$key])?self::$status[$key]:null);
    }
}
