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

namespace Mobizel\Bundle\MarkdownDocsBundle\Page;

use Symfony\Component\Finder\SplFileInfo;
use Webmozart\Assert\Assert;

final class PageInfo extends SplFileInfo implements PageInfoInterface
{
    public function getTitle(): string
    {
        $line = $this->getFirstLine();

        if (false === $this->isLineContainsTitle($line)) {
            return $this->getDefaultTitle();
        }

        return rtrim(ltrim($line, '# '), "\n");
    }

    public function getContent(): string
    {
        /** @var string $content */
        $content = file_get_contents($this->getPathname());

        return $content;
    }

    public function getContentWithoutTitle(): string
    {
        $content = $this->getContent();
        $line = $this->getFirstLine();

        if ($this->isLineContainsTitle($line)) {
            /** @var string $content */
            $content = preg_replace('/^#.+/', '', $content);

            return $content;
        }

        return $this->getContent();
    }

    private function getFirstLine(): string
    {
        /** @var resource $resource */
        $resource = fopen($this->getPathname(), 'r');
        Assert::notFalse($resource);

        $line = fgets($resource);

        fclose($resource);

        return $line ? $line : '';
    }

    private function getDefaultTitle(): string
    {
        return ucfirst(pathinfo($this->getFilename(), \PATHINFO_FILENAME));
    }

    private function isLineContainsTitle(string $line): bool
    {
        return 0 === strpos($line, '#');
    }
}
