<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Message;

use InvalidArgumentException;

class PurchaseResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        $code = $this->getHttpResponseCode();

        return $code === '302' && $this->getStatus() === 'approved';
    }

    protected function getLocationAttributeItem(string $key): bool|string|int|float|null
    {
        $item = $this->getLocationAttribute()[$key] ?? null;
        if (!(is_scalar($item) || is_null($item))) {
            throw new InvalidArgumentException("Data item $key is not a scalar value");
        }

        return $item;
    }

    protected function getLocationAttribute(): ?array
    {
        $headers = $this->getHeaders();
        if (empty($headers['Location'][0])) {
            return null;
        }

        $location = parse_url((string) $headers['Location'][0], PHP_URL_QUERY);
        parse_str((string) $location, $query);

        return $query;
    }

    public function getStatus(): ?string
    {
        return (string) $this->getLocationAttributeItem('status');
    }

    public function getSessionId(): ?string
    {
        return (string) $this->getLocationAttributeItem('sessionId');
    }

    public function getMessage(): string
    {
        return $this->getStatus();
    }
}
