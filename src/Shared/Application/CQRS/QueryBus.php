<?php

declare(strict_types=1);

namespace App\Shared\Application\CQRS;

interface QueryBus
{
    public function handle(Query $query);
}
