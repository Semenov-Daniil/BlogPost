<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=blog-post',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'tablePrefix' => 'bp_',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
