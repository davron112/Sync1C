<?php

namespace Davron112\Integrations\Services;

use Davron112\Integrations\Services\Interfaces\GetInterface;
use Davron112\Integrations\Services\Interfaces\GetAllInterface;

/**
 * Class ProductService
 * @package namespace Davron112\Integrations\Services;
 */
class ProductService extends BaseService implements GetAllInterface, GetInterface
{
    /**
     * @var string
     */
    protected static $listUri = '/products?active=0';

    protected static $detailUri = '/products/info/';

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
     * Get specific product by ID.
     *
     * @param int $id product ID
     *
     * @return array
     */
    public function get($id)
    {
        return $this->getObject($this->requestService->makeGetRequest(self::$detailUri . $id));
    }
}
