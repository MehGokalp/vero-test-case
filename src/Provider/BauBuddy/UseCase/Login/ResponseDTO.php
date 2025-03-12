<?php

namespace App\Provider\BauBuddy\UseCase\Login;

readonly class ResponseDTO
{

    public function __construct(public string $accessToken)
    {
    }
}