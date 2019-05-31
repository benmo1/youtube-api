<?php

namespace Tests\Functional;

class GeneralTest extends BaseTestCase
{
    public function testPostStoresVideos()
    {
        $this->runApp('POST', '/youtube-search');

        $videos = $this->database()
            ->query('SELECT * FROM videos')
            ->fetchAll();

        $this->assertNotEmpty($videos);
    }
}
