<?php

declare(strict_types=1);

namespace WPRestClient\Core\Entity;

use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Exception;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

class EntityBase
{
    protected int $id;
    protected array $_properties = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->massSetProperties($data);
    }

    protected function massSetProperties(array $data)
    {
        $class = new ReflectionClass($this);
        $properties = $class->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            $name = $property->getName();
            if ($name === '_properties') {
                return;
            }
            $this->_properties[] = $name;
            $value = Hash::get($data, $name);
            if (is_array($value) && Hash::check($value, 'rendered')) {
                $value = Hash::get($value, 'rendered');
            }
            $setterMethod = self::propertyToMethod('set', $name);
            method_exists($this, $setterMethod)
                ? $this->{$setterMethod}($value)
                : $this->{$name} = $value;
        }
    }

    /**
     * @throws Exception
     */
    public function __call($methodName, $arguments)
    {
        $propertyName = self::methodToProperty($methodName);
        if (str_starts_with($methodName, 'get') && in_array($propertyName, $this->_properties)) {
            return $this->{$propertyName};
        }

        throw new RuntimeException(sprintf('method "%s" does not exist in class "%s"', $methodName, get_class($this)));
    }

    public static function methodToProperty(string $methodName): string
    {
        return substr(Inflector::underscore($methodName), 4);
    }

    public static function propertyToMethod(string $type, string $propertyName): string
    {
        return Inflector::camelize($type . '_' . $propertyName);
    }
}
