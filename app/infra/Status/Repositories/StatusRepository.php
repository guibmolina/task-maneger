<?php

declare(strict_types=1);

namespace Infra\Status\Repositories;

use App\Models\Status;
use Domain\Status\Entities\StatusEntity;
use Domain\Status\Repositories\StatusRepository as BaseStatusRepository;

class StatusRepository implements BaseStatusRepository
{
    public function findStatusById(int $statusId): ?StatusEntity
    {
        $status = Status::find($statusId);

        if(!$status) {
            return null;
        }

        return $this->mapStatusEntityDomain($status);
    }

    public function allStatus(): array
    {
        return Status::all()->toArray();
    }

    private function mapStatusEntityDomain(Status $status): StatusEntity
    {
        return new StatusEntity($status->id, $status->description);
    }


}