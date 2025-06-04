<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Message;

use GuzzleHttp\Psr7\Response;
use Money\Money;
use Omnipay\Common\Message\AbstractRequest as CommonAbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

/**
 * @link https://www.windcave.com.au/rest-docs/index.html
 */
abstract class AbstractRequest extends CommonAbstractRequest
{
    protected string $endpoint = 'https://{{environment}}.windcave.com/api/v1';

    abstract public function getEndpoint(): string;

    abstract public function getResponseClass(): string;

    protected function baseEndpoint(): string
    {
        return str_replace('{{environment}}', $this->getTestMode() ? 'uat' : 'sec', $this->endpoint);
    }

    protected function wantsJson(): bool
    {
        return true;
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
    public function getUsername(): string
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

    public function getAmount(): string|Money|null
    {
        return $this->getParameter('amount');
    }

    /**
     * Retaining the original method signature
     * @param string|Money $value
     * @return self
     */
    public function setAmount($value): self
    {
        return $this->setParameter('amount', $value);
    }

    public function getCurrency(): ?string
    {
        return $this->getParameter('currency');
    }

    /**
     * Retaining the original method signature
     * @param string $value
     * @return self
     */
    public function setCurrency($value): self
    {
        return $this->setParameter('currency', $value);
    }

    public function getMerchantReference(): string
    {
        return $this->getParameter('merchantReference');
    }

    public function setMerchantReference(string $value): self
    {
        return $this->setParameter('merchantReference', $value);
    }

    abstract public function getContentType(): ?string;

    public function setContentType(string $value): self
    {
        return $this->setParameter('contentType', $value);
    }

    /**
     * Get HTTP method
     */
    public function getHttpMethod(): string
    {
        return 'GET';
    }

    /**
     * Get request headers
     */
    public function getRequestHeaders(): array
    {
        // common headers
        $headers = [
            'Content-Type' => $this->getContentType(), 
        ];

        if ($this->wantsJson()) {
            $headers['Accept'] = 'application/json';
        }

        return $headers;
    }

    /**
     * Send data request
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $username = $this->getUsername();
        $apiKey = $this->getApiKey();

        $headers = $this->getRequestHeaders();
        $headers['Authorization'] = 'Basic ' . base64_encode($username . ':' . $apiKey);

        // If wantsJson is false assume $data is a string and pass it directly.
        $body = (($this->wantsJson()) ? json_encode($data) : $data) ?: null;

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            $body
        );

        $responseClass = $this->getResponseClass();

        $responseData = $httpResponse->getBody()->getContents();
        $statusCode = $httpResponse->getStatusCode();

        if ($this->wantsJson()) {
            $responseData = json_decode($responseData, true);
        }

        $response = new $responseClass($this, $responseData);

        // save additional info
        /** @var AbstractResponse $response */
        $response->setHttpResponseCode((string) $statusCode);
        $response->setHeaders($response->getHeaders());

        $this->response = $response;

        return $this->response;
    }
}
