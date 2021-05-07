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

namespace Mobizel\Bundle\MarkdownDocsBundle\Context;

use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextInterface;
use Mobizel\Bundle\MarkdownDocsBundle\Docs\ContextResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Webmozart\Assert\Assert;

final class ReaderContext implements ReaderContextInterface
{
    private Request $request;
    private ContextResolverInterface $contextResolver;

    public function __construct(RequestStack $requestStack, ContextResolverInterface $contextResolver)
    {
        $this->request = $requestStack->getCurrentRequest() ?? new Request();
        $this->contextResolver = $contextResolver;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getContext(): ContextInterface
    {
        /** @var ContextInterface $context */
        $context = $this->contextResolver->resolve($this->request->getRequestUri());

        /* @psalm-suppress RedundantConditionGivenDocblockType */
        Assert::notNull($context, 'Context was not found but it should.');

        return $context;
    }
}
