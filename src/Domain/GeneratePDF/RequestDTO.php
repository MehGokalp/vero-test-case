<?php

namespace App\Domain\GeneratePDF;

use App\Domain\RequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class RequestDTO implements RequestInterface
{
    #[Assert\NotBlank(message: "username can not be null")]
    public ?string $username = null;

    #[Assert\NotBlank(message: "password can not be null")]
    public ?string $password = null;

    public static function create(Request $request): self
    {
        $self = new self();
        $self->username = $request->query->get('username');
        $self->password = $request->query->get('password');

        return $self;
    }
}