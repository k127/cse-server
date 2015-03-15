<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 25.06.14
 * Time: 15:16
 */

namespace json_parser;

/**
 * Class MyArrayBuffer
 * @package json_parser
 */
class MyArrayBuffer
{
    /**
     * @var array
     */
    private $buffer = [];
    /**
     * @var int
     */
    private $max_elements = null;

    /**
     * @param int null $max_elements
     * if $max_elements is set, each push implies a pop
     */
    function __construct($max_elements = null)
    {
        if ($max_elements) {
            $this->max_elements = $max_elements;
        }
    }

    /**
     * @return array
     */
    public function getBuffer()
    {
        return $this->buffer;
    }

    /**
     * @param array $buffer
     */
    public function setBuffer($buffer)
    {
        $this->buffer = $buffer;
    }

    /**
     * @param $string
     */
    public function push($string)
    {
        array_push($this->buffer, $string);
        if ($this->max_elements !== null) {
            while (sizeof($this->buffer) > $this->max_elements) {
                array_shift($this->buffer);
            }
        }
    }

}
