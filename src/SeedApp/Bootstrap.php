<?php

namespace SeedApp;

use RedBeanPHP\R;
use Slim\App;
use Slim\Container;
use SeedApp\Controllers\DefaultController;
use SeedApp\DependencyManager;
use SeedApp\Middleware;

class Bootstrap
{
    protected $app;

    public function __construct()
    {
        $this->app = null;
    }

    public function generateApp(): App
    {
        if (null !== $this->app) {
            return $this->app;
        }

        $settings = require __DIR__ . '/../../config/application.php';
        $container = new Container($settings);

        $conf = $container->get('settings')['db'];
        $strConn = "mysql:host={$conf['host']};dbname={$conf['dbname']}";
        if (!R::testConnection()) {
            R::setup($strConn, $conf['user'], $conf['pass']);
            R::ext('xdispense', function ($type) {
                return R::getRedBean()->dispense($type);
            });
            R::freeze(true);
        }

        $app = new App($container);

        $dependencyManager = new DependencyManager($app);
        $dependencyManager->loadDependencies();

        $middleware = new Middleware($app);
        $middleware->loadMiddleware();

        $controller = new DefaultController($app);
        $controller->loadActions();

        $this->app = $app;
        return $this->app;
    }
}
