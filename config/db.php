<?php
$postgres_ip    = '192.168.1.8';
$postgres_db    = 'local';
$postgres_user  = 'demo';
$postgres_pwd   = 'demo123';
// $enableCache    = true;
$postgres_port  = '5432';

return [
    'class'     => 'yii\db\Connection',
    'dsn'       => "pgsql:host=$postgres_ip;port=$postgres_port;dbname=$postgres_db",
    'username'  => $postgres_user,
    'password'  => $postgres_pwd,
    'charset'   => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
