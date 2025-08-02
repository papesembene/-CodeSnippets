<?php

namespace App\Entities;

use App\Core\Interface\IEntity;

class ExampleEntity implements IEntity 
{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    

    public static function toObject(array $data): static
    {
        return new static($data['id'], $data['name']);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}