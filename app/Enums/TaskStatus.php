<?php

namespace App\Enums;

enum TaskStatus: string
{
    case TODO = 'todo';
    case DOING = 'doing';
    case DONE = 'done';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::TODO => 'To Do',
            self::DOING => 'Doing',
            self::DONE => 'Done',
            self::REJECTED => 'Rejected',
        };
    }
}
