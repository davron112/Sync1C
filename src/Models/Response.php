<?php

namespace Davron112\Sync1C\Models;

/**
 * Class Response
 * @package namespace Davron112\Sync1C\Models;
 */
class Response
{
    const ID_RESPONSE_SUCCESS                     = 0;
    const ID_GENERIC_ERROR                        = 1;
    const ID_ALREADY_EXISTS                       = 2;
    const ID_NOT_FOUND                            = 3;
    const ID_NOT_ABLE_TO_DELETE                   = 4;
    const ID_VALIDATION_ERROR                     = 5;
    const ID_REMOTE_SERVICE_ERROR                 = 6;
    const ID_REMOTE_SERVICE_DOES_NOT_SUPPORT_CALL = 98;
    const ID_API_CALL_NOT_IMPLEMENTED             = 99;
}
