<?php

namespace Davron112\Sync1C\Services\Interfaces;

/**
 * Interface UpdateInterface
 * @package namespace Davron112\Sync1C\Services\Interfaces;
 */
interface UpdateInterface
{
    /**
     * Update an item by id.
     *
     * @param array $data request body
     * @param int $id item ID
     */
    public function update(array $data, $id);
}
