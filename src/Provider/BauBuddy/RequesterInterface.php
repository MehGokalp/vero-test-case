<?php

namespace App\Provider\BauBuddy;

interface RequesterInterface
{
    public function request(Endpoint $endpoint, array $options = []): ?array;
}