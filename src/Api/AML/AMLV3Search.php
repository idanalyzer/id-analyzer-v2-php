<?php
namespace IDAnalyzer2\Api\AML;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * @property string $text
 * @property string $id
 * @property int $limit
 * @property int $page
 */
class AMLV3Search extends ApiBase
{
    public string $uri = "/amlv3";
    public string $method = "POST";

    function __construct()
    {
        $this->initFields([
            self::Field('text', 'string', false, null, "Full-text AML search query (name, alias, document/passport/tax/registration number, etc.). Either text or id is required."),
            self::Field('id', 'string', false, null, 'One or more AML entity IDs to look up, separated by comma or newline (max 50). Either text or id is required.'),
            self::Field('limit', 'integer', false, null, 'Number of results to return per page.'),
            self::Field('page', 'integer', false, null, 'Result page number for pagination.'),
        ]);
    }
}
