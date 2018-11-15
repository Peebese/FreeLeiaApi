<?php

namespace PhilipBrown\ThisIsBud\ApiClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

use PhilipBrown\ThisIsBud\Decryption\DataDecryptionService;
use PhilipBrown\ThisIsBud\Decryption\Message;
use PhilipBrown\ThisIsBud\Oauth2\Oauth2Client;
use PhilipBrown\ThisIsBud\Application\Config;

class ApiClientService
{
    private $oauth2Client;
    private $httpClient;
    private $config;
    private $dataDecryptionService;

    public function __construct(
        Oauth2Client $oauth2Client,
        ClientInterface $httpClient,
        DataDecryptionService $dataDecryptionService,
        Config $config
    ) {
        $this->oauth2Client             = $oauth2Client;
        $this->httpClient               = $httpClient;
        $this->config                   = $config;
        $this->dataDecryptionService    = $dataDecryptionService;
    }

    public function getData(): Message
    {
        $oAuthToken = $this->getOauth2Token();
        $this->deleteToken($oAuthToken);
        $getLeiaResponse = $this->getLeia($oAuthToken);
        $responseJson = Message::fromJsonString($getLeiaResponse);

        return $this->dataDecryptionService->decrypt($responseJson);
    }

    private function getOauth2Token():string
    {
        return $this->oauth2Client->getAccessToken(
            $this->httpClient,
            $this->config->getClientId(),
            $this->config->getClientSecret(),
            $this->config->getApiDomain()
        );
    }

    private function getLeia(string $accessToken): string
    {
        $request = new Request(
            'GET',
            $this->config->getApiDomain().'/prisoner/leia',
            [
                'Authorization' => 'Bearer '.$accessToken,
                'Content-Type' => 'application/json'
            ]
        );

        $response = $this->httpClient->send($request);
        $response->getBody()->rewind();

        return $response->getBody()->getContents();
    }

    private function deleteToken(string $accessToken)
    {
        $request = new Request(
            'DELETE',
            $this->config->getApiDomain().'/reactor/exhaust/1',
            [
                'Authorization' => 'Bearer '.$accessToken,
                'Content-Type' => 'application/json',
                'x-torpedoes' => '2'
            ]
        );

        $this->httpClient->send($request);
    }
}