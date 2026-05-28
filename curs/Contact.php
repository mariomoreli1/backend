<?php

class Contact
{
    private $id;
    private $name;
    private $email;
    private $message;
    private $createdAt;

    public function __set($name, $value)
    {
        $camelCaseName = lcfirst(str_replace('_', '', ucwords($name, '_')));
        $this->$camelCaseName = $value;
    }

    public function getId(): int          { return $this->id; }
    public function getName(): string     { return $this->name; }
    public function getEmail(): string    { return $this->email; }
    public function getMessage(): string  { return $this->message; }
    public function getCreatedAt(): string { return $this->createdAt ?? ''; }
}
