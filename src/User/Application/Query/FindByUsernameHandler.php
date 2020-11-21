<?php


namespace App\User\Application\Query;

use App\Shared\Application\CQRS\QueryHandler;
use App\User\Application\ViewModel\SimpleUserViewModel;
use App\User\Domain\UserRepositoryInterface;

class FindByUsernameHandler implements QueryHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {

        $this->repository = $repository;
    }

    public function __invoke(FindByUsernameQuery $query)
    {
        $user = $this->repository->findByUsername($query->getUsername());

        return SimpleUserViewModel::createFromEntity($user);
    }
}