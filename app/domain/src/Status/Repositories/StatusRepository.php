<?php

declare(strict_types=1);

namespace Domain\Status\Repositories;

use Domain\Status\Entities\StatusEntity;

interface StatusRepository
{

    public function findStatusById(int $statusId): ?StatusEntity;

    public function allStatus(): array;

    
}
