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

final class MenuActionTest extends WebTestCase
{
    public function testMenuAction(): void
    {
        $client = static::createClient();

        $client->request('GET', '/current/_partials/menu');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html ul li a', 'Bar');
    }
}
