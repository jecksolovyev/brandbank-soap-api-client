<?php

namespace BrandbankSOAPAPIClient\Response\GetUnsentProductDataResult;

use BrandbankSOAPAPIClient\Exception\BrandbankSOAPException;

class EU1169_2011Compliance
{
    const SUPPLIER_STATED_COMPLIANT = 'SupplierStatedCompliant';
    const SUPPLIER_STATED_NON_COMPLIANT = 'SupplierStatedNonCompliant';
    const SUPPLIER_STATED_NOT_APPLICABLE = 'SupplierStatedNotApplicable';

    private $value;

    public function __construct(string $value)
    {
        if (!in_array($value, [self::SUPPLIER_STATED_COMPLIANT, self::SUPPLIER_STATED_NON_COMPLIANT, self::SUPPLIER_STATED_NOT_APPLICABLE])) {
            throw new BrandbankSOAPException('EU1169_2011Compliance must one of allowed');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}