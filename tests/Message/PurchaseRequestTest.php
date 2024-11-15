<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 18/06/17
 * Time: 21:30
 */

namespace Omnipay\Windcave\Test\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;
use Omnipay\Windcave\Message\PurchaseRequest;

class PurchaseRequestTest extends TestCase
{
    private PurchaseRequest $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetDataInvalid(): void
    {
        $this->expectExceptionMessage('You must pass a "card" parameter.');
        $this->expectException(\Omnipay\Common\Exception\InvalidRequestException::class);
        $this->request->setCard(null);

        $this->request->getData();
    }

    public function testGetDataWithCard(): void
    {
        $card = $this->getValidCard();
        $this->request->setCard(new CreditCard($card));
        $this->request->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');

        $formPostEndpoint = 'https://sec.paymentexpress.com/pxmi3/E494B52F483B328E38A2D0EC9C9104A53891CD9F7DC26DF0BB9C2EBB0897F9855AEAF340A4A19600C';

        $this->request->setEndpoint($formPostEndpoint);

        $data = $this->request->getData();

        $expiryMonth = sprintf('%02d', $card['expiryMonth']);
        $expiryYear = substr((string) $card['expiryYear'], -2);
        $name = $card['firstName'] . ' ' . $card['lastName'];

        $this->assertEquals($card['number'], $data['CardNumber']);
        $this->assertEquals($expiryMonth, $data['ExpiryMonth']);
        $this->assertEquals($expiryYear, $data['ExpiryYear']);
        $this->assertEquals($name, $data['CardHolderName']);
        $this->assertEquals($card['cvv'], $data['Cvc2']);
        // Ensure the description is limited to 64 chars
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do ', $data['MerchantReference']);

        $this->assertEquals($formPostEndpoint, $this->request->getEndpoint());
    }
}
