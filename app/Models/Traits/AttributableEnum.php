<?php

namespace App\Models\Traits;

use App\Attributes\AttributeProperty;
use BadMethodCallException;
use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionEnum;

trait AttributableEnum
{
    /**
     * Call the given method on the enum case
     *
     */
    public function __call(string $method, array $arguments): mixed
    {
        // Get attributes of the enum case with reflection API
        $reflection = new ReflectionEnum(static::class);
        $attributes = $reflection->getCase($this->name)->getAttributes();

        // Check if attribute exists in our attributes list
        $filtered_attributes = array_filter($attributes, fn (ReflectionAttribute $attribute) => $attribute->getName() === AttributeProperty::ATTRIBUTE_PATH . Str::ucfirst($method));

        // If not, throw an exception
        if (empty($filtered_attributes)) {
            throw new BadMethodCallException(sprintf('Call to undefined method %s::%s()', static::class, $method));
        }

        return array_shift($filtered_attributes)->newInstance()->get();
    }
}
