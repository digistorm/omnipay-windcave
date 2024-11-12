<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Test\Message;

use Mockery;
use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\AbstractRequest;

class AbstractRequestTest extends TestCase
{
    public $request;

    public function setUp(): void
    {
        $this->request = Mockery::mock(AbstractRequest::class)->makePartial();
        $this->request->initialize();
    }

    public function testApiKey(): void
    {
        $this->assertSame($this->request, $this->request->setApiKey('abc123'));
        $this->assertSame('abc123', $this->request->getApiKey());
    }

    public function testUsername(): void
    {
        $this->assertSame($this->request, $this->request->setUsername('abc123'));
        $this->assertSame('abc123', $this->request->getUsername());
    }
}
