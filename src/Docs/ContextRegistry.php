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

final class ContextRegistry implements ContextRegistryInterface
{
    /** @var ContextInterface[] */
    private $contexts = [];

    public function __construct(iterable $contexts)
    {
        foreach ($contexts as $context) {
            $this->add($context);
        }
    }

    public function add(ContextInterface $docs): void
    {
        $this->contexts[$docs->getName()] = $docs;
    }

    public function getAll(): array
    {
        return $this->contexts;
    }
}
