<?php

namespace Omnipay\Windcave\Message;

class GetSessionResponse extends AbstractResponse
{
    public function getSessionId()
    {
        return $this->getData('id');
    }

    public function getState()
    {
        return $this->getData('state');
    }

    public function getMerchantReference()
    {
        return $this->getData('merchantReference');
    }

    public function getTransactionId()
    {
        return $this->getTransactionData('id');
    }

    public function getTransactionAuthorised()
    {
        return $this->getTransactionData('authorised');
    }

    public function getCode()
    {
        return $this->getTransactionData('reCo');
    }

    public function getSettlementDate()
    {
        return $this->getTransactionData('settlementDate');
    }

    public function getMessage()
    {
        if ($this->isSuccessful()) {
            return $this->getTransactionData('responseText');
        }

        return parent::getMessage();
    }

    protected function getTransactionData($key)
    {
        if (empty($this->data['transactions'][0]) || !is_array($this->data['transactions'][0])) {
            return null;
        }

        $transaction = $this->data['transactions'][0];

        return isset($transaction[$key]) ? $transaction[$key] : null;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionReference()
    {
        return $this->getSessionId();
    }
}
