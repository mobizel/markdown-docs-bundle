<?php

use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import('vendor/mobizel/coding-standard/ecs.php');

    $header = <<<EOM
This file is part of the Mobizel package.

(c) Mobizel

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOM;

    $services = $containerConfigurator->services();
    $services->set(HeaderCommentFixer::class)
        ->call('configure', [[
            'header' => $header,
            'location' => 'after_open'
        ]])
    ;

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SKIP, [
        VisibilityRequiredFixer::class => ['*Spec.php'],
        PhpUnitTestClassRequiresCoversFixer::class => ['*Test.php'],
        PhpUnitInternalClassFixer::class => ['*Test.php'],
        PhpUnitMethodCasingFixer::class => ['*Test.php'],
        FunctionTypehintSpaceFixer::class => ['*PageCollectionDataProvider.php'],
    ]);
};
