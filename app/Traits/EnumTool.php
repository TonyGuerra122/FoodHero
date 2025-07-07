<?php

namespace App\Traits;

trait EnumTool
{
    /**
     * Convert enum to array.
     *
     * @return array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Convert enum to associative array with keys as values.
     *
     * @return array
     */
    public static function toAssocArray(): array
    {
        return array_combine(self::toArray(), self::toArray());
    }
}
