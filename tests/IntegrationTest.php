<?php
namespace PhilipBrown\ThisIsBud\Tests;

use PHPUnit\Framework\TestCase;
use PhilipBrown\ThisIsBud\ApiClient\ApiClientService;
use PhilipBrown\ThisIsBud\Application\ContainerBuilder;

class IntegrationTest extends TestCase
{
    /** @var ApiClientService */
    private $apiClientService;

    /** @var DecoyHttpClient */
    private $dummyHttpClient;

    public function setUp()
    {
        $container = (new ContainerBuilder())->buildContainer();

        $this->dummyHttpClient = new DecoyHttpClient();
        $container->set('http-client', $this->dummyHttpClient);

        $this->apiClientService = $container->get('api-client-service');
    }

    public function testReactorExhaustDeletion()
    {
        $this->apiClientService->getData();
        $exhaustRequest = $this->dummyHttpClient->getRequestsReceived()[1];

        $this->assertEquals('DELETE', $exhaustRequest->getMethod());
        $this->assertEquals(['application/json'], $exhaustRequest->getHeader('Content-Type'));
        $this->assertEquals(['Bearer e31a726c4b90462ccb7619e1b51f3d0068bf8006'], $exhaustRequest->getHeader('Authorization'));
        $this->assertEquals(['2'], $exhaustRequest->getHeader('x-torpedoes'));
    }

    public function testOauth2Integration()
    {
        $this->apiClientService->getData();
        $oauth2Request = $this->dummyHttpClient->getRequestsReceived()[0];

        $this->assertEquals('POST', $oauth2Request->getMethod());
        $this->assertEquals(['application/x-www-form-urlencoded'], $oauth2Request->getHeader('content-type'));
        $this->assertEquals(
            'client_id=R2D2&client_secret=Alderan&grant_type=client_credentials',
            $oauth2Request->getBody()->getContents()
        );
    }

    public function testResponseDecryption()
    {
        $response = $this->apiClientService->getData();
        $this->assertEquals('Detention Block AA-23,', $response->getBlock());
        $this->assertEquals('Cell 2187', $response->getCell());
    }

    public function testRescueLeia()
    {
        $this->apiClientService->getData();
        $exhaustRequest = $this->dummyHttpClient->getRequestsReceived()[2];

        $this->assertEquals('GET', $exhaustRequest->getMethod());
        $this->assertEquals(['application/json'], $exhaustRequest->getHeader('Content-Type'));
        $this->assertEquals(['Bearer e31a726c4b90462ccb7619e1b51f3d0068bf8006'], $exhaustRequest->getHeader('Authorization'));
    }

}
