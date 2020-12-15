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

namespace Mobizel\Bundle\MarkdownDocsBundle\Helper;

use Mobizel\Bundle\MarkdownDocsBundle\Template\TemplateHandlerInterface;
use Webmozart\Assert\Assert;

final class PageHelper implements PageHelperInterface
{
    /** @var TemplateHandlerInterface */
    private $templateHandler;

    public function __construct(TemplateHandlerInterface $templateHandler)
    {
        $this->templateHandler = $templateHandler;
    }

    public function getTitle(string $slug): string
    {
        $path = $this->templateHandler->getTemplateAbsolutePath($slug);
        $line = $this->getFirstLine($path);

        if (false === strpos($line, '# ')) {
            return $this->getDefaultTitle($slug);
        }

        return rtrim(ltrim($line, '# '), "\n");
    }

    private function getFirstLine(string $path): string
    {
        /** @var resource $resource */
        $resource = fopen($path, 'r');
        Assert::notFalse($resource);

        $line = fgets($resource);

        fclose($resource);

        return $line ? $line : '';
    }

    private function getDefaultTitle(string $slug): string
    {
        /** @var string[] $parts */
        $parts = explode('/', $slug);

        /** @var string $title */
        $title = end($parts);

        return ucfirst($title);
    }
}
