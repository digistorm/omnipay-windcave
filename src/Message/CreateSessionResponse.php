<?php

namespace Omnipay\Windcave\Message;

class CreateSessionResponse extends AbstractResponse
{
    /**
     * Is the transaction successful?
     * @return boolean True if successful
     */
    public function isSuccessful()
    {
        // get response code
        $code = $this->getHttpResponseCode();

        return ($code === 200 || $code === 201 || $code === 202);
    }

    public function isPending()
    {
        return false;
    }

    public function getSessionId()
    {
        return $this->getData('id');
    }

    public function getState()
    {
        return $this->getData('state');
    }

    public function getPurchaseUrl()
    {
        $links = $this->getData('links');
        foreach ($links as $link) {
            if ($link['rel'] === 'submitCard') {
                return $link['href'];
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionReference()
    {
        return $this->getSessionId();
    }
}
