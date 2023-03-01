<?php

declare(strict_types=1);

namespace Domain\Status\Entities;

class StatusEntity
{
    public int $id;

    public string $description;

    public function __construct(int $id, string $description)
    {
        $this->id = $id;

        $this->description = $description;
    }
}