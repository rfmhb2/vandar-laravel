<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Vandar\Driver\RestDriver;
use Vandar\Vandar;

class GatewayTest extends TestCase
{
    private $gateway;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gateway = new Vandar("b44fbd8273bd9988900a64c7b969593b5d004046", new RestDriver());
    }

    public function testPaymentRequest()
    {
        $response = $this->gateway->request("2000", "http://localhost");
        self::assertNotNull($response);
        self::assertNotNull($response['token']);
        self::assertEquals($response['status'], 1);
        return $response;
    }

    /**
     * @depends testPaymentRequest
     * @param $response
     */
    public function testRedirect($response)
    {
        $targetUrl = "https://vandar.io/ipg/" . $response['token'];
        $acceptedUrl = $this->gateway->redirectUrl($response['token']);
        self::assertEquals($acceptedUrl, $targetUrl);
    }

    /**
     * @depends testPaymentRequest
     * @param $response
     */
    public function testVerify($response)
    {
        $result = $this->gateway->verify($response['token']);
        self::assertEquals($result['status'], 0);
    }
}