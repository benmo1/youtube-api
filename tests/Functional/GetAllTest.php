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
                    'title' => 'Bikes in the 21st Century',
                    'date' => '2019-04-23',
                    'id' => 1,
                ],
                [
                    'title' => 'Master cyclist on tour',
                    'date' => '2018-04-29',
                    'id' => 2,
                ],
                [
                    'title' => 'What goes around comes around, a look at alimunium wheels',
                    'date' => '2019-03-23',
                    'id' => 3,
                ],
            ],
            json_decode((string) $response->getBody(), true)
        );
    }
}
