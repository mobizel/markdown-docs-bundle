<?php

/*
 * This file is part of the Mobizel package.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mobizel\Bundle\MarkdownDocsBundle\Markdown;

use ParsedownExtra;
use Twig\Extra\Markdown\MarkdownInterface;

class MarkdownExtra implements MarkdownInterface
{
    /** @var ParsedownExtra */
    private $converter;

    public function __construct(ParsedownExtra $converter = null)
    {
        $this->converter = $converter ?: new ParsedownExtra();
    }

    public function convert(string $body): string
    {
        return $this->converter->text($body);
    }
}
