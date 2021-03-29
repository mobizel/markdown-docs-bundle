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

final class PageActionTest extends WebTestCase
{
    public function testRedirection()
    {
        $client = static::createClient();

        $client->request('GET', 'bdd.md');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertEquals('/bdd', $client->getResponse()->getTargetUrl());
    }

    public function testDirectoryIndexPageRedirection()
    {
        $client = static::createClient();

        $client->request('GET', 'book/index');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertEquals('/book', $client->getResponse()->getTargetUrl());
    }

    public function testShowPage()
    {
        $client = static::createClient();

        $client->request('GET', 'index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Documentation');
    }

    public function testDirectoryIndexPage()
    {
        $client = static::createClient();

        $client->request('GET', 'book');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Book homepage');
    }

    public function testSubDirectoryIndexPage()
    {
        $client = static::createClient();

        $client->request('GET', 'book/stephen-king');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'Stephen King Books');
    }

    public function testNotFoundPage()
    {
        $client = static::createClient();

        $client->request('GET', 'not-found');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testBreadcrumb()
    {
        $client = static::createClient();

        $client->request('GET', 'cookbook/bdd/phpspec');

        $client->clickLink('BDD - Behaviour-driven development');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextSame('html h1', 'BDD - Behaviour-driven development');
    }
}
