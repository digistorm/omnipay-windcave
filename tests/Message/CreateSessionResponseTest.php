<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Test\Message;

use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\CreateSessionRequest;
use Omnipay\Windcave\Message\CreateSessionResponse;

class CreateSessionResponseTest extends TestCase
{
    public function testSuccessResponse(): void
    {
        $request = new CreateSessionRequest($this->getHttpClient(), $this->getHttpRequest());
        $responseBody = '
{
    "id": "00001100712231650b7aa766708118a5",
    "state": "init",
    "links": [
        {
            "href": "https://sec.paymentexpress.com/api/v1/sessions/00001100712231650b7aa766708118a5",
            "rel": "self",
            "method": "GET"
        },
        {
            "href": "https://sec.paymentexpress.com/pxmi3/E494B52F483B328E38A2D0EC9C9104A53891CD9F7DC26DF0BB9C2EBB0897F9855AEAF340A4A19600C",
            "rel": "submitCard",
            "method": "FORM_POST"
        }
    ]
}
        ';

        $response = new CreateSessionResponse($request, json_decode($responseBody, true));
        $response->setHttpResponseCode(202);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('00001100712231650b7aa766708118a5', $response->getSessionId());
        $this->assertEquals('init', $response->getState());
        $this->assertEquals('https://sec.paymentexpress.com/pxmi3/E494B52F483B328E38A2D0EC9C9104A53891CD9F7DC26DF0BB9C2EBB0897F9855AEAF340A4A19600C', $response->getPurchaseUrl());
    }

    public function testErrorResponse(): void
    {
        $request = new CreateSessionRequest($this->getHttpClient(), $this->getHttpRequest());
        $responseBody = '
{
    "requestId": "826569789",
    "timestampUtc": "2019-09-26T05:53:41Z",
    "errors": [
        {
            "target": "amount",
            "message": "Invalid value for amount"
        }
    ]
}        
        ';

        $response = new CreateSessionResponse($request, json_decode($responseBody, true));
        $response->setHttpResponseCode(400);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('Invalid value for amount', $response->getMessage());
    }
}
