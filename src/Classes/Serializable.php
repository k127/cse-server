<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 03.05.15
 * Time: 18:17
 */

namespace Classes;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * Interface Serializable
 * @package Classes
 */
abstract class Serializable
{
    /** @var string */
    public static $FORMAT_JSON = 'json';
    /** @var string */
    public static $FORMAT_XML = 'xml';

    /** @noinspection PhpUndefinedClassInspection */
    /**
     * @param string $format
     * @return string|scalar
     */
    public function serialize($format = null)
    {
        return (new Serializer(static::getNormalizers(), [new JsonEncoder()]))
            ->serialize($this, $format ?: static::$FORMAT_JSON);
    }

    /**
     * @param string $data
     * @param string $class
     * @param string $format
     * @return object
     */
    public static function deserialize($data, $class, $format = null)
    {
        return (new Serializer(static::getNormalizers(), [new JsonEncoder()]))
            ->deserialize($data, $class, $format ?: static::$FORMAT_JSON);
    }

    /**
     * @return array
     */
    private static function getNormalizers()
    {
        return [
            //new JsonClassHintingNormalizer(),
            new GetSetMethodNormalizer(),
        ];
    }
    /** @noinspection PhpUnusedPrivateMethodInspection */
    /**
     * @param string $format
     * @return JsonEncoder|XmlEncoder
     */
    private function getEncoder($format)
    {
        return ($format === self::$FORMAT_XML) ? new XmlEncoder() : new JsonEncoder();
    }
}
