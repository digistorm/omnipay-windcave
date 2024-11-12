<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Test\Message;

use Money\Currency;
use Money\Money;
use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\CreateSessionRequest;

class CreateSessionRequestTest extends TestCase
{
    /**
     * @var CreateSessionRequest
     */
    protected $request;

    public function setUp(): void
    {
        $this->request = new CreateSessionRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->setMoney(new Money(1000, new Currency('NZD')));
    }

    public function testEndpoint(): void
    {
        $this->request->setTestMode(true);
        $this->assertSame('https://uat.windcave.com/api/v1/sessions', $this->request->getEndpoint());
        $this->request->setTestMode(false);
        $this->assertSame('https://sec.windcave.com/api/v1/sessions', $this->request->getEndpoint());
    }

    public function testGetData(): void
    {
        $this->request->setMerchantReference('ABC123');

        $data = $this->request->getData();

        $this->assertEquals('purchase', $data['type']);
        $this->assertEquals('10.00',    $data['amount']);
        $this->assertEquals('NZD',      $data['currency']);
        $this->assertEquals('ABC123',   $data['merchantReference']);
        $this->assertEquals(0,          $data['storeCard']);
    }
}
