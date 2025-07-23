<?php
// # MXTera -

return [
    'cache_version'      => '23072025-0001',
    'uploads_files'      => [
        'allowed_images' => ['ico','gif','jpg','jpeg','png','webp','bmp'],
        'allowed_docs'   => ['pdf','doc','docx','ppt','pptx','odp','txt','xls','xlsx','csv','zip','rar','7zip','pfx','p7s','cer'],
        'default'        => 10485760,           // 10 MB - Geral * = (10 * 1024 * 1024) = Bytes
        '5MB'            => 5242880,            // 5 MB - Bytes
        '10MB'           => 10485760,           // 10 MB - Bytes
        '15MB'           => 15728640,           // 15 MB - Bytes
        '20MB'           => 20971520,           // 20 MB - Bytes
        '25MB'           => 26214400,           // 25 MB - Bytes
        '30MB'           => 31457280,           // 30 MB - Bytes
    ]

];
