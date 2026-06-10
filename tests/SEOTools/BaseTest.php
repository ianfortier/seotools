<?php

namespace Artesaos\SEOTools\Tests;

use Mockery;
use DOMDocument;
use Orchestra\Testbench\TestCase;

/**
 * Class BaseTest.
 */
class BaseTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [\Artesaos\SEOTools\Providers\SEOToolsServiceProvider::class];
    }

    /**
     * @param $string
     * @return \DOMDocument
     */
    protected function makeDomDocument($string)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($string);

        return $dom;
    }

    protected function jsonLdPayload(string $html): array
    {
        $matched = preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches);
        $this->assertSame(1, $matched, 'Expected to find a JSON-LD <script type="application/ld+json"> tag');

        return json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
    }
}
