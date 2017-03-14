<?php
namespace App\Model\Entity;

/**
 * HTTP url protocol
 */
trait ProtocolTrait
{
    /**
     * Remove http or https from a url.
     * @param  string $url
     * @return string
     */
    private function removeProtocol($url)
    {
        return preg_replace('#^https?://#', '', $url);
    }
}
