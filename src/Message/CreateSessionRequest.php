<?php

namespace Omnipay\Windcave\Message;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\RequestInterface;

/**
 * @link https://px5.docs.apiary.io/#reference/0/sessions/create-session
 */
class CreateSessionRequest extends AbstractRequest implements RequestInterface
{
    /**
     * @return string
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $data = [
            'type' => 'purchase',
            'currency' => $this->getCurrency(),
            'merchantReference' => substr($this->getMerchantReference(), 0, 64),
            'storeCard' => 0,
            'callbackUrls' => $this->getCallbackUrls(),
            // Add customer data so that risk management (such as 3DS) can be utilised.
            'customer' => $this->getCustomer(),
        ];

        // Has the Money class been used to set the amount?
        if ($this->getAmount() instanceof Money) {
            // Ensure principal amount is formatted as decimal string e.g. 50.00
            $data['amount'] = (new DecimalMoneyFormatter(new ISOCurrencies()))->format($this->getAmount());
        } else {
            $data['amount'] = $this->getAmount();
        }

        return json_encode($data);
    }

    /**
     * Get the customer data.
     *
     * @return array|null
     */
    protected function getCustomer(): ?array
    {
        $customer = null;
        $card = $this->getCard();
        if ($card) {
            $customer = [
                'firstName' => $card->getFirstName(),
                'lastName' => $card->getLastName(),
                'phoneNumber' => $card->getPhone(),
                // TODO: Consider adding support for the `homePhoneNumber` and `account` fields.
                // 'homePhoneNumber' => ???,
                // 'account' => ???,
                'email' => $card->getEmail(),
                'billing' => $this->getBillingAddress(),
                'shipping' => $this->getShippingAddress(),
            ];
        }
        return $customer;
    }

    /**
     * Get the billing address data.
     *
     * @return array|null
     */
    protected function getBillingAddress(): ?array
    {
        $billingAddress = null;
        $card = $this->getCard();
        if ($card) {
            $billingAddress = [
                'name' => $card->getBillingName(),
                'address1' => $card->getBillingAddress1(),
                'address2' => $card->getBillingAddress2(),
                // TODO: Consider adding support for the `address3` field.
                // 'address3' => ???,
                'city' => $card->getBillingCity(),
                'postalCode' => $card->getBillingPostCode(),
                'state' => $card->getBillingState(),
                'countryCode' => $card->getBillingCountry(),
                'phoneNumber' => $card->getBillingPhone(),
            ];
        }
        return $billingAddress;
    }

    /**
     * Get the shipping address data.
     *
     * @return array|null
     */
    protected function getShippingAddress(): ?array
    {
        $shippingAddress = null;
        $card = $this->getCard();
        if ($card) {
            $shippingAddress = [
                'name' => $card->getShippingName(),
                'address1' => $card->getShippingAddress1(),
                'address2' => $card->getShippingAddress2(),
                // TODO: Consider adding support for the `address3` field.
                // 'address3' => ???,
                'city' => $card->getShippingCity(),
                'postalCode' => $card->getShippingPostCode(),
                'state' => $card->getShippingState(),
                'countryCode' => $card->getShippingCountry(),
                'phoneNumber' => $card->getShippingPhone(),
            ];
        }
        return $shippingAddress;
    }

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->baseEndpoint() . '/sessions';
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

    public function getContentType()
    {
        return 'application/json';
    }

    public function getResponseClass()
    {
        return CreateSessionResponse::class;
    }
}
