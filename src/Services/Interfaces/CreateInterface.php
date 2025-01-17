<?php

namespace Davron112\Integrations\Services\Interfaces;

/**
 * Interface CreateInterface
 * @package namespace Davron112\Integrations\Services\Interfaces;
 */
interface CreateInterface
{
    /**
     * Get a new item.
     *
     * @param array $data request body
     */
    public function create(array $data);
}
