<?php

namespace Davron112\Integrations\Services\Interfaces;

/**
 * Interface UpdateInterface
 * @package namespace Davron112\Integrations\Services\Interfaces;
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
