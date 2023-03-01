<?php

declare(strict_types=1);

namespace Domain\Task\UseCases\UpdateTask;

use Domain\Status\Repositories\StatusRepository;
use Domain\Task\Entities\TaskEntity;
use Domain\Task\Exceptions\NotFoundStatusException;
use Domain\Task\Exceptions\NotFoundTaskException;
use Domain\Task\Exceptions\NotFoundUsersException;
use Domain\Task\Repositories\TaskRepository;
use Domain\Task\Services\TaskService;
use Domain\User\Repositories\UserRepository;

class UpdateTask
{
    public UserRepository $userRepository;

    public StatusRepository $statusRepository;

    public TaskRepository $taskRepository;

    public TaskService $taskervice;

    public function __construct(
        UserRepository $userRepository,
        StatusRepository $statusRepository,
        TaskRepository $taskRepository,
        TaskService $taskervice
    ) {
        $this->userRepository = $userRepository;
        $this->statusRepository = $statusRepository;
        $this->taskRepository = $taskRepository;
        $this->taskervice = $taskervice;

    }

    public function execute(DTO $DTO): Response
    {
        $usersList = $this->userRepository->findUsersByIds($DTO->usersId);

        $status = $this->statusRepository->findStatusById($DTO->statusId);

        $oldTask = $this->taskRepository->findById($DTO->id);

        if (empty($usersList->users())) {
            throw new NotFoundUsersException();
        }

        if (!$oldTask) {
            throw new NotFoundTaskException();
        }

        if (!$status) {
            throw new NotFoundStatusException();
        }

        $task = new TaskEntity(
            null,
            $DTO->title,
            $DTO->description,
            $DTO->startDate,
            $DTO->endDate,
            $status,
            $usersList
        );

        $taskUpdated = $this->taskRepository->update($DTO->id, $task);

        if ($task->statusId() == 2) {
            $this->taskervice->sendEmailTaskStatusUpdate($taskUpdated);
        }

        return new Response($taskUpdated);
    }
}
