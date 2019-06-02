<?php

namespace Tests\Functional;

class GetAllTest extends BaseTestCase
{
    public function testGetAllYoutubeSearchReturnsExpectedResponse()
    {
        $response = $this->runApp(
            'GET',
            '/youtube-search'
        );

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals([
            [
                'id' => 1,
                'title' => 'Bikes in the 21st Century',
            ],
            [
                'id' => 2,
                'title' => 'Master cyclist on tour',
            ],
            [
                'id' => 3,
                'title' => 'What goes around comes around, a look at alimunium wheels',
            ],
        ],
            json_decode((string)$response->getBody(), true)
        );
    }

    public function testGetAllYoutubeSearchReturnsExpectedResponseWithNoVideos()
    {
        $this->database()->exec('TRUNCATE TABLE videos');

        $response = $this->runApp(
            'GET',
            '/youtube-search'
        );

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals([], json_decode((string)$response->getBody(), true));
    }
}
