<?php

namespace Davron112\Integrations\Services;

use Illuminate\Support\Arr;

/**
 * Class InstalmentService
 * @package namespace Davron112\Integrations\Services;
 */
class InstalmentService extends BaseService
{
    /**
     * @var string
     */
    protected const URI_REPORT = '/ElmakonIntegration/hs/credits/agreement';

    /**
     * @param $docNumber
     * @return array|false|mixed
     */
    public function getDataReport($data = [])
    {
        $agreement = Arr::get($data, 'agreement');
        return $this->getObject($this->requestService->makeGetRequest(self::URI_REPORT . '?agreement=' . $agreement));
    }
}
