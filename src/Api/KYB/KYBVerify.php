<?php
namespace IDAnalyzer2\Api\KYB;

use IDAnalyzer2\ApiBase;
use IDAnalyzer2\RequestPayload;
use IDAnalyzer2\SDKException;

/**
 * Request for the KYB (Know Your Business) Verify endpoint (`POST /kyb`).
 *
 * Verify a business from its registration/incorporation document. A document is
 * required; an optional profile selects the KYC profile. The endpoint extracts
 * the company details, checks official company registries, screens against
 * sanctions/PEP watchlists, and returns directors and owners to verify.
 *
 * @property string $document
 * @property string $profile
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
            self::Field('document', 'string', true, null, 'Base64-encoded registration/incorporation document (image or PDF), a URL, or a "ref:abcde" reference to a document from another transaction.'),
            self::Field('profile', 'string', false, null, 'Optional KYC profile to apply to the verification.'),
        ]);
    }

    /**
     * Validate the request before it is sent.
     *
     * A business document is required.
     *
     * @return void
     *
     * @throws SDKException If document is empty/missing.
     */
    public function validate() {
        parent::validate();
        if ($this->document === null || $this->document === '') {
            throw new SDKException("A business document (image or PDF) is required.");
        }
    }
}
