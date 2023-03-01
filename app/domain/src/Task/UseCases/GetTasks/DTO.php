<?php

declare(strict_types=1);

namespace Domain\Task\UseCases\GetTasks;

class DTO
{
    public ?array $usersId;

    public ?int $statusId;

    public function __construct(?array $usersId = null, ?int $statusId = null)
    {
        $this->usersId = $usersId ?? [];

        $this->statusId = $statusId;
    }
}
