<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Message;

use Omnipay\Common\Message\AbstractResponse as CommonAbstractResponse;

/**
 * Response class for all Windcave requests
 */
class AbstractResponse extends CommonAbstractResponse
{
    protected string $httpResponseCode;

    protected array $headers = [];

    /**
     * Is the transaction successful?
     * @return boolean True if successful
     */
    public function isSuccessful(): bool
    {
        // get response code
        $code = $this->getHttpResponseCode();

        return ($code === '200' || $code === '201');
    }

    /**
     * Is the transaction still processing? We will need to fetch it again
     */
    public function isPending(): bool
    {
        return $this->getHttpResponseCode() === '202';
    }

    public function getDataItemArray(string $key): ?array
    {
        $item = $this->getData()[$key] ?? null;
        if (!(is_array($item) || is_null($item))) {
            throw new \InvalidArgumentException("Data item $key is not an array");
        }

        return $item;
    }

    public function getDataItem(string $key): bool|string|int|float|null
    {
        $item = $this->getData()[$key] ?? null;
        if (!(is_scalar($item) || is_null($item))) {
            throw new \InvalidArgumentException("Data item $key is not a scalar value");
        }

        return $item;
    }

    /**
     * Get response data, optionally by key
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get HTTP Response Code
     */
    public function getHttpResponseCode(): string
    {
        return $this->httpResponseCode;
    }

    /**
     * Set HTTP Response Code
     */
    public function setHttpResponseCode(string $value): self
    {
        $this->httpResponseCode = $value;

        return $this;
    }

    /**
     * Get headers array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $value): self
    {
        $this->headers = $value;

        return $this;
    }

    public function getMessage(): string
    {
        if (!$this->isSuccessful()) {
            $errors = $this->getDataItemArray('errors');
            return empty($errors[0]['message']) ? 'Unknown error' : $errors[0]['message'];
        }

        return 'Success';
    }
}
