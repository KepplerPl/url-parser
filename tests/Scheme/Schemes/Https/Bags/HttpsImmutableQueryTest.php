<?php
declare(strict_types=1);

namespace Kepper\Url\Tests\Scheme\Schemes\Https\Bags;

use Keppler\Url\Scheme\Schemes\Https\Bags\HttpsImmutableQuery;
use PHPUnit\Framework\TestCase;

class HttpsImmutableQueryTest extends TestCase
{
    private $validUrl = 'https://john:password@www.example.com:123/forum/questions/?tag[]=networking&order=newest&tag[]=music#top';

    public function testGettersEmptyUrl()
    {
        $https = new HttpsImmutableQuery();

        $this->assertEquals('', $https->raw());
        $this->assertEquals([], $https->all());
        $this->assertEquals(null, $https->last());
        $this->assertEquals(null, $https->first());
        $this->assertEquals(false, $https->has(0));
    }

    public function testGettersNotEmptyUrl()
    {
        $parsed = parse_url($this->validUrl);
        $https = new HttpsImmutableQuery($parsed['query']);

        $this->assertEquals('tag[]=networking&order=newest&tag[]=music', $https->raw());
        $this->assertEquals([
            'tag' => ['networking', 'music'],
            'order' => 'newest',
        ], $https->all());
        $this->assertEquals(['order' => 'newest'], $https->last());
        $this->assertEquals(['tag' => ['networking', 'music']], $https->first());
        $this->assertEquals(true, $https->has('tag'));
    }

}