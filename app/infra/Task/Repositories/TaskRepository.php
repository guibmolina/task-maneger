<?php

declare(strict_types=1);

namespace Infra\Task\Repositories;

use App\Models\Task;
use App\Models\User;
use Domain\Status\Entities\StatusEntity;
use Domain\Task\Entities\TaskEntity;
use Domain\Task\Exceptions\NotFoundTaskException;
use Domain\Task\List\TaskList;
use Domain\Task\Repositories\TaskRepository as BaseTaskRepository;
use Domain\User\Entities\UserEntity;
use Domain\User\List\UserList;
use Illuminate\Database\Eloquent\Builder;

class TaskRepository implements BaseTaskRepository
{
 
    public function create(TaskEntity $taskEntity): TaskEntity
    {

        $task = new Task();
        $task->title = $taskEntity->title;
        $task->description = $taskEntity->description;
        $task->start_date = $taskEntity->getStartDate();
        $task->end_date = $taskEntity->getEndDate();
        $task->status_id = $taskEntity->statusId();

        $usersId = [];
        foreach($taskEntity->users as $user) {
            $usersId[] = $user->id;
        }
        try {
            $task->save();
            $task->users()->sync($usersId);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $this->mapTaskEntityDomain($task);

    }

    public function update(int $taskId, TaskEntity $taskEntity): TaskEntity
    {
        $task = Task::find($taskId);

        $task->title = $taskEntity->title;
        $task->description = $taskEntity->description;
        $task->start_date = $taskEntity->getStartDate();
        $task->end_date = $taskEntity->getEndDate();
        $task->status_id = $taskEntity->statusId();

        $usersId = [];
        foreach($taskEntity->users as $user) {
            $usersId[] = $user->id;
        }

        try {
            $task->users()->sync($usersId);
            $task->save();
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $this->mapTaskEntityDomain($task);
    }

    public function findTasksBy(?array $usersId, ?int $statusId): TaskList
    {
        $tasks = Task::select();

        if($usersId) {
            foreach ($usersId as $userid)
                $tasks->whereRelation('users', 'users.id', $userid);
            }
        

        if ($statusId) {
            $tasks->where('status_id', $statusId);
        }

        $tasks = $tasks->get();
  
        $taskList = new TaskList();
        foreach ($tasks as $task) {
            $taskList->add($this->mapTaskEntityDomain($task));
        }

        return $taskList;

    }

    public function findById(int $taskId): ?TaskEntity
    {
        $task = Task::find($taskId);

        if(!$task) {
            return null;
        }

        return $this->mapTaskEntityDomain($task);
    }

    public function delete(TaskEntity $taskEntity): void
    {
        $task = Task::find($taskEntity->id);

        $task->users()->sync([]);

        $task->delete();

        return;
    }

    private function mapTaskEntityDomain(Task $task): TaskEntity
    {
        $userList = new UserList();

        foreach($task->users as $user) {
            $userList->add($this->mapUserEntityDomain($user));
        }


        return new TaskEntity(
            $task->id,
            $task->title,
            $task->description,
            $task->start_date,
            $task->end_date,
            new StatusEntity($task->status->id, $task->status->description),
            $userList
        );
    }

    private function mapUserEntityDomain(User $user): UserEntity
    {
        return new UserEntity(
            $user->id,
            $user->name,
            $user->email,
            $user->password,
            null
        );
    }
}

