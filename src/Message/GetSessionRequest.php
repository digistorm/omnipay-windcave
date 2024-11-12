<?php

declare(strict_types=1);

namespace Omnipay\Windcave\Message;

use Omnipay\Common\Message\RequestInterface;

/**
 * @link https://px5.docs.apiary.io/#reference/0/sessions/query-session
 */
class GetSessionRequest extends AbstractRequest implements RequestInterface
{
    public function getSessionId(): ?string
    {
        return $this->getParameter('sessionId');
    }

    public function setSessionId($value): ?string
    {
        return $this->setParameter('sessionId', $value);
    }

    public function getData(): array
    {
        return [];
    }

    public function getEndpoint(): string
    {
        return $this->baseEndpoint() . '/sessions/' . $this->getSessionId();
    }

    public function getHttpMethod(): string
    {
        return 'GET';
    }

    public function getContentType(): string
    {
        return 'application/json';
    }

    public function getResponseClass(): string
    {
        return GetSessionResponse::class;
    }
}
