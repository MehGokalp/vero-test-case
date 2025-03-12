<?php

namespace App\Provider\BauBuddy\UseCase\Login;

use App\Provider\BauBuddy\Endpoint;
use App\Provider\BauBuddy\RequesterInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class LoginUseCase
{
    public function __construct(
        #[Autowire(env: 'BAUBUDDY_API_BASIC_AUTH')]
        protected string             $accessToken,
        protected RequesterInterface $requester
    )
    {
    }

    // keep all business logic related to log in endpoint here, cache etc
    public function login(string $username, string $password): ResponseDTO
    {
        $httpResponse = $this->requester->request(Endpoint::LOGIN, [
            'headers' => [
                'Authorization' => sprintf(
                    'Basic %s',
                    $this->accessToken
                )
            ],
            'json' => [
                'username' => $username,
                'password' => $password
            ]
        ]);

        return new ResponseDTO($httpResponse['oauth']['access_token']);
    }
}