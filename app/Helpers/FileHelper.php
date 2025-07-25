<?php
// # MXTera -
namespace App\Helpers;

class FileHelper {

    public static function input_accepts_imagens($virgula_espaco = true,$ponto_com_extensao = true){
        return implode(($virgula_espaco?', ':','),
            array_map(function($file) use ($ponto_com_extensao){
                return ($ponto_com_extensao?'.':'').$file;
            },config('system.uploads_files.allowed_images'))
        );
    }

    public static function input_accepts_docs($virgula_espaco = true,$ponto_com_extensao = true){
        return implode(($virgula_espaco?', ':','),
            array_map(function($file) use ($ponto_com_extensao){
                return ($ponto_com_extensao?'.':'').$file;
            },config('system.uploads_files.allowed_docs'))
        );
    }

    // B -> KB
    public static function get_bytes_to_kilobytes($bytes){
        return ($bytes/1024); // KB
    }

    // B -> MB
    public static function get_bytes_to_megabytes($bytes){
        return ($bytes/1024/1024);
    }

}
