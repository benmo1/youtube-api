<?php

namespace Tests\Functional;

class GetOneTest extends BaseTestCase
{
    /**
     * @dataProvider data
     */
    public function testGetOneYoutubeSearchReturnsExpectedResponse($id, $title, $date)
    {
        $response = $this->runApp(
            'GET',
            '/youtube-search/' . $id
        );

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(
            [
                'id' => $id,
                'title' => $title,
                'date' => $date,
            ],
            json_decode((string)$response->getBody(), true)
        );
    }

    public function testGetOneYoutubeSearchHandlesIdNotFound()
    {
        $response = $this->runApp(
            'GET',
            '/youtube-search/' . 1092329
        );

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function data()
    {
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
}