<?php

namespace App\Domain;

use Symfony\Component\HttpFoundation\Request;

interface RequestInterface
{
    public static function create(Request $request): self;
}