<?php
use \Medoo\Medoo;
use \Twig\TwigFilter;

return function ($app) {
    // Register component on container
    $app->getContainer()['view'] = function ($container) {
        $view = new \Slim\Views\Twig('src'. DIRECTORY_SEPARATOR .'views', [
            // 'cache' => 'src/views-cache'
        ]);
        $filter = new TwigFilter('truncate',function ($string, $length=255, $end='...'){
            if(strlen($string) > $length)
                return substr($string, 0, $length - $end) . $end;
            else
                return $string;
        });
        $view->getEnvironment()->addFilter($filter);
        // Instantiate and add Slim specific extension
        $router = $container->get('router');
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

        return $view;
    };

    // monolog
    $app->getContainer()['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    // db - medoo
    $app->getContainer()['db'] = function ($c) {
        $settings = $c->get('settings')['db'];
        return new Medoo([
            'database_type' => $settings['type'],
            'database_name' => $settings['dbname'],
            'server' => $settings['host'],
            'username' => $settings['user'],
            'password' => $settings['pass'],
            'port' => $settings['port']
        ]);
    };


};
