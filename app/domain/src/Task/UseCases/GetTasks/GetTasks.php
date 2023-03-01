<?php

declare(strict_types=1);

namespace Domain\Task\UseCases\GetTasks;

use Domain\Task\Repositories\TaskRepository;
use Domain\Task\UseCases\GetTasks\DTO;

class GetTasks
{
    public TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(DTO $DTO): Response
    {
        $tasks = $this->repository->findTasksBy($DTO->usersId, $DTO->statusId);

        return new Response($tasks);
    }
}