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

use Mobizel\Bundle\MarkdownDocsBundle\Context\ReaderContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final class TemplateResolver implements TemplateResolverInterface
{
    private ReaderContextInterface $readerContext;

    public function __construct(ReaderContextInterface $readerContext)
    {
        $this->readerContext = $readerContext;
    }

    public function resolve(Request $request): ?string
    {
        $slug = $request->attributes->get('slug');

        Assert::string($slug, 'Slug must be a string. Got: %s');

        $context = $this->readerContext->getContext();
        $templatePath = sprintf('%s/%s.md', $context->getDocsDir($request), $slug);

        if (!is_file($templatePath)) {
            $templatePath = sprintf('%s/%s/index.md', $context->getDocsDir($request), $slug);
        }

        return is_file($templatePath) ? $templatePath : null;
    }
}
