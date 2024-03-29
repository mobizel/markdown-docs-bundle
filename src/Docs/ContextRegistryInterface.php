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

interface ContextRegistryInterface
{
    public function add(ContextInterface $docs): void;

    /**
     * @return ContextInterface[]
     */
    public function getAll(): array;
}
