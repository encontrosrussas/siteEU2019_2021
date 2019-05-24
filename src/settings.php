<?php

return [
    'settings' => [
        'debug' => true,
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ .'\..'. DIRECTORY_SEPARATOR . 'logs'. DIRECTORY_SEPARATOR .'app.log',
        ],
        'db'=>[
            'type' => 'mysql', 
            'host' => 'localhost', 
            'user' => '' ,
            'pass' => '' ,
            'dbname' => '' 
        ]
]];