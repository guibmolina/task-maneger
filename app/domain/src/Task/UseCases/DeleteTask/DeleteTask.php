<?php

declare(strict_types=1);

namespace Domain\Task\UseCases\DeleteTask;

use Domain\Task\Exceptions\NotFoundTaskException;
use Domain\Task\Repositories\TaskRepository;

class DeleteTask
{
    public TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(DTO $DTO): void
    {
        $task = $this->repository->findById($DTO->taskId);

        if (!$task) {
            throw new NotFoundTaskException();
        }

        $this->repository->delete($task);
    }
}