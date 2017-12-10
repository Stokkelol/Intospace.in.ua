<?php
declare(strict_types=1);

namespace app\Bot\ResponseMessages\TextResponses;

/**
 * Class Parser
 * 
 * @package app\Bot\ResponseMessages\TextResponses
 */
class Parser
{
    const SEPARATOR  = '#';

    const BASE_PATTERN = '';

    /**
     * @var array
     */
    private $parts = [];

    /**
     * @var string
     */
    private $text;

    /**
     * Parser constructor.
     * 
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function parse()
    {
        if (!\preg_match(self::SEPARATOR, $this->text)) {
            return new Unknown();
        }

        $parts = \explode(self::SEPARATOR, $this->text);

        $this->parts = $parts;
    }
}