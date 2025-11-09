<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Planning = 'Planning';
    case Active = 'Active';
    case OnHold = 'On Hold';
    case Completed = 'Completed';

    /**
     * Get all status values as an array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all status options for select components.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}
