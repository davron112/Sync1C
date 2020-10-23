<?php

namespace Davron112\Synchronizations\Services\Interfaces;

/**
 * Interface DeleteInterface
 * @package namespace Davron112\Synchronizations\Services\Interfaces;
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
