<?php

class User
{
    private $id;
    private $nickname;
    private $email;
    private $role;
    private $passwordHash;
    private $authToken;
    private $isConfirmed;
    private $createdAt;

    public function __set($name, $value)
    {
        $camelCaseName = lcfirst(str_replace('_', '', ucwords($name, '_')));
        $this->$camelCaseName = $value;
    }

    public function getId(): int           { return $this->id; }
    public function getNickname(): string  { return $this->nickname; }
    public function getEmail(): string     { return $this->email; }
    public function getRole(): string      { return $this->role; }
}
