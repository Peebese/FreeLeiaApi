<?php
/**
 * Created by PhpStorm.
 * User: philipbrown
 * Date: 12/11/2018
 * Time: 13:29
 */

namespace PhilipBrown\ThisIsBud\Tests;

use PhilipBrown\ThisIsBud\Application\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testAppConfig()
    {
        $configFile = __DIR__.'/../config/config.php';
        $configOptions = include $configFile;

        $this->assertTrue(file_exists($configFile),'Cannot find config file, should have been created during composer install, here: '.$configFile);
        $this->assertInternalType('array', $configOptions);

        $config = new Config();
        $this->assertInternalType('string',$config->getApiDomain());
        $this->assertInternalType('string',$config->getClientId());
        $this->assertInternalType('string',$config->getClientSecret());
    }
}