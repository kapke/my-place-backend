<?php
namespace Kapke\Bundle\MyPlaceBundle\DependencyInjection;

trait Serializer
{
    public function serialize()
    {
        $output = [];
        foreach ($this->serializableProperties as $property) {
            $name = $property['name'];
            $value = null;
            if (isset($property['value'])) {
                //launches property serializing function
                if (is_callable($property['value'])) {
                    $value = call_user_func($property['value']);
                } else {
                    $value = $this->{$property['value']};
                }
            } else {
                $value = $this->{$name};
            }
            $simple = isset($property['simple']) ? $property['simple'] : true;
            if (!$simple) {
                $value = $value->toArray();
            }
            //serializes array
            if (is_array($value)) {
                foreach ($value as $key => $subvalue) {
                    if (method_exists($subvalue, 'serialize')) {
                        $value[$key] = $subvalue->serialize();
                    }
                }
            }
            //serializes subobjects
            if (method_exists($value, 'serialize')) {
                $value = $value->serialize();
            }
            $output[$name] = $value;
        }

        return $output;
    }

    public static function serializeArray (array $arr) {
        return array_map(function ($item) {
            return $item->serialize();
        }, $arr);
    }
}
