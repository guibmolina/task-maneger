<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use Domain\Task\Exceptions\NotFoundStatusException;
use Domain\Task\Exceptions\NotFoundTaskException;
use Domain\Task\Exceptions\NotFoundUsersException;
use Domain\Task\UseCases\CreateTask\CreateTask;
use Domain\Task\UseCases\CreateTask\DTO as CreateTaskDTO;
use Domain\Task\UseCases\DeleteTask\DeleteTask;
use Domain\Task\UseCases\DeleteTask\DTO as DeleteTaskDTO;
use Domain\Task\UseCases\GetTasks\DTO;
use Domain\Task\UseCases\GetTasks\GetTasks;
use Domain\Task\UseCases\UpdateTask\DTO as UpdateTaskDTO;
use Domain\Task\UseCases\UpdateTask\UpdateTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Infra\Status\Repositories\StatusRepository;
use Infra\Task\Repositories\TaskRepository;
use Infra\Task\Services\TaskService;
use Infra\User\Repositories\UserRepository;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $DTO = new CreateTaskDTO(
            $request->title,
            $request->description,
            $request->start_date,
            $request->end_date,
            $request->status_id,
            $request->users_id
        );

        $createTaskUseCase = new CreateTask(
            new UserRepository(),
            new StatusRepository(),
            new TaskRepository(),
            new TaskService()
        );
    
        try {
            $taskCreated = $createTaskUseCase->execute($DTO);
        } catch (ModelNotFoundException $e) {
            return response()->json([], 422);
        } catch(NotFoundUsersException $e) {
            return response()->json(['Users not exists'], 422);
        } catch(NotFoundStatusException $e) {
            return response()->json(['Status not exists'], 422);
        } catch(Exception $e) {
            return response()->json(['Server Error'], 500);
        }

        return response()->json($taskCreated->response());
    }

    public function index(Request $request): JsonResponse
    {
        $users = $request->query('users');

        $statusId = $request->query('status_id');

        $DTO = new DTO($users, $statusId);

        $getTasksUseCase = new GetTasks(new TaskRepository());

        try {
            $tasks = $getTasksUseCase->execute($DTO);
        } catch (Exception $e) {
            return response()->json(['Server Error'], 500);
        }
        return response()->json($tasks->response());
    }

    public function update(StoreTaskRequest $request, int $id): JsonResponse
    {
        $DTO = new UpdateTaskDTO(
            $id,
            $request->title,
            $request->description,
            $request->start_date,
            $request->end_date,
            $request->status_id,
            $request->users_id
        );

        $updateTaskUseCase = new UpdateTask(
            new UserRepository(),
            new StatusRepository(),
            new TaskRepository(),
            new TaskService()
        );

        try {
            $taskUpdated = $updateTaskUseCase->execute($DTO);
        } catch (NotFoundTaskException $e) {
            return response()->json([], 404);
        } catch (NotFoundUsersException $e) {
            return response()->json(['Users not exists'], 422);
        } catch (NotFoundStatusException $e) {
            return response()->json(['Status not exists'], 422);
        } catch (Exception $e) {
            return response()->json(['Server Error'], 500);
        }

        return response()->json($taskUpdated->response());
    }

    public function delete(int $id): JsonResponse
    {
        $DTO = new DeleteTaskDTO($id);

        $deleteTaskUseCase = new DeleteTask(new TaskRepository());

        try {
            $deleteTaskUseCase->execute($DTO);
        } catch (NotFoundTaskException $e) {
            return response()->json([], 404);
        } catch (Exception $e) {
            return response()->json(['Server Error'], 500);
        }

        return response()->json([], 201);
    }
}
