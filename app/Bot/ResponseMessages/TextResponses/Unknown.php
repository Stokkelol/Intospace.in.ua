<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\TextResponses;

use App\Bot\ResponseMessages\Interfaces\Text;
use App\Models\Band;

/**
 * Class Unknown
 *
 * @package app\Bot\ResponseMessages\TextResponses
 */
class Unknown implements Text
{
    /**
     * @var array
     */
    public static $answers = [
        ['Silence is golden'],
        ['Think different!'],
        ['Whats up?'],
        ['Yo!']
    ];

    /**
     * @return array
     */
    public function prepare(): array
    {
        return static::$answers[
            \random_int(1, \count(static::$answers))
        ];
    }

    /**
     * @return Band|null
     */
    public function getBand(): Band
    {
        //
    }
}