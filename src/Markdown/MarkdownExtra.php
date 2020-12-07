<?php

namespace Mobizel\Bundle\MarkdownDocsBundle\Markdown;

use ParsedownExtra;
use Twig\Extra\Markdown\MarkdownInterface;

class MarkdownExtra implements MarkdownInterface
{
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
