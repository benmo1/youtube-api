<?php

namespace MorrisPhp\YouTubeApi\YouTube;

use DateTime;
use Google_Service_YouTube;
use MorrisPhp\YouTubeApi\Model\Video;

class Service
{
    const BATCH_SIZE = 25;

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

        do {
            $response = $this->service->search->listSearch(
                'snippet',
                [
                    'channelId' => $channelId,
                    'maxResults' => 50,
                    'type' => 'video',
                    'q' => $this->getQueryString(),
                    'pageToken' => $response ? $response->getNextPageToken() : ''
                ]
            );

            foreach ($response->getItems() as $searchResult) {
                $videos[] = new Video(
                    $searchResult->getSnippet()->getTitle(),
                    new DateTime($searchResult->getSnippet()->getPublishedAt())
                );
            }
        } while ($response->getNextPageToken());

        return $videos;
    }
}
