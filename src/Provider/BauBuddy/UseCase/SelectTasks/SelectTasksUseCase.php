<?php

namespace App\Provider\BauBuddy\UseCase\SelectTasks;

use App\Provider\BauBuddy\Endpoint;
use App\Provider\BauBuddy\RequesterInterface;
use App\Provider\BauBuddy\UseCase\Login\LoginUseCase;

class SelectTasksUseCase
{
    public function __construct(protected LoginUseCase $loginUseCase, protected RequesterInterface $requester)
    {
    }

    // if we will implement new endpoints like this we can move this $username and $password to
    // a global place called CredentialsStorage (similar to Symfony's token storage) to avoid passing it around
    public function getTasks(string $username, string $password): ResponseDTO
    {
        $httpResponse = $this->requester->request(Endpoint::TASKS_SELECT, [
            'headers' => [
                'Authorization' => sprintf(
                    'Bearer %s',
                    $this->loginUseCase->login($username, $password)->accessToken
                )
            ]
        ]);

        $tasks = [];
        foreach ($httpResponse as $task) {
            $tasks[] = new TaskDTO($task['task'], $task['title'], $task['description'], $task['colorCode']);
        }

        return new ResponseDTO($tasks);
    }
}