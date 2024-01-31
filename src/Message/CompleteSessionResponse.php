<?php

namespace Omnipay\Windcave\Message;

class CompleteSessionResponse extends GetSessionResponse
{
    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return parent::isSuccessful() && $this->getTransactionAuthorised() === true;
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        return $this->getTransactionData('responseText') ?? parent::getMessage();
    }
}
