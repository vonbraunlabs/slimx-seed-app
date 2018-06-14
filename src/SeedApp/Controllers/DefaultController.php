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
            'POST',
            '/put/datapoints',
            ['application/vnd.seedapp.v1+json' => [$this, 'putDatapointsAction']],
            $handleWrongApi
        ));
    }

    public function handleApiVersionNotSpecified(Response $response): Response
    {
        return $this->container->get('error')->handle($response, 1000);
    }

    public function putDatapointsAction(
        RequestInterface $request,
        Response $response,
        array $args
    ) {
        $logger = $this->app->getContainer()->get('log');
        $logger->info('putDatapointsAction init');

        return $response;
    }
}
