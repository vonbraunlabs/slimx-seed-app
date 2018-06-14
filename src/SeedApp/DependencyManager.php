<?php

namespace SeedApp;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Registry;
use SlimX\Models\Error;
use SlimX\Exceptions\ErrorCodeException;

class DependencyManager
{
    protected $container;

    public function __construct(\Slim\App $app)
    {
        $this->container = $app->getContainer();
    }

    public function loadDependencies()
    {
        $this->container['log'] = function ($container) {
            $conf = $container->get('settings')['logger'];
            $log = new Logger($conf['name']);
            $log->pushHandler(new StreamHandler(
                __DIR__ . '/../../logs/api-' .
                (new \DateTime())->format('Ymd') . '.log',
                $conf['level'] ?? Logger::DEBUG
            ));
            try {
                Registry::addLogger($log, 'log');
            } catch (\InvalidArgumentException $e) {
                // Log already exists. Let it go!
            }

            return $log;
        };

        $this->container['error'] = function ($container) {
            $error = new Error();
            $error->setCodeList([
                1000 => [
                    'status' => 406,
                    'message' => 'API version is mandatory',
                ],
            ]);

            return $error;
        };

        $this->container['errorHandler'] = function ($container) {
            return function ($request, $response, $exception) use ($container) {
                if ($exception instanceof ErrorCodeException) {
                    $container->get('log')->info('Error code ' . $exception->getCode());
                    return $container->get('error')->handle($response, $exception->getCode());
                }
            };
        };

        $this->container['testDbConnection'] = function ($container) {
            $dbTest = $container->get('settings')['dbtest'];
            return new \PDO(
                "mysql:host={$dbTest['host']};dbname={$dbTest['dbname']}",
                $dbTest['user'],
                $dbTest['pass']
            );
        };
    }
}
