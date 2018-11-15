<?php

use GuzzleHttp\Client;
use DI\Container;
use PhilipBrown\ThisIsBud\ApiClient\ApiClientService;
use PhilipBrown\ThisIsBud\Application\Config;
use PhilipBrown\ThisIsBud\Decryption\DataDecryptionService;
use PhilipBrown\ThisIsBud\Oauth2\LeaguePhp;

return [

    'message-decryption-service' => function () {
        return new DataDecryptionService();
    },

    'api-client-service'  => function (Container $container) {

        $oauth2Client = new LeaguePhp();
        $httpClient = $container->get('http-client');
        $messageDecryptionService = $container->get('message-decryption-service');
        $config = new Config();

        return new ApiClientService($oauth2Client, $httpClient, $messageDecryptionService, $config);
    },

    'http-client' => function () {
        return new Client();
    },

];
