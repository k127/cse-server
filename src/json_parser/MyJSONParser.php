<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 25.06.14
 * Time: 17:28
 */

namespace json_parser;

use JSONParser;

require_once __DIR__ . '/JSONParser.php';
require_once __DIR__ . '/MyArrayBuffer.php';

/**
 * Class MyJSONParser
 * @package json_parser
 */
class MyJSONParser extends JSONParser
{
    /**
     * @var MyArrayBuffer
     */
    private $myArrayBuffer;


    /**
     * @param int $max_elements
     */
    function __construct($max_elements = 150)
    {
        error_reporting(E_ALL);

        parent::__construct();

        $this->myArrayBuffer = new MyArrayBuffer($max_elements);
        $myArrayBuffer = $this->myArrayBuffer;

        // sets the callbacks
        $this->setArrayHandlers(function ($value, $property) use ($myArrayBuffer) {
            unset($value, $property);
            $myArrayBuffer->push("[\n");
        }, function ($value, $property) use ($myArrayBuffer) {
            unset($value, $property);
            $myArrayBuffer->push("]\n");
        });
        $this->setObjectHandlers(function ($value, $property) use ($myArrayBuffer) {
            unset($value, $property);
            $myArrayBuffer->push("{\n");
        }, function ($value, $property) use ($myArrayBuffer) {
            unset($value, $property);
            $myArrayBuffer->push("}\n");
        });
        $this->setPropertyHandler(function ($value, $property) use ($myArrayBuffer) {
            unset($property);
            $myArrayBuffer->push(sprintf("\"%s\": ", $value));
        });
        $this->setScalarHandler(function ($value, $property) use ($myArrayBuffer) {
            unset($property);
            $myArrayBuffer->push(sprintf("\"%s\"(,) ", $value));
        });
    }

    /**
     * @param string $json_file
     * @return string
     */
    /*
    public function parseDocumentAndGetString($json_file)
    {
        // parse the document
        $this->parseDocument($json_file);
        return implode('', $this->myArrayBuffer->getBuffer());
    }
*/
    /**
     * @return MyArrayBuffer
     */
    public function getMyArrayBuffer()
    {
        return $this->myArrayBuffer;
    }

}
