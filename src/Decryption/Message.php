<?php

namespace PhilipBrown\ThisIsBud\Decryption;


class Message
{
    private $block;
    private $cell;

    private function __construct(string $cell, string $block)
    {
        $this->cell = $cell;
        $this->block = $block;
    }

    public static function fromCellAndBlock(string $cell, string $block): Message
    {
        $jsonMessage = new Message($cell, $block);
        return $jsonMessage;
    }

    public static function fromJsonString(string $rawJson): Message
    {
        static::validate($rawJson);

        $jsonArray = json_decode($rawJson, true);

        $cell = $jsonArray['cell'];
        $block = $jsonArray['block'];

        $jsonMessage = new Message($cell, $block);
        return $jsonMessage;
    }

    private static function validate(string $inputJson)
    {
        $jsonArray = json_decode($inputJson, true);

        if (!is_array($jsonArray) || !isset($jsonArray['cell']) || !isset($jsonArray['block'])) {
            throw InvalidMessageException::fromResponseBody($inputJson);
        }
    }

    public function getCell(): string
    {
        return $this->cell;
    }

    public function getBlock(): string
    {
        return $this->block;
    }

    public function getJsonString(): string
    {
        $jsonArray = [
            'cell' => $this->cell,
            'block' => $this->block,
        ];

        return json_encode($jsonArray, JSON_PRETTY_PRINT);
    }
}
