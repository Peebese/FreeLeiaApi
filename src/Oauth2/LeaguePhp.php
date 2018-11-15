<?php
/**
 * Created by PhpStorm.
 * User: philipbrown
 * Date: 13/11/2018
 * Time: 08:22
 */

namespace PhilipBrown\ThisIsBud\Oauth2;

use GuzzleHttp\ClientInterface;
use League\OAuth2\Client\Provider\GenericProvider;

class LeaguePhp implements Oauth2Client
{
    public function getAccessToken(ClientInterface $httpClient, string $clientId, string $clientSecret, string $domain): string
    {
        $options = [
            'urlAuthorize' => '​',
            'urlAccessToken' => $domain . '/Token',
            'urlResourceOwnerDetails' => '',
        ];

        $provider = new GenericProvider($options, ['httpClient' => $httpClient]);


        return $provider->getAccessToken(
            'client_credentials',
            [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
            ]
        );
    }
}