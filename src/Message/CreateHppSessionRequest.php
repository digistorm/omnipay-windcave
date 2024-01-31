<?php

namespace Omnipay\Windcave\Message;

use Omnipay\Windcave\Message\CreateSessionRequest;
use Omnipay\Windcave\Message\HppSessionRedirectResponse;

class CreateHppSessionRequest extends CreateSessionRequest
{
    /**
     * @inheritDoc
     */
    public function getResponseClass()
    {
        return HppSessionRedirectResponse::class;
    }
}
