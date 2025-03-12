<?php

namespace App\Domain;

use Symfony\Component\HttpFoundation\Response;

interface ServiceInterface
{
    // validate returns response to make it more flexible even if endpoint returns json or html or anything
    public function validate(RequestInterface $request): ?Response;
    // handle functions handles all business logic related to the endpoint
    public function handle(RequestInterface $request): Response;
}