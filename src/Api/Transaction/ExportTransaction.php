<?php

namespace IDAnalyzer2\Api\Transaction;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class ExportTransaction extends ApiBase
{
    public string $uri = "/export/transaction";
    public string $method = "POST";
    public bool $isFile = true;

    function __construct()
    {
        $this->initFields([
            self::Field('exportType', 'string', false, null, 'Export format, either "csv" or "json".'),
            self::Field('ignoreUnrecognized', 'boolean', false, null, 'Ignore unrecognized documents.'),
            self::Field('ignoreDuplicate', 'boolean', false, null, 'Ignore duplicated entries.'),
            self::Field('transactionId', 'array of strings', false, null, 'List of transactions to export.'),
            self::Field('customData', 'string', false, null, 'If not transaction ID is specified, filter by customData.'),
            self::Field('profileId', 'string', false, null, 'If not transaction ID is specified, filter by profile ID.'),
            self::Field('decision', 'string', false, null, 'If not transaction ID is specified, filter by decision.'),
            self::Field('createdAtMin', 'string', false, null, 'If not transaction ID is specified, filter time range.'),
            self::Field('createdAtMax', 'string', false, null, 'If not transaction ID is specified, filter time range.'),
            self::Field('docupass', 'string', false, null, 'If not transaction ID is specified, filter docupass reference.'),
        ]);
    }
}