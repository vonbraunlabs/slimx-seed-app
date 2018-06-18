<?php

namespace SeedApp\Tests\Models\Tables;

use Psr\Log\LoggerInterface;
use PHPUnit\DbUnit\DataSet\YamlDataSet;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;
use RedBeanPHP\OODBBean;
use RedBeanPHP\R;
use SlimX\Exceptions\ErrorCodeException;
use SlimX\Tests\AbstractSlimXTest;
use SlimX\Tests\WebTestClient;

abstract class AbstractTestTable extends TestCase
{
    use TestCaseTrait;

    protected $logger;

    protected function getFullPath(string $file)
    {
        for ($i = 0;
            !file_exists($fullPath = __DIR__ . '/' . str_repeat('../', $i) . $file) && $i < 100;
            $i++) {
        }
        return $fullPath;
    }

    protected function setUpRedBean()
    {
        $settings = require $this->getFullPath('config/application.php');
        $conf = $settings['settings']['db'];
        $strConn = "mysql:host={$conf['host']};dbname={$conf['dbname']}";
        if (!R::testConnection()) {
            R::setup($strConn, $conf['user'], $conf['pass']);
            R::ext('xdispense', function ($type) {
                return R::getRedBean()->dispense($type);
            });
        }
    }

    public function getMockLogger()
    {
        $this->setUpRedBean();
        $mock = $this->getMockBuilder('Psr\Log\LoggerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $mock->method('info')
            ->willReturn(null);
        $mock->method('error')
            ->willReturn(null);
        $mock->method('debug')
            ->willReturn(null);

        return $mock;
    }

    public function testMockLogger()
    {
        $logger = $this->getMockLogger();

        $this->assertNull($logger->info('bla'));
        $this->assertNull($logger->error('bla'));
    }

    public function testGetFullPath()
    {
        $this->assertFileExists($this->getFullPath('config/application.php'));
        $this->assertFileExists($this->getFullPath('fixtures/main.yaml'));
    }

    public function testSanity()
    {
        $this->assertTrue(true);
    }

    public function getConnection()
    {
        $settings = require $this->getFullPath('config/application.php');
        $dbTest = $settings['settings']['dbtest'];
        $pdo = new \PDO(
            "mysql:host={$dbTest['host']};dbname={$dbTest['dbname']}",
            $dbTest['user'],
            $dbTest['pass']
        );
        return $this->createDefaultDBConnection($pdo);
    }

    public function getDataSet()
    {
        $yaml = new YamlDataSet($this->getFullPath('fixtures/main.yaml'));

        return $yaml;
    }
}
