<?php

namespace Alura\Mvc\Entity;

use http\Exception\InvalidArgumentException;

class User
{
    public readonly int $id;

    public readonly string $email;
    public function __construct(string $email, public readonly string $password)
    {
        $this->setEmail($email);
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException();
        }
        $this->email = $email;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}