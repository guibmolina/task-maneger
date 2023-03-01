<?php

namespace App\Jobs;

use App\Mail\TaskStatusUpdateMail;
use Domain\Task\Entities\TaskEntity;
use Domain\User\Entities\UserEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class TaksStatusUpdateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected UserEntity $user;

    protected TaskEntity $taskEntity;

    /**
     * Create a new job instance.
     */
    public function __construct(UserEntity $user, TaskEntity $taskEntity)
    {
        $this->user = $user;
        $this->taskEntity = $taskEntity;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new TaskStatusUpdateMail($this->user, $this->taskEntity);
        Mail::to($this->user->email())->send($email);
    }
}
