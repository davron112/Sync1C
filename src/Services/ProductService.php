<?php

namespace Davron112\Sync1C\Services;

use Davron112\Sync1C\Services\Interfaces\GetInterface;
use Davron112\Sync1C\Services\Interfaces\GetAllInterface;

/**
 * Class ProductService
 * @package namespace Davron112\Sync1C\Services;
 */
class ProductService extends BaseService implements GetAllInterface, GetInterface
{
    /**
     * Get all products.
     *
     * @return array
     */
    public function getAll()
    {
        dd(32423423);
        return $this->getObject($this->requestService->makeGetRequest($this->getUrl('product')));
    }

    /**
     * Get updated products.
     *
     * @param int $time delta time
     *
     * @return array
     */
    public function getUpdated($time)
    {
        return $this->getObject(
            $this->requestService->makeGetRequest($this->getUrl(implode(['product/changed/', $time])))
        );
    }

    /**
     * Get specific product by ID.
     *
     * @param int $id product ID
     *
     * @return array
     */
    public function get($id)
    {
        return $this->getObject($this->requestService->makeGetRequest($this->getUrl(implode(['product/', $id]))));
    }

    /**
     * Get templates.
     *
     * @param int $time unix timestamp
     *
     * @return array
     */
    public function getTemplates($ids = false)
    {
        $param = false;
        if (is_array($ids)) {
            $param = '&id=' . implode(',', $ids);
        }
        return $this->getObject(
            $this->requestService->makeGetRequest($this->getUrl('creative/templates') . $param)
        );
    }
}
