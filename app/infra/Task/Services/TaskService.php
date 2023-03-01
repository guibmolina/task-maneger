<?php 

declare(strict_types=1);

namespace Infra\Task\Services;

use App\Jobs\TaksStatusUpdateEmailJob;
use App\Jobs\TaskAttachedEmailJob;
use Domain\Task\Entities\TaskEntity;
use Domain\Task\Services\TaskService as BaseTaskService;

class TaskService implements BaseTaskService
{

    public function sendEmailNewTaskAttached(TaskEntity $taskEntity): void
    {
        foreach ($taskEntity->users as $user) {
            dispatch(new TaskAttachedEmailJob($user, $taskEntity));
        }
        
    }


    public function sendEmailTaskStatusUpdate(TaskEntity $taskEntity): void
    {
        foreach ($taskEntity->users as $user) {
            dispatch(new TaksStatusUpdateEmailJob($user, $taskEntity));
        }
    }
}
