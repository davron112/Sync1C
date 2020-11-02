<?php

namespace Davron112\Integrations\Services;

use Davron112\Integrations\Services\Interfaces\CreateInterface;
use Davron112\Integrations\Services\Interfaces\UpdateInterface;
use Davron112\Integrations\Services\Interfaces\DeleteInterface;

/**
 * Class OrderService
 * @package namespace Davron112\Integrations\Services;
 */
class OrderService extends BaseService implements CreateInterface, UpdateInterface, DeleteInterface
{
    /**
     * Get all orders.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->getObject($this->requestService->makeGetRequest($this->getUrl('order')));
    }

    /**
     * Get updated orders.
     *
     * @param int $time delta time
     *
     * @return array
     */
    public function getUpdated($time)
    {
        return $this->getObject(
            $this->requestService->makeGetRequest($this->getUrl(implode(['order/changed/', $time])))
        );
    }

    /**
     * Create an order.
     *
     * @param array $data request body
     *
     * @return bool
     */
    public function create(array $data)
    {
        return $this->getObjectId($this->requestService->makePostRequest($this->getUrl('order'), $data));
    }

    /**
     * Update an order.
     *
     * @param array $data request body
     * @param int $id order ID
     *
     * @return mixed
     */
    public function update(array $data, $id)
    {
        return $this->checkStatus(
            $this->requestService->makePutRequest($this->getUrl(implode(['order/', $id])), $data)
        );
    }

    /**
     * Delete an order.
     *
     * @param int $id order ID
     *
     * @return bool
     */
    public function delete($id)
    {
        return $this->checkStatus($this->requestService->makeDeleteRequest($this->getUrl(implode(['order/', $id]))));
    }

    /**
     * Cancel an order.
     *
     * @param int $id order ID
     *
     * @return bool
     */
    public function cancel($id)
    {
        return $this->checkStatus(
            $this->requestService->makePutRequest($this->getUrl(implode(['order/cancel/', $id])))
        );
    }
}
