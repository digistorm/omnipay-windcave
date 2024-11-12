<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Test\Message;

use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\GetSessionRequest;

class GetSessionRequestTest extends TestCase
{
    /**
     * @var GetSessionRequest
     */
    protected $request;

    public function setUp(): void
    {
        $this->request = new GetSessionRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->setSessionId('SESS01234');
    }

    public function testEndpoint(): void
    {
        $this->request->setTestMode(true);
        $this->assertSame('https://uat.windcave.com/api/v1/sessions/SESS01234', $this->request->getEndpoint());
        $this->request->setTestMode(false);
        $this->assertSame('https://sec.windcave.com/api/v1/sessions/SESS01234', $this->request->getEndpoint());
    }

    public function testGetData(): void
    {
        $this->assertEmpty($this->request->getData());
    }
}
