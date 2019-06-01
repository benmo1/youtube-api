<?php

namespace MorrisPhp\YouTubeApi\YouTube;

use Google_Service_YouTube;
use MorrisPhp\YouTubeApi\Model\Video;

class Service
{
    /**
     * Page size for getting videos from youtube
     * The max they allow is 50, use to reduce respone time
     */
    const PAGE_SIZE = 50;

    /**
     * @var Google_Service_YouTube
     */
    private $service;

    /**
     * @var string
     */
    private $filterPath;

    /**
     * @var string
     */
    private $queryString = '';

    /**
     * Service constructor.
     * @param Google_Service_YouTube $service
     * @param string $filterPath
     */
    public function __construct(Google_Service_YouTube $service, string $filterPath)
    {
        $this->service = $service;
        $this->filterPath = $filterPath;
    }

    /**
     * @param string $channelName
     * @return string - channelId
     */
    public function getIdForChannel(string $channelName)
    {
        $response = $this->service->channels->listChannels(
            'id',
            ['forUsername' => $channelName]
        );

        return $response->getItems()[0]->getId();
    }

    /**
     * @param string $channelId
     * @return array<Video>
     */
    public function getVideosForChannel(string $channelId)
    {
        $response = null;
        $videos = [];
        $i = 0;

        do {
            $response = $this->service->search->listSearch(
                'snippet',
                [
                    'channelId' => $channelId,
                    'maxResults' => self::PAGE_SIZE,
                    'type' => 'video',
                    'q' => $this->getQueryString(),
                    'pageToken' => $response ? $response->getNextPageToken() : ''
                ]
            );

            foreach ($response->getItems() as $searchResult) {
                $videos[] = new Video([
                    'title' => $searchResult->getSnippet()->getTitle(),
                    'date' => $searchResult->getSnippet()->getPublishedAt()
                ]);
            }
        } while ($response->getNextPageToken() && ($i++ < 20)); // To save our quota if there is a bug

        return $videos;
    }

    /**
     * @return array
     */
    public function getQueryString()
    {
        if (!$this->queryString) {
            $filters = explode(PHP_EOL, file_get_contents($this->filterPath));
            $this->queryString = implode('|', $filters);
        }

        return $this->queryString;
    }
}

