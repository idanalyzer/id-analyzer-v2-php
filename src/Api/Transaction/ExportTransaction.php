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
            RequestPayload::Field('exportType', 'string', false, null, 'Export format, either "csv" or "json".'),
            RequestPayload::Field('ignoreUnrecognized', 'boolean', false, null, 'Ignore unrecognized documents.'),
            RequestPayload::Field('ignoreDuplicate', 'boolean', false, null, 'Ignore duplicated entries.'),
            RequestPayload::Field('transactionId', 'array of strings', false, null, 'List of transactions to export.'),
            RequestPayload::Field('customData', 'string', false, null, 'If not transaction ID is specified, filter by customData.'),
            RequestPayload::Field('profileId', 'string', false, null, 'If not transaction ID is specified, filter by profile ID.'),
            RequestPayload::Field('decision', 'string', false, null, 'If not transaction ID is specified, filter by decision.'),
            RequestPayload::Field('createdAtMin', 'string', false, null, 'If not transaction ID is specified, filter time range.'),
            RequestPayload::Field('createdAtMax', 'string', false, null, 'If not transaction ID is specified, filter time range.'),
            RequestPayload::Field('docupass', 'string', false, null, 'If not transaction ID is specified, filter docupass reference.'),
        ]);
    }
}