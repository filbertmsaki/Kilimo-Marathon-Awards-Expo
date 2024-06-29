<?php

namespace App\Attributes;

use Attribute;

/* Indicate that Attribute will be use only on constants */

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class AttributeProperty
{
    /* Will be useful to retrieve attribute class later */
    public const ATTRIBUTE_PATH = 'App\Attributes\\';

    public function __construct(
        private mixed $value,
    ) {
    }

    /**
     * Get the value of the attribute
     */
    public function get(): mixed
    {
        return $this->value;
    }
}
