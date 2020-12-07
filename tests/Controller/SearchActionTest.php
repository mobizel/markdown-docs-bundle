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

final class SearchActionTest extends WebTestCase
{
    public function testSearchAction()
    {
        $client = static::createClient();

        $client->request('GET', 'search?query=foo+fighters');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1', 'foo fighters');
        $this->assertSelectorTextContains('main ul', 'Foo fighters');
    }
}
