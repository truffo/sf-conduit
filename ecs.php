<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\Configuration\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [__DIR__.'/src', __DIR__.'/ecs.php']);

    $parameters->set(Option::SETS, [
        SetList::COMMON,
        SetList::CLEAN_CODE,
        SetList::DEAD_CODE,
        SetList::STRICT,
        SetList::PSR_12,
        SetList::PHP_CS_FIXER,
        SetList::PHP_CS_FIXER_RISKY,
        SetList::PHP_70,
        SetList::PHP_71,
        SetList::PHP_73_MIGRATION,
        SetList::SYMPLIFY,
    ]);
};
