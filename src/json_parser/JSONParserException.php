<?php

/**
 * This code is released under the MIT license.
 * For more details, see the accompanying LICENCE file in this folder.
 *
 * Simple exception class, extending the stock Exception.
 * Just there to allow for adequate try-catch filtering.
 *
 * @author Guillaume Bodi
 */
class JSONParserException extends Exception
{
    /**
     * @param JSONParser|null $jsonParser
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct(JSONParser $jsonParser = null, $message = "", $code = 0, Exception $previous = null)
    {
        if ($jsonParser && $jsonParser instanceof \json_parser\MyJSONParser) {
            if (($arrayBuffer = $jsonParser->getMyArrayBuffer()) !== null && is_array($buffer = $arrayBuffer->getBuffer())) {
                echo "JSON's last words:\n" . implode('', $buffer) . "<--------\nHaving this spoken he dieeed.\n";
            } else {
                echo "JSON's last words will unknown forever.\n" .
                    "We know what we are, but know not what we may be.\n";
            }
        }
        parent::__construct($message, $code, $previous);
    }

}
