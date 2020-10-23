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
     * @var string
     */
    protected static $listUri = 'Integration/full';

    protected static $detailUri = 'Integration/info/';

    protected static $changeUri = 'Integration/changed';

    /**
     * Get all products.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->getObject($this->requestService->makeGetRequest(self::$listUri));
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
            $this->requestService->makeGetRequest($this->getUrl(self::$detailUri . $time))
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
        return $this->getObject($this->requestService->makeGetRequest('Integration/full' . $id));
    }
}
