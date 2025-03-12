<?php

namespace App\Provider\BauBuddy\UseCase\SelectTasks;

readonly class ResponseDTO
{
    /**
     * @param TaskDTO[] $tasks
     */
    public function __construct(public array $tasks)
    {
    }
}