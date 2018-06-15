<?php

namespace SeedApp\Tests\Controllers;

use PHPUnit\DbUnit\TestCaseTrait;
use SeedApp\Bootstrap;
use SlimX\Tests\AbstractSlimXTest;

class SanityTest extends AbstractSlimXTest
{
    protected $method = 'GET';
    protected $endpoint = '/';
    protected $requestHeaders = [
        'HTTP_ACCEPT' => 'application/vnd.seedapp.v1+json',
    ];

    public function testSanity()
    {
        $this->assertTrue(true);
    }

    public function getValidData(): array
    {
        return [];
    }

    public function getSlimInstance()
    {
        return (new Bootstrap())->generateApp();
    }
}
