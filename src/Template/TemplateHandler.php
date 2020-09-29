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
    private $docsDir;

    public function __construct(string $docsDir)
    {
        $this->docsDir = $docsDir;
    }

    public function getTemplatePath(string $slug): string
    {
        return $slug.'.md';
    }

    public function getTemplateAbsolutePath(string $slug): string
    {
        $pathName = ltrim($this->getTemplatePath($slug), 'docs');

        return $this->docsDir.$pathName;
    }
}
