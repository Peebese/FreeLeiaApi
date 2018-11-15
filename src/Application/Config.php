<?php
/**
 * Created by PhpStorm.
 * User: philipbrown
 * Date: 10/11/2018
 * Time: 20:28
 */

namespace PhilipBrown\ThisIsBud\Application;


class Config
{
    private const CONFIG_FILE = __DIR__.'/../../config/config.php';
    private $config;

    private function getConfigData(): array
    {
        if (!$this->config) {

            if (!file_exists(static::CONFIG_FILE)) {
                throw new \Exception('Error locating ' . static::CONFIG_FILE . ' file, please make sure you run Composer Install.');
            }

            $this->config = include static::CONFIG_FILE;
        }

        return $this->config;
    }

    public function getClientId(): string
    {
        return $this->getConfigData()['client_id'];
    }

    public function getClientSecret(): string
    {
        return $this->getConfigData()['client_secret'];
    }

    public function getApiDomain(): string
    {
        return $this->getConfigData()['api_domain'];
    }

}