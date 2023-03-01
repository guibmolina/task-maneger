<?php

declare(strict_types=1);

namespace Domain\Task\List;

use ArrayIterator;
use Domain\Task\Entities\TaskEntity;
use IteratorAggregate;
use Traversable;

/** @implements IteratorAggregate<Task> */
class TaskList implements IteratorAggregate
{
    /** @var array<TaskEntity> */
    private array $tasks;

    public function __construct()
    {
        $this->tasks = [];
    }

    public function add(TaskEntity $task): void
    {
        $this->tasks[] = $task;
    }

    /** @return array<TaskEntity> */
    public function tasks(): array
    {
        return $this->tasks;
    }

    /** @return Traversable<TaskEntity> */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->tasks);
    }
}
