<?php

namespace SeedApp\Controllers;

use Psr\Http\Message\RequestInterface;
use Slim\Http\Response;
use RedBeanPHP\R;
use SlimX\Controllers\AbstractController as AbstractXController;
use SlimX\Controllers\Action;
use SlimX\Exceptions\ErrorCodeException;

class DefaultController extends AbstractXController
{
    protected $logger;

    public function loadActions()
    {
        $handleWrongApi = [$this, 'handleApiVersionNotSpecified'];

        $this->pushEntrypoint(new Action(
            'GET',
            '/',
            ['application/vnd.seedapp.v1+json' => [$this, 'indexAction']],
            $handleWrongApi
        ));
    }

    public function handleApiVersionNotSpecified(Response $response): Response
    {
        return $this->container->get('error')->handle($response, 1000);
    }

    public function indexAction(
        RequestInterface $request,
        Response $response,
        array $args
    ) {
        $logger = $this->app->getContainer()->get('log');
        $logger->info('indexAction init');
        $response->write(json_encode(['pong']));

        return $response;
    }
}
