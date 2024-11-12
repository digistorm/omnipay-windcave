<?php

declare(strict_types=1);

namespace Omnipay\Windcave;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Windcave\Message\CreateSessionRequest;
use Omnipay\Windcave\Message\GetSessionRequest;
use Omnipay\Windcave\Message\PurchaseRequest;

/**
 * @method RequestInterface authorize(array $options = []) (Optional method)
 * Authorize an amount on the customers card
 * @method RequestInterface completeAuthorize(array $options = []) (Optional method)
 * Handle return from off-site gateways after authorization
 * @method RequestInterface capture(array $options = []) (Optional method)
 * Capture an amount you have previously authorized
 * @method RequestInterface completePurchase(array $options = []) (Optional method)
 * Handle return from off-site gateways after purchase
 * @method RequestInterface refund(array $options = []) (Optional method)
 * Refund an already processed transaction
 * @method RequestInterface void(array $options = []) (Optional method)
 * Generally can only be called up to 24 hours after submitting a transaction
 * @method RequestInterface createCard(array $options = []) (Optional method)
 * The returned response object includes a cardReference, which can be used for future transactions
 * @method RequestInterface updateCard(array $options = []) (Optional method)
 * Update a stored card
 * @method RequestInterface deleteCard(array $options = []) (Optional method)
 * Delete a stored card
 */
class Gateway extends AbstractGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName(): string
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
    public function getShortName(): string
    {
        return 'Windcave';
    }

    public function getDefaultParameters(): array
    {
        return ['apiKey' => '', 'username' => '', 'callbackUrls' => [
            'approved' => 'http://example.com?status=approved',
            'declined' => 'http://example.com?status=declined',
            'cancelled' => 'http://example.com?status=cancelled',
        ]];
    }

    /**
     * Get API publishable key
     */
    public function getApiKey(): ?string
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set API publishable key
     */
    public function setApiKey(string $value): self
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * Get Callback URLs associative array (approved, declined, cancelled)
     */
    public function getCallbackUrls(): mixed
    {
        return $this->getParameter('callbackUrls');
    }

    /**
     * Set Callback URLs associative array (approved, declined, cancelled)
     */
    public function setCallbackUrls(mixed $value): self
    {
        return $this->setParameter('callbackUrls', $value);
    }

    /**
     * Get Merchant
     */
    public function getUsername(): ?string
    {
        return $this->getParameter('username');
    }

    /**
     * Set Merchant
     */
    public function setUsername(string $value): self
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Purchase request
     *
     * @return PurchaseRequest|AbstractRequest
     */
    public function purchase(array $options = []): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    /**
     * Create sessionId with a CreditCard
     */
    public function createSession(array $options = []): AbstractRequest
    {
        return $this->createRequest(CreateSessionRequest::class, $options);
    }

    /**
     * Create sessionId with a CreditCard
     */
    public function getSession(array $options = []): AbstractRequest
    {
        return $this->createRequest(GetSessionRequest::class, $options);
    }
}
