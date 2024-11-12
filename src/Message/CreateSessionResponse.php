<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Message;

class CreateSessionResponse extends AbstractResponse
{
    /**
     * Is the transaction successful?
     * @return boolean True if successful
     */
    public function isSuccessful(): bool
    {
        // get response code
        $code = $this->getHttpResponseCode();

        return ($code === '200' || $code === '201' || $code === '202');
    }

    public function isPending(): bool
    {
        return false;
    }

    public function getSessionId(): ?string
    {
        return (string)$this->getDataItem('id');
    }

    public function getState(): ?string
    {
        return (string)$this->getDataItem('state');
    }

    public function getPurchaseUrl(): ?string
    {
        $links = $this->getDataItemArray('links');
        foreach ($links as $link) {
            if ($link['rel'] === 'submitCard') {
                return $link['href'];
            }
        }

        return null;
    }
}
