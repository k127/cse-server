<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 02.07.14
 * Time: 20:27
 */

namespace json_parser;

use Exception;

/**
 * Class OneDimensionalData
 * @package json_parser
 */
class OneDimensionalData
{
    /**
     * @var string
     */
    const TYPE_ARRAY = 'array';
    /**
     * @var string
     */
    const TYPE_ASSOCIATIVE_ARRAY = 'associative_array';
    /**
     * @var string OneDimensionalData::TYPE_ARRAY | OneDimensionalData::TYPE_ASSOCIATIVE_ARRAY
     */
    private $type = null;
    /**
     * @var array
     */
    private $data = [];
    /**
     * @var string
     */
    private $property = null;

    function __construct()
    {
        $this->reset();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function dumpData()
    {
        if (isset($this->type)) {
            throw new Exception("->type needs to be unset before dumping.");
        }
        $ret = $this->data;
        $this->reset();
        return $ret;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setProperty($value)
    {
        $this->property = $value;
        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return $this
     */
    public function unsetType()
    {
        unset($this->type);
        return $this;
    }

    /**
     * @param $value
     * @throws Exception
     */
    public function store($value)
    {
        if ($this->type == self::TYPE_ARRAY && !is_null($this->property)) {
            throw new Exception('False:  $this->type == self::TYPE_ARRAY && !is_null($this->property)');
        } elseif ($this->type == self::TYPE_ARRAY) {
            $this->data[] = $value;
        } elseif ($this->type == self::TYPE_ASSOCIATIVE_ARRAY) {
            $this->data[$this->property] = $value;
        } else {
            throw new Exception("Unknown error in Data->store('$value'').");
        }
    }

    private function reset()
    {
        $this->type = null;
        $this->data = [];
        $this->property = null;
    }
} 