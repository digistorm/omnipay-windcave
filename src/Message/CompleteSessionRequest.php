<?php

namespace Omnipay\Windcave\Message;

use Omnipay\Windcave\Message\CompleteSessionResponse;

class CompleteSessionRequest extends GetSessionRequest
{
    /**
     * @inheritDoc
     */
    public function getResponseClass()
    {
        return CompleteSessionResponse::class;
    }
}
