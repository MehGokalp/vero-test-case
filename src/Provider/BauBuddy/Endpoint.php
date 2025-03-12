<?php

namespace App\Provider\BauBuddy;

enum Endpoint
{
    case TASKS_SELECT;
    case LOGIN;

    public function getPath(): string
    {
        return match ($this) {
            self::TASKS_SELECT => 'dev/index.php/v1/tasks/select',
            self::LOGIN => 'index.php/login',
        };
    }

    public function getMethod(): string
    {
        return match ($this) {
            self::TASKS_SELECT => 'GET',
            self::LOGIN => 'POST',
        };
    }
}
