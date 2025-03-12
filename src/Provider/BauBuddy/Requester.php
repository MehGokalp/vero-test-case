<?php

namespace App\Provider\BauBuddy;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class Requester implements RequesterInterface
{
    public function __construct(
        protected HttpClientInterface $client,
        protected LoggerInterface $logger,
        #[Autowire(env: 'BAUBUDDY_API_BASE_URL')]
        protected string $baseHttpClientUri
    ) {
    }

    /**
     * @param Endpoint $endpoint
     * @param array $options
     * @return array|null
     * @throws Throwable
     */
    public function request(Endpoint $endpoint, array $options = []): ?array
    {
        try {
            return $this->getRequester()->request($endpoint->getMethod(), $endpoint->getPath(), $options)->toArray();
        } catch (Throwable $e) {
            $this->logger->error($e);

            throw $e;
        }
    }

    public function getRequester(): HttpClientInterface
    {
        return $this->client->withOptions([
            'base_uri' => $this->baseHttpClientUri,
        ]);
    }
}