<?php

namespace Omnipay\Windcave\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

class HppSessionRedirectResponse extends GetSessionResponse implements RedirectResponseInterface
{
    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        $redirectUrl = null;

        $links = $this->getData()['links'] ?? [];
        foreach ($links as $link) {
            $href = $link['href'] ?? null;
            $rel = $link['rel'] ?? null;
            if ($href && $rel == 'hpp') {
                $redirectUrl = $href;
            }
        }

        return $redirectUrl;
    }

    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Is the response a transparent redirect?
     *
     * @return boolean
     */
    public function isTransparentRedirect()
    {
        return true;
    }

    public function getSessionId()
    {
        return $this->getData('id');
    }
}
