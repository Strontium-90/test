<?php

declare(strict_types=1);

namespace App\Model;

class Task
{
    protected ?int $id;

    protected ?string $username;

    protected ?string $email;

    protected ?string $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }


    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
