<?php

declare(strict_types=1);

namespace Domain\Task\Services;

use Domain\Task\Entities\TaskEntity;

interface TaskService
{
    public function sendEmailNewTaskAttached(TaskEntity $taskEntity): void;

    public function sendEmailTaskStatusUpdate(TaskEntity $taskEntity): void;


}