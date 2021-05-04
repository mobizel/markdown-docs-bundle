<?php

/*
 * This file is part of the markdown-docs-bundle project.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Mobizel\Bundle\MarkdownDocsBundle\Context;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Webmozart\Assert\Assert;

final class ReaderContext implements ReaderContextInterface
{
    /** @var Request */
    private $request;

    /** @var ContextResolverInterface */
    private $contextResolver;

    public function __construct(RequestStack $requestStack, ContextResolverInterface $contextResolver)
    {
        $this->request = $requestStack->getCurrentRequest() ?? new Request();
        $this->contextResolver = $contextResolver;
    }

    public function getContext(): ContextInterface
    {
        $context = $this->contextResolver->resolve($this->request->getRequestUri());
        Assert::notNull($context, 'Context was not found but it should.');

        return $context;
    }
}
