<?php

namespace Davron112\Synchronizations\Services;

use Davron112\Synchronizations\Services\Interfaces\CreateInterface;
use Davron112\Synchronizations\Services\Interfaces\UpdateInterface;
use Davron112\Synchronizations\Services\Interfaces\GetInterface;
use Davron112\Synchronizations\Services\Interfaces\GetAllInterface;

/**
 * Class ContactService
 * @package namespace Davron112\Synchronizations\Services;
 */
class ContactService extends BaseService implements CreateInterface, UpdateInterface, GetInterface, GetAllInterface
{
    /**
     * Create a contact.
     *
     * @param array $data request body
     *
     * @return bool
     */
    public function create(array $data)
    {
        return $this->getObjectId($this->requestService->makePostRequest($this->getUrl('contact'), $data));
    }

    /**
     * Update a contact.
     *
     * @param array $data request body
     * @param int $id contact ID
     *
     * @return bool
     */
    public function update(array $data, $id)
    {
        return $this->checkStatus(
            $this->requestService->makePutRequest($this->getUrl(implode(['contact/', $id])), $data)
        );
    }

    /**
     * Get all contacts.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->getObject($this->requestService->makeGetRequest($this->getUrl('contact')));
    }

    /**
     * Get a contact by ID.
     *
     * @param int $id contact ID
     *
     * @return bool
     */
    public function get($id)
    {
        return $this->getObject(
            $this->requestService->makeGetRequest($this->getUrl(implode(['contact/', $id])))
        );
    }
}
