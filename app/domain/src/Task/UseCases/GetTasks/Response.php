<?php

declare(strict_types=1);

namespace Domain\Task\UseCases\GetTasks;

use Domain\Task\List\TaskList;

class Response
{
    public TaskList $tasks;

    public function __construct(TaskList $tasks)
    {
        $this->tasks = $tasks;
    }

    public function response(): array
    {
        $response = [];
        foreach($this->tasks as $task) {
            $response[] = [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'start_date' => $task->getStartDate(),
                'end_date' => $task->getEndDate(),
                'status' => $task->statusDescription(),
                'users' => $this->formatUsers($task->users)
            ];
        }

        return $response;
    }

    private function formatUsers($users): array
    {
        $usersArray = [];
        foreach($users as $user) {
            $usersArray[] = [
                'id' => $user->id,
                'name' => $user->name
            ];
        }
        return $usersArray;
    }
}