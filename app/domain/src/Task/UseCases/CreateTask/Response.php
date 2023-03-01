<?php

declare(strict_types=1);

namespace Domain\Task\UseCases\CreateTask;

use Domain\Task\Entities\TaskEntity;

class Response
{
    public TaskEntity $task;

    public function __construct(TaskEntity $task)
    {
        $this->task = $task;   
    }

    public function response(): array
    {
        $response = [
            'id' => $this->task->id,
            'title' => $this->task->title,
            'description' => $this->task->description,
            'start_date' => $this->task->getStartDate(),
            'end_date' => $this->task->getEndDate(),
            'status' => $this->task->statusDescription()
        ];

        foreach($this->task->users as $user) {
            $response['users'][] = [
                'id' => $user->id,
                'name' => $user->name
            ];
        }

        return $response;
    }
}
