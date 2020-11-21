<?php

declare(strict_types=1);

namespace App\Shared\Application\CQRS;

use App\Shared\Application\ViewModel;

interface QueryBus
{
    /**
     * @return mixed
     */
    public function handle(Query $query): ViewModel;
}
