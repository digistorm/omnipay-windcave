<?php

namespace Omnipay\Windcave;

use Omnipay\Common\AbstractGateway;
use Omnipay\Windcave\Message\CompleteSessionRequest;
use Omnipay\Windcave\Message\CreateHppSessionRequest;
use Omnipay\Windcave\Message\CreateSessionRequest;
use Omnipay\Windcave\Message\GetHppSessionRequest;
use Omnipay\Windcave\Message\GetSessionRequest;
use Omnipay\Windcave\Message\PurchaseRequest;

/**
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())         (Optional method)
 *         Authorize an amount on the customers card
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array()) (Optional method)
 *         Handle return from off-site gateways after authorization
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())           (Optional method)
 *         Capture an amount you have previously authorized
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())  (Optional method)
 *         Handle return from off-site gateways after purchase
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())            (Optional method)
 *         Refund an already processed transaction
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())              (Optional method)
 *         Generally can only be called up to 24 hours after submitting a transaction
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())        (Optional method)
 *         The returned response object includes a cardReference, which can be used for future transactions
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())        (Optional method)
 *         Update a stored card
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())        (Optional method)
 *         Delete a stored card
 */
class Gateway extends AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName()
    {
        return 'Windcave REST API';
    }

    /**
     * Get gateway short name
     *
     * This name can be used with GatewayFactory as an alias of the gateway class,
     * to create new instances of this gateway.
     * @return string
     */
    public function getShortName()
    {
        return 'Windcave';
    }

    public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
            'username'   => '',
            'callbackUrls' => [
                'approved' => 'http://example.com?status=approved',
                'declined' => 'http://example.com?status=declined',
                'cancelled' => 'http://example.com?status=cancelled',
            ],
        );
    }

    /**
     * Get API publishable key
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set API publishable key
     * @param  string $value API publishable key
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * Get Callback URLs associative array (approved, declined, cancelled)
     * @return array
     */
    public function getCallbackUrls()
    {
        return $this->getParameter('callbackUrls');
    }

    /**
     * Set Callback URLs associative array (approved, declined, cancelled)
     * @param array $value
     */
    public function setCallbackUrls($value)
    {
        return $this->setParameter('callbackUrls', $value);
    }

    /**
     * Get Merchant
     * @return string Merchant ID
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * Set Merchant
     * @param  string $value Merchant ID
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Purchase request
     *
     * @param array $parameters
     * @return \Omnipay\Windcave\Message\PurchaseRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * Create sessionId with a CreditCard
     *
     * @param array $parameters
     * @return \Omnipay\Windcave\Message\CreateSessionRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function createSession(array $parameters = array())
    {
        return $this->createRequest(CreateSessionRequest::class, $parameters);
    }

    /**
     * Create sessionId with a CreditCard
     *
     * @param array $parameters
     * @return \Omnipay\Windcave\Message\GetSessionRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function getSession(array $parameters = array())
    {
        return $this->createRequest(GetSessionRequest::class, $parameters);
    }

    /**
     * Complete a session.
     *
     * @param array $parameters
     * @return \Omnipay\Windcave\Message\CompleteSessionRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function completeSession(array $parameters = array())
    {
        return $this->createRequest(CompleteSessionRequest::class, $parameters);
    }

    /**
     * Create a Hosted Payment Page session.
     *
     * @param array $parameters
     * @return \Omnipay\Windcave\Message\CreateHppSessionRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function createHppSession(array $parameters = array())
    {
        return $this->createRequest(CreateHppSessionRequest::class, $parameters);
    }

    /**
     * Get a Hosted Payment Page session.
     *
     * @param array $parameters
     * @return \Omnipay\Windcave\Message\GetHppSessionRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function getHppSession(array $parameters = array())
    {
        return $this->createRequest(GetHppSessionRequest::class, $parameters);
    }
}
