<?php

class Article
{
    private $id;
    private $name;
    private $text;
    private $authorId;
    private $createdAt;

    public function __set($name, $value)
    {
        $camelCaseName = lcfirst(str_replace('_', '', ucwords($name, '_')));
        $this->$camelCaseName = $value;
    }

    public function getId(): int       { return $this->id; }
    public function getName(): string  { return $this->name; }
    public function getText(): string  { return $this->text; }
    public function getAuthorId(): int { return $this->authorId; }
}