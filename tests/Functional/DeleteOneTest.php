<?php

namespace Tests\Functional;

class DeleteOneTest extends BaseTestCase
{
    /**
     * @dataProvider data
     */
    public function testDeleteOneYoutubeSearchReturnsExpectedResponse($id, $title, $date)
    {
        $response = $this->runApp(
            'DELETE',
            '/youtube-search/' . $id
        );

        $this->assertEquals(204, $response->getStatusCode());

        $count = $this->database()
            ->query('SELECT COUNT(*) FROM videos WHERE id = ' . $id)
            ->fetchColumn();

        $this->assertEquals($count, 0);
    }

    public function testDeleteOneYoutubeSearchHandlesIdNotFound()
    {
        $response = $this->runApp(
            'DELETE',
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
