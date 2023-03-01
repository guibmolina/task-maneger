<?php

declare(strict_types=1);

namespace Domain\Task\Entities;

use DateTimeImmutable;
use Domain\Status\Entities\StatusEntity;
use Domain\Task\Exceptions\InvalidDateException;
use Domain\User\Entities\UserEntity;
use Domain\User\List\UserList;
use Exception;

class TaskEntity
{
    public ?int $id;

    public string $title;

    public string $description;

    private DateTimeImmutable $startDate;

    public DateTimeImmutable $endDate;

    private StatusEntity $status;

    public UserList $users;

    public function __construct(
        ?int $id,
        string $title,
        string $description,
        string $startDate,
        string $endDate,
        StatusEntity $status,
        UserList $users
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->startDate = $this->verifyDate($startDate);
        $this->endDate = $this->verifyDate($endDate);
        $this->status = $status;
        $this->users = $users;
    }

    private function verifyDate(string $date): DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($date);
        } catch (Exception $e) {
            throw new InvalidDateException();
        }
    }

    public function getStartDate(): string
    {
        return $this->startDate->format('Y-m-d H:i:s');
    }

    public function getEndDate(): string
    {
        return $this->endDate->format('Y-m-d H:i:s');
    }

    public function statusDescription(): string
    {
        return $this->status->description;
    }

    public function statusId(): int
    {
        return $this->status->id;
    }
}
