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

namespace Mobizel\Bundle\MarkdownDocsBundle\Docs;

final class ContextResolver implements ContextResolverInterface
{
    /** @var ContextRegistryInterface */
    private $contextRegistry;

    public function __construct(ContextRegistryInterface $contextRegistry)
    {
        $this->contextRegistry = $contextRegistry;
    }

    public function resolve(string $path): ?ContextInterface
    {
        /** @var ContextInterface $context */
        foreach ($this->contextRegistry->getAll() as $context) {
            if (!preg_match($context->getPattern(), $path)) {
                continue;
            }

            return $context;
        }

        return null;
    }
}
