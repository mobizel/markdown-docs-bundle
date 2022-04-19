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

namespace Mobizel\Bundle\MarkdownDocsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PrintActionTest extends WebTestCase
{
    public function testPrintPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/_print');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Documentation');
        $this->assertSelectorTextSame('html h3', '1.1 - Requirements');
        $this->assertSelectorTextSame('html p', 'No title here');
    }
}
