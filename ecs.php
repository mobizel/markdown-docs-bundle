<?php

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
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
        ]]);


    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SETS, [SetList::SYMFONY]);
};
