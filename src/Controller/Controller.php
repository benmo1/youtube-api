<?php

namespace MorrisPhp\YouTubeApi\Controller;

use MorrisPhp\YouTubeApi\Repository\ChannelRepository as ChannelRepository;
use MorrisPhp\YouTubeApi\Repository\VideoRepository as VideoRepository;
use MorrisPhp\YouTubeApi\YouTube\Service as YoutubeServiceWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller
{
    /**
     * @var YouTubeServiceWrapper
     */
    private $service;

    /**
     * @var ChannelRepository
     */
    private $channelRepository;

    /**
     * @var VideoRepository
     */
    private $videoRepository;

    /**
     * Controller constructor.
     * @param YouTubeServiceWrapper $service
     * @param ChannelRepository $channelRepository
     * @param VideoRepository $videoRepository
     */
    public function __construct(
        YouTubeServiceWrapper $service,
        ChannelRepository $channelRepository,
        VideoRepository $videoRepository
    ) {
        $this->service = $service;
        $this->channelRepository = $channelRepository;
        $this->videoRepository = $videoRepository;
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $channels = $this->channelRepository->getAll();

        foreach ($channels as $channel) {
            $id = $this->service->getIdForChannel($channel->getChannelName());

            $videos = $this->service->getVideosForChannel($id);

            foreach ($videos as $video) {
                $this->videoRepository->add($video);
            }
        }

        return $response->withStatus(200);
    }
}
