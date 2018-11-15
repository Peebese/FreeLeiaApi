<?php

namespace PhilipBrown\ThisIsBud\Oauth2;

use GuzzleHttp\ClientInterface;

interface Oauth2Client
{
  public function getAccessToken(ClientInterface $httpClient, string $clientId, string $clientSecret, string $apiDomain);
}