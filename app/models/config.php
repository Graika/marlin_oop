<?php
//mysql:host=localhost;dbname=testapp;charset:utf8;", 'root', ''
return [
    "database_pdo" => [
        "database" => "testapp",
        "username" => "root",
        "password" => "",
        "connection" => "mysql:host=localhost",
        "charset" => "utf8",
    ],
    "database_lara" => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'testapp',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ],
];