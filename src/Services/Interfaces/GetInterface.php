<?php

namespace Davron112\Integrations\Services\Interfaces;

/**
 * Interface GetInterface
 * @package namespace Davron112\Integrations\Services\Interfaces;
 */
interface GetInterface
{
    /**
     * Get a specific item by ID.
     *
     * @param int $id item ID
     */
    public function get($id);
}
