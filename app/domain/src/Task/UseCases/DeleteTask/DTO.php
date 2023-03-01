<?php

declare(strict_types=1);

namespace Domain\Task\UseCases\DeleteTask;

class DTO
{
    public int $taskId;

    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
    }
}