<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Backlog = 'Backlog';
    case ToDo = 'To Do';
    case InProgress = 'In Progress';
    case Review = 'Review';
    case Done = 'Done';
    case Blocked = 'Blocked';

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
