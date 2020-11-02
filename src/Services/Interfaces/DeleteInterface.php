<?php

namespace Davron112\Integrations\Services\Interfaces;

/**
 * Interface DeleteInterface
 * @package namespace Davron112\Integrations\Services\Interfaces;
 */
interface DeleteInterface
{
    /**
     * Delete a specific item by ID.
     *
     * @param int $id item ID
     */
    public function delete($id);
}
