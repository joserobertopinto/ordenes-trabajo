<?php

return [
    'adminEmail'    => 'admin@example.com',
    'senderEmail'   => 'noreply@example.com',
    'senderName'    => 'Example.com mailer',
    'bsVersion'     => '4',
    'uploads'       => '/uploads/',
    'extensiones_documentos_orden'     => ['jpg', 'png','pdf'],
    'extensiones'                      => ['txt', 'doc', 'docx', 'odt', 'pdf'],
    'extensiones_imagen'               => ['jpg', 'png',],
    'maxFileSize'                      => 1024 * 1024 * 6, //3MB , Ojo ver php.ini upload_max_filesize=2MB es el que manda
];
