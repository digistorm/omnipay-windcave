<?php

namespace Omnipay\Windcave\Message;

use Omnipay\Windcave\Message\HppSessionRedirectResponse;

class GetHppSessionRequest extends GetSessionRequest
{
    /**
     * @inheritDoc
     */
    public function getResponseClass()
    {
        return HppSessionRedirectResponse::class;
    }
}
