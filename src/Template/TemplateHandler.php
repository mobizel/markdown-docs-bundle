<?php

/*
 * This file is part of the Mobizel package.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Mobizel\Bundle\MarkdownDocsBundle\Template;

final class TemplateHandler implements TemplateHandlerInterface
{
    /** @var string */
    private $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getTemplatePath(string $slug): string
    {
        return $slug.'.md';
    }

    public function getTemplateAbsolutePath(string $slug): string
    {
        return $this->projectDir.'/'.$this->getTemplatePath($slug);
    }
}
