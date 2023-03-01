<?php

declare(strict_types=1);

namespace Domain\Task\UseCases\CreateTask;

class DTO
{
    public string $title;

    public string $description;

    public string $startDate;

    public string $endDate;

    public int $statusId;

    public array $usersId = [];

    public function __construct(
        string $title,
        string $description,
        string $startDate,
        string $endDate,
        int $statusId,
        array $usersId
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->statusId = $statusId;
        $this->usersId = $usersId;
    }
}