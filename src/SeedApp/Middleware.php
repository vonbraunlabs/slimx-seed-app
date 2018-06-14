<?php

namespace SeedApp;

use Slim\App;

class Middleware
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function loadMiddleware()
    {
        $this->app->add(function ($request, $response, $next) {
            $response = $response->
                withAddedHeader('Access-Control-Allow-Origin', $request->getHeader('Origin'))->
                withAddedHeader('Access-Control-Allow-Credentials', 'true')->
                withAddedHeader('Access-Control-Expose-Headers', 'X-TOTAL-COUNT')->
                withAddedHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')->
                withAddedHeader(
                    'Access-Control-Allow-Headers',
                    'X-XSRF-TOKEN, Content-Type, X-REQUEST-TOTAL-COUNT, Authorization'
                );
            $response = $next($request, $response);
            return $response;
        });

        $this->app->add(function ($request, $response, $next) {
            $response = $response->
                withHeader('Content-Type', 'application/vnd.seedapp.v1+json');

            $response = $next($request, $response);
            return $response;
        });
    }
}
