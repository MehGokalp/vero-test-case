<?php

namespace App\Provider\BauBuddy\UseCase\SelectTasks;

readonly class TaskDTO
{
    public function __construct(
        public string $task,
        public string $title,
        public string $description,
        public string $colorCode,
    )
    {
    }
}