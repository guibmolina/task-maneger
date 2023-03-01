<?php

declare(strict_types=1);

namespace Domain\Task\UseCases\CreateTask;

use Domain\Status\Repositories\StatusRepository;
use Domain\Task\Entities\TaskEntity;
use Domain\Task\Exceptions\NotFoundStatusException;
use Domain\Task\Exceptions\NotFoundUsersException;
use Domain\Task\Repositories\TaskRepository;
use Domain\Task\Services\TaskService;
use Domain\User\Repositories\UserRepository;

class CreateTask
{
    public UserRepository $userRepository;

    public StatusRepository $statusRepository;

    public TaskRepository $taskRepository;

    public TaskService $taskService;

    public function __construct(
        UserRepository $userRepository,
        StatusRepository $statusRepository,
        TaskRepository $taskRepository,
        TaskService $taskService
    ) {
        $this->userRepository = $userRepository;
        $this->statusRepository = $statusRepository;
        $this->taskRepository = $taskRepository;
        $this->taskService = $taskService;
    }

    public function execute(DTO $DTO): Response
    {
        $usersList = $this->userRepository->findUsersByIds($DTO->usersId);

        if (empty($usersList->users())) {
            throw new NotFoundUsersException();
        }

        $status = $this->statusRepository->findStatusById($DTO->statusId);

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

        $taskCreated = $this->taskRepository->create($task);

        $this->taskService->sendEmailNewTaskAttached($task);

        return new Response($taskCreated);
    }
}
