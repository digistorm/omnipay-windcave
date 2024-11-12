<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Message;

class GetSessionResponse extends AbstractResponse
{
    public function getSessionId(): ?string
    {
        return (string) $this->getDataItem('id');
    }

    public function getState(): ?string
    {
        return (string) $this->getDataItem('state');
    }

    public function getMerchantReference(): ?string
    {
        return (string) $this->getDataItem('merchantReference');
    }

    public function getTransactionId(): ?string
    {
        return (string) $this->getTransactionDataItem('id');
    }

    public function getTransactionAuthorised(): bool
    {
        return (bool) $this->getTransactionDataItem('authorised');
    }

    public function getCode(): ?string
    {
        return (string) $this->getTransactionDataItem('reCo');
    }

    public function getSettlementDate(): ?string
    {
        return (string) $this->getTransactionDataItem('settlementDate');
    }

    public function getMessage(): string
    {
        if ($this->isSuccessful()) {
            return (string) $this->getTransactionDataItem('responseText');
        }

        return parent::getMessage();
    }

    protected function getTransactionDataItem(string $key): bool|string|int|float|null
    {
        $item = $this->getTransactionData()[$key] ?? null;
        if (!(is_scalar($item) || is_null($item))) {
            throw new \InvalidArgumentException("Data item $key is not a scalar value");
        }

        return $item;
    }

    protected function getTransactionData(): ?array
    {
        if (empty($this->data['transactions'][0]) || !is_array($this->data['transactions'][0])) {
            return null;
        }

        return $this->data['transactions'][0];
    }
}
