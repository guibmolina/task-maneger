<?php

declare(strict_types=1);

namespace Domain\Task\Repositories;

use Domain\Task\Entities\TaskEntity;
use Domain\Task\List\TaskList;

interface TaskRepository
{

    public function create(TaskEntity $task): TaskEntity;

    public function update(int $taskId, TaskEntity $task): TaskEntity;

    public function findTasksBy(array $usersId, ?int $statusId): TaskList;

    public function findById(int $taskId): ?TaskEntity;

    public function delete(TaskEntity $taskEntity): void;
    
}
