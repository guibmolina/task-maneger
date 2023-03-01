<?php

namespace App\Mail;

use Domain\Task\Entities\TaskEntity;
use Domain\User\Entities\UserEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewTaskAttached extends Mailable
{
    use Queueable, SerializesModels;

    protected UserEntity $userEntity;

    protected TaskEntity $taskEntity;
    /**
     * Create a new message instance.
     */
    public function __construct(UserEntity $userEntity, TaskEntity $taskEntity)
    {
        $this->userEntity = $userEntity;

        $this->taskEntity = $taskEntity;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Task Attached',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.taskAttached',
            with: [
                'name' => $this->userEntity->name,
                'task_title' => $this->taskEntity->title
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
