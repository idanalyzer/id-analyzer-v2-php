<?php
namespace IDAnalyzer2\Api\AML;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

class AMLSearch extends ApiBase
{
    public string $uri = "/aml";
    public string $method = "POST";

    function __construct()
    {
        $this->initFields([
            RequestPayload::Field('name', 'string', false, null, "Search AML database with person's name or business name"),
            RequestPayload::Field('idNumber', 'string', false, null, 'Search AML database with document number'),
            RequestPayload::Field('entity', 'integer', false, null, '0=Person, 1=Corporation/Legal Entity'),
            RequestPayload::Field('country', 'string', false, null, 'Return only entities with matching country/nationality or no country information. Use two digit ISO country code.'),
            RequestPayload::Field('database', 'array of strings', false, null, 'If unspecified all databases will be searched, alternatively you may specify one or more databases to search in: "au_dfat","ca_dfatd","ch_seco","eu_cor","eu_fsf","eu_meps","global_politicians","fr_tresor_gels_avoir","gb_hmt","interpol_red","ua_sfms","un_sc","us_ofac"'),
        ]);
    }
}