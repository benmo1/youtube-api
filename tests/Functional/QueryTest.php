<?php

namespace Tests\Functional;

class QueryTest extends BaseTestCase
{
    public function testQueryYoutubeSearchWithNumbersReturnsExpectedResponse()
    {
        $response = $this->runApp(
            'GET',
            '/youtube-search?q=21st'
        );

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals([
            [
                'id' => 1,
                'title' => 'Bikes in the 21st Century',
            ],
        ],
            json_decode((string) $response->getBody(), true)
        );
    }

    public function testQueryYoutubeSearchWithMixedCaseReturnsExpectedResponse()
    {
        $response = $this->runApp(
            'GET',
            '/youtube-search?q=master'
        );

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals([
            [
                'id' => 2,
                'title' => 'Master cyclist on tour',
            ],
        ],
            json_decode((string) $response->getBody(), true)
        );
    }

    public function testQueryYoutubeSearchWithNoMatchesReturnsExpectedResponse()
    {
        $response = $this->runApp(
            'GET',
            '/youtube-search?q=89jwnsd09jqlwkejSUAJHDSwisajjiqowaksdj'
        );

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals([], json_decode((string) $response->getBody(), true));
    }

    /**
     * @param $badChar
     * @dataProvider badCharacters
     */
    public function testQueryYoutubeSearchWithBadCharactersReturnsExpectedResponse($badChar)
    {
        $response = $this->runApp(
            'GET',
            "/youtube-search?q=every+cyclist$badChar+nightmare"
        );

        $this->assertEquals(400, $response->getStatusCode());

        $this->assertEquals('{"error":"Invalid search characters - must be numeric, alpha, or single spaces."}', (string) $response->getBody());
    }

    public function videoData()
    {
        $this->markTestSkipped('For TDD');

        return [
            [
                'id' => 1,
                'title' => 'Bikes in the 21st Century',
                'date' => '2019-04-23',
            ],
            [
                'id' => 2,
                'title' => 'Master cyclist on tour',
                'date' => '2018-04-29',
            ],
            [
                'id' => 3,
                'title' => 'What goes around comes around, a look at alimunium wheels',
                'date' => '2019-03-23',
            ],
        ];
    }

    public function badCharacters()
    {
        return array_map(function ($ch) {
            return ['badChar' => $ch];
        }, str_split('!@£$%^*(){}[]`~\/=\''));
    }
}
