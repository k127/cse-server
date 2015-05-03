<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 03.05.15
 * Time: 20:32
 */

namespace Classes\Normalizers;


use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class JsonClassHintingNormalizer
 * @package Classes\Normalizers
 */
class JsonClassHintingNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /** @var string */
    public static $JSON_KEY = '__jsonclass__';

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param object $object object to normalize
     * @param string $format format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|string|bool|int|float|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];

        $reflectionClass = new ReflectionClass($object);

        $data[static::$JSON_KEY] = [
            get_class($object),
            [], // constructor arguments
        ];

        foreach ($reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            if (strtolower(substr($reflectionMethod->getName(), 0, 3)) !== 'get') {
                continue;
            }

            if ($reflectionMethod->getNumberOfRequiredParameters() > 0) {
                continue;
            }

            $property = lcfirst(substr($reflectionMethod->getName(), 3));
            $value = $reflectionMethod->invoke($object);

            $data[$property] = $value;
        }

        return $data;
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize.
     * @param string $format The format being (de-)serialized from or into.
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return is_object($data) && $format === 'json';
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed $data data to restore
     * @param string $class the expected class to instantiate
     * @param string $format format the given data was extracted from
     * @param array $context options available to the denormalizer
     *
     * @return object
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $class = $data[static::$JSON_KEY][0];
        $reflectionClass = new ReflectionClass($class);

        $constructorArguments = $data[static::$JSON_KEY][1] ?: [];

        $object = $reflectionClass->newInstanceArgs($constructorArguments);

        unset($data[static::$JSON_KEY]);

        foreach ($data as $property => $value) {
            $setter = 'set' . $property;
            if (method_exists($object, $setter)) {
                $object->$setter($value);
            }
        }

        return $object;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed $data Data to denormalize from.
     * @param string $type The class to which the data should be denormalized.
     * @param string $format The format being deserialized from.
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return isset($data[static::$JSON_KEY]) && $format === 'json';
    }
}
