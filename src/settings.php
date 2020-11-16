<?php
// Altere as Configurações e renomeie para settings.php
return [
    'settings' => [
        'debug' => true,
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'logger' => [
            'name' => 'Encontros Universitarios',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ .DIRECTORY_SEPARATOR.'..'. DIRECTORY_SEPARATOR . 'logs'. DIRECTORY_SEPARATOR .'app.log',
        ],
        'db'=>[
            'type' => 'mysql',
            'host' => 'db',
            'user' => 'user',
            'pass' => 'password',
            'dbname' => 'EU',
            'port' => 3306
        ],
        'api' => 'http://n2s.russas.ufc.br:8080/digital-valley-restapi/evento/{id_evento}/trabalho'
]];