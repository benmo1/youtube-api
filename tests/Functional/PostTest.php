<?php

namespace Tests\Functional;

class PostTest extends BaseTestCase
{
    public function testPostStoresVideos()
    {
        $this->markTestSkipped('Uses live youtube api');

        $this->database()->exec('DELETE FROM videos');

        $this->runApp('POST', '/youtube-search');

        $videos = $this->database()
            ->query('SELECT * FROM videos')
            ->fetchAll();

        $this->assertNotEmpty($videos);
    }
}
