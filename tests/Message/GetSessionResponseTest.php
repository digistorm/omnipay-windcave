<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Test\Message;

use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\GetSessionRequest;
use Omnipay\Windcave\Message\GetSessionResponse;

class GetSessionResponseTest extends TestCase
{
    public function testSuccessResponse(): void
    {
        $request = new GetSessionRequest($this->getHttpClient(), $this->getHttpRequest());
        $responseBody = '
{
    "id": "00001100709737120b191f992762bccb",
    "state": "complete",
    "type": "purchase",
    "amount": "3.30",
    "currency": "NZD",
    "currencyNumeric": 554,
    "merchantReference": "Test",
    "expires": "2019-09-28T01:29:43Z",
    "storeCard": false,
    "clientType": "internet",
    "methods": [
        "card"
    ],
    "transactions": [
        {
            "id": "0000000b4abde5c3",
            "username": "DigistormRest_Dev",
            "authorised": true,
            "allowRetry": false,
            "reCo": "00",
            "responseText": "APPROVED",
            "authCode": "132956",
            "type": "purchase",
            "method": "card",
            "localTimeZone": "NZT",
            "dateTimeUtc": "2019-09-25T01:29:56Z",
            "dateTimeLocal": "2019-09-25T13:29:56+12:00",
            "settlementDate": "2019-09-25",
            "amount": "3.30",
            "balanceAmount": "0.00",
            "currency": "NZD",
            "currencyNumeric": 554,
            "clientType": "internet",
            "merchantReference": "Test",
            "card": {
                "cardHolderName": "STU DENT",
                "cardNumber": "411111......1111",
                "dateExpiryMonth": "04",
                "dateExpiryYear": "22",
                "type": "visa"
            },
            "cvc2ResultCode": "P",
            "sessionId": "00001100709737120b191f992762bccb"
        }
    ]
}
        ';

        $response = new GetSessionResponse($request, json_decode($responseBody, true));
        $response->setHttpResponseCode(200);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('00001100709737120b191f992762bccb', $response->getSessionId());
        $this->assertEquals('complete', $response->getState());
        $this->assertEquals('Test', $response->getMerchantReference());
        $this->assertEquals('0000000b4abde5c3', $response->getTransactionId());
        $this->assertEquals(true, $response->getTransactionAuthorised());
        $this->assertEquals('00', $response->getCode());
        $this->assertEquals('APPROVED', $response->getMessage());
    }

    public function testErrorResponse(): void
    {
        $request = new GetSessionRequest($this->getHttpClient(), $this->getHttpRequest());
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

        $response = new GetSessionResponse($request, json_decode($responseBody, true));
        $response->setHttpResponseCode(400);

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('Invalid value for amount', $response->getMessage());
    }
}
