<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededControlParenthesesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededCurlyBracesFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireShortTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\Functions\UnusedInheritedVariablePassedToClosureSniff;
use SlevomatCodingStandard\Sniffs\Functions\UnusedParameterSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\ReferenceUsedNamesOnlySniff;
use SlevomatCodingStandard\Sniffs\Operators\RequireCombinedAssignmentOperatorSniff;
use SlevomatCodingStandard\Sniffs\PHP\DisallowDirectMagicInvokeCallSniff;
use SlevomatCodingStandard\Sniffs\PHP\UselessParenthesesSniff;
use SlevomatCodingStandard\Sniffs\PHP\UselessSemicolonSniff;
use SlevomatCodingStandard\Sniffs\Variables\UnusedVariableSniff;
use SlevomatCodingStandard\Sniffs\Variables\UselessVariableSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\Commenting\ParamReturnAndVarTagMalformsFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [__DIR__.'/src', __DIR__.'/ecs.php']);

    $parameters->set(Option::SETS, [
        SetList::COMMON,
        // SetList::CLEAN_CODE,
        // SetList::DEAD_CODE,
        // SetList::STRICT,
        SetList::PSR_12,
        SetList::PHP_CS_FIXER,
        SetList::PHP_CS_FIXER_RISKY,
        SetList::PHP_70,
        SetList::PHP_71,
        SetList::PHP_73_MIGRATION,
        SetList::SYMPLIFY,
    ]);

    // Clean code
    $services->set(DisallowDirectMagicInvokeCallSniff::class);
    $services->set(ParamReturnAndVarTagMalformsFixer::class);
    $services->set(UnusedVariableSniff::class);
    $services->set(UselessVariableSniff::class);
    $services->set(UnusedInheritedVariablePassedToClosureSniff::class);
    $services->set(UselessSemicolonSniff::class);
    $services->set(UselessParenthesesSniff::class);
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]])
    ;
    $services->set(NoUnusedImportsFixer::class);
    $services->set(OrderedImportsFixer::class);
    $services->set(NoEmptyStatementFixer::class);
    $services->set(ProtectedToPrivateFixer::class);
    $services->set(NoUnneededControlParenthesesFixer::class);
    $services->set(NoUnneededCurlyBracesFixer::class);
    $services->set(ReturnAssignmentFixer::class);
    $services->set(RequireShortTernaryOperatorSniff::class);
    $services->set(RequireCombinedAssignmentOperatorSniff::class);

    $services->set(UnusedParameterSniff::class);

    $services->set(UnusedVariableSniff::class);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SKIP, [
        UnusedParameterSniff::class.'.UnusedParameter' => null,
    ]);

    $services->set(StrictComparisonFixer::class);

    $services->set(IsNullFixer::class)
        ->call('configure', [[
            'use_yoda_style' => true,
        ]])
    ;

    $services->set(StrictParamFixer::class);

    $services->set(ReferenceUsedNamesOnlySniff::class)
        ->property('searchAnnotations', true)
        ->property('allowFallbackGlobalFunctions', true)
        ->property('allowFallbackGlobalConstants', true)
        ->property('allowPartialUses', false)
        ->property('allowFullyQualifiedGlobalFunction', true)
        ->property('allowFullyQualifiedGlobalClasses', true)
    ;
};
