<?php

namespace Davron112\Integration1c\Services\Interfaces;

/**
 * Interface GetInterface
 * @package namespace Davron112\Integration1c\Services\Interfaces;
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
