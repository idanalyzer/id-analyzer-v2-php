<?php
namespace IDAnalyzer2\Api\KYB;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * Request for the KYB (Know Your Business) Verify endpoint (`POST /kyb`).
 *
 * Verifies a business from its registration/incorporation document: extracts
 * the company details, checks official company registries, screens against
 * sanctions/PEP watchlists, and returns directors and owners to verify. You may
 * supply a registration/incorporation document and/or known business
 * identifiers; at least one of {@see $document}, {@see $legalName} or
 * {@see $registrationNumber} is required.
 *
 * @property string $document
 * @property string $legalName
 * @property string $legalNameLocal
 * @property string $registrationNumber
 * @property string $taxNumber
 * @property string $lei
 * @property string $entityType
 * @property string $countryIso2
 * @property string $state
 */
class KYBVerify extends ApiBase
{
    public string $uri = "/kyb";
    public string $method = "POST";

    /**
     * Initialize the request fields with their descriptors and defaults.
     *
     * @return void
     */
    function __construct()
    {
        $this->initFields([
            self::Field('document', 'string', false, null, 'Base64-encoded registration/incorporation document, a URL, or a "ref:abcde" reference to an image from another transaction.'),
            self::Field('legalName', 'string', false, null, 'Registered legal name of the business.'),
            self::Field('legalNameLocal', 'string', false, null, 'Registered legal name of the business in the local language/script.'),
            self::Field('registrationNumber', 'string', false, null, 'Company registration / incorporation number.'),
            self::Field('taxNumber', 'string', false, null, 'Business tax number.'),
            self::Field('lei', 'string', false, null, 'Legal Entity Identifier (LEI).'),
            self::Field('entityType', 'string', false, null, 'Business entity type.'),
            self::Field('countryIso2', 'string', false, null, 'Two-letter ISO country code where the business is registered.'),
            self::Field('state', 'string', false, null, 'State/province where the business is registered.'),
        ]);
    }

    /**
     * Validate the request before it is sent.
     *
     * In addition to the base required-field checks, at least one of
     * {@see $document}, {@see $legalName} or {@see $registrationNumber} must be
     * supplied.
     *
     * @return void
     *
     * @throws SDKException If none of document, legalName or registrationNumber is set.
     */
    public function validate() {
        parent::validate();
        if ($this->document === null && $this->legalName === null && $this->registrationNumber === null) {
            throw new SDKException("Provide a document, or legalName/registrationNumber.");
        }
    }
}
