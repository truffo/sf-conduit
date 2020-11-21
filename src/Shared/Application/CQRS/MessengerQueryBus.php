<?php

declare(strict_types=1);

namespace App\Shared\Application\CQRS;

use App\Shared\Application\ViewModel;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @return mixed
     */
    public function handle(Query $query): ViewModel
    {
        return $this->handleQuery($query);
    }
}
