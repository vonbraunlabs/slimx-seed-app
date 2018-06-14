<?php

namespace SeedApp\Tests\Controllers;

use SlimX\Tests\AbstractSlimXTest;
use SeedApp\Bootstrap;

class SanityTest extends AbstractSlimXTest
{
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
