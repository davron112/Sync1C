<?php

namespace Davron112\Integrations\Traits;

/**
 * Trait CredentialsTrait
 * @package namespace Davron112\Integrations\Traits;
 */
trait CredentialsTrait
{
    /**
     * Credentials.
     *
     * @var array
     */
    private $credentials;

    /**
     * Set credentials
     *
     * @param array $credentials
     *
     * @return void
     */
    public function setCredentials(array $credentials)
    {
        $this->credentials = $credentials;
    }
}
