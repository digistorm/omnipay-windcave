<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Test\Message;

use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\PurchaseRequest;
use Omnipay\Windcave\Message\PurchaseResponse;

class PurchaseResponseTest extends TestCase
{
    public function testSuccessResponse(): void
    {
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $responseBody = '
<head><title>Document Moved</title></head>
<body><h1>Object Moved</h1>This document may be found <a HREF="http://example.com?status=approved&amp;sessionId=00001100712231650b7aa766708118a5">here</a></body>
        ';

        $response = new PurchaseResponse($request, $responseBody);
        $response->setHttpResponseCode(302);
        $response->setHeaders([
            'Content-Type' => ['text/html; charset=utf-8'],
            'Location' => ['http://example.com?status=approved&sessionId=00001100712231650b7aa766708118a5'],
        ]);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('00001100712231650b7aa766708118a5', $response->getSessionId());
        $this->assertEquals('approved', $response->getStatus());
    }

    public function testErrorResponse(): void
    {
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $responseBody = '
<head><title>Document Moved</title></head>
<body><h1>Object Moved</h1>This document may be found <a HREF="http://example.com?status=declined&amp;sessionId=00001100712231650b7aa766708118a5">here</a></body>
        ';

        $response = new PurchaseResponse($request, $responseBody);
        $response->setHttpResponseCode(302);
        $response->setHeaders([
            'Content-Type' => ['text/html; charset=utf-8'],
            'Location' => ['http://example.com?status=declined&sessionId=00001100712231650b7aa766708118a5'],
        ]);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('declined', $response->getStatus());
    }
}
