<?php

namespace Davron112\Sync1C\Services;

use Davron112\Sync1C\Services\Interfaces\CreateInterface;
use Davron112\Sync1C\Services\Interfaces\UpdateInterface;
use Davron112\Sync1C\Services\Interfaces\GetInterface;
use Davron112\Sync1C\Services\Interfaces\GetAllInterface;

/**
 * Class ContactService
 * @package namespace Davron112\Sync1C\Services;
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

    /**
     * Get a contact by company ID.
     *
     * @param int $id contact ID
     *
     * @return bool
     */
    public function getByCompany($id)
    {
        return $this->getObject(
            $this->requestService->makeGetRequest($this->getUrl(implode(['contact/company/', $id])))
        );
    }
}
